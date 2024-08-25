/* *
 *
 *  (c) 2009-2022 Øystein Moseng
 *
 *  Small MIDI file writer for sonification export.
 *
 *  License: www.highcharts.com/license
 *
 *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
 *
 * */
/* eslint-disable no-multi-spaces */
'use strict';
import SonificationInstrument from './SonificationInstrument.js';
import U from '../../Core/Utilities.js';

const {pick} = U;
const freqToNote = (f) => Math.round(12 * Math.log(f) / Math.LN2 - 48.37632), b = (byte, n) => n >>> 8 * byte & 0xFF,
    getHeader = (nTracks) => [
        0x4D, 0x54, 0x68, 0x64,
        0, 0, 0, 6,
        0, nTracks > 1 ? 1 : 0,
        b(1, nTracks), b(0, nTracks),
        // SMTPE: 0xE7 0x28
        // -25/40 time div gives us millisecond SMTPE, but not widely supported.
        1, 0xF4 // HD_TIMEDIV, 500 ticks per beat = millisecond at 120bpm
    ], timeInfo = [0, 0xFF, 0x51, 0x03, 0x07, 0xA1, 0x20], // META_TEMPO
    varLenEnc = (n) => {
        let buf = n & 0x7F;
        const res = [];
        while (n >>= 7) { // eslint-disable-line no-cond-assign
            buf <<= 8;
            buf |= (n & 0x7F) | 0x80;
        }
        while (true) { // eslint-disable-line no-constant-condition
            res.push(buf & 0xFF);
            if (buf & 0x80) {
                buf >>= 8;
            } else {
                break;
            }
        }
        return res;
    }, toMIDIEvents = (events) => {
        let cachedVel, cachedDur;
        const res = [], add = (el) => {
            let ix = res.length;
            while (ix-- && res[ix].timeMS > el.timeMS) { /* */
            }
            res.splice(ix + 1, 0, el);
        };
        events.forEach((e) => {
            const o = e.instrumentEventOptions || {}, t = e.time, dur = cachedDur = pick(o.noteDuration, cachedDur),
                tNOF = dur && e.time + dur, ctrl = [{
                    valMap: (n) => 64 + 63 * n & 0x7F,
                    data: {
                        0x0A: o.pan,
                        0x5C: o.tremoloDepth,
                        0x5D: o.tremoloSpeed
                    }
                }, {
                    valMap: (n) => 127 * n / 20000 & 0x7F,
                    data: {
                        0x4A: o.lowpassFreq,
                        0x4B: o.highpassFreq
                    }
                }, {
                    valMap: (n) => 63 * Math.min(18, Math.max(-18, n)) / 18 + 63 & 0x7F,
                    data: {
                        0x47: o.lowpassResonance,
                        0x4C: o.highpassResonance
                    }
                }], v = cachedVel = o.volume === void 0 ?
                    pick(cachedVel, 127) : 127 * o.volume & 0x7F, freq = o.frequency, note = o.note || 0,
                noteVal = 12 + (freq ? freqToNote(freq) : // MIDI note #0 is C-1
                    typeof note === 'string' ? SonificationInstrument
                        .noteStringToC0Distance(note) : note) & 0x7F;
            // CTRL_CHANGE events
            ctrl.forEach((ctrlDef) => Object.keys(ctrlDef.data)
                .forEach((ctrlSignal) => {
                    const val = ctrlDef.data[ctrlSignal];
                    if (val !== void 0) {
                        add({
                            timeMS: t,
                            type: 'CTRL_CHG',
                            data: [0xB0, parseInt(ctrlSignal, 10),
                                ctrlDef.valMap(val)]
                        });
                    }
                }));
            // NON/NOF
            if (tNOF) {
                add({timeMS: t, type: 'NON', data: [0x90, noteVal, v]});
                add({timeMS: tNOF, type: 'NOF', data: [0x80, noteVal, v]});
            }
        });
        return res;
    }, getMetaEvents = (midiTrackName, midiInstrument) => {
        const events = [];
        if (midiInstrument) {
            // Program Change MIDI event
            events.push(0, 0xC0, midiInstrument & 0x7F);
        }
        if (midiTrackName) {
            // Track name meta event
            const textArr = [];
            for (let i = 0; i < midiTrackName.length; ++i) {
                const code = midiTrackName.charCodeAt(i);
                if (code < 128) { // Keep ASCII only
                    textArr.push(code);
                }
            }
            return events.concat([0, 0xFF, 0x03], varLenEnc(textArr.length), textArr);
        }
        return events;
    }, getTrackChunk = (events, addTimeInfo, midiTrackName, midiInstrument) => {
        let prevTime = 0;
        const metaEvents = getMetaEvents(midiTrackName, midiInstrument),
            trackEvents = toMIDIEvents(events).reduce((data, e) => {
                const t = varLenEnc(e.timeMS - prevTime);
                prevTime = e.timeMS;
                return data.concat(t, e.data);
            }, []);
        const trackEnd = [0, 0xFF, 0x2F, 0], size = (addTimeInfo ? timeInfo.length : 0) +
            metaEvents.length +
            trackEvents.length + trackEnd.length;
        return [
            0x4D, 0x54, 0x72, 0x6B,
            b(3, size), b(2, size),
            b(1, size), b(0, size)
        ].concat(addTimeInfo ? timeInfo : [], metaEvents, trackEvents, trackEnd // SYSEX_TRACK_END
        );
    };

/**
 * Get MIDI data from a set of Timeline instrument channels.
 *
 * Outputs multi-track MIDI for Timelines with multiple channels.
 *
 * @private
 */
function toMIDI(channels) {
    const channelsToAdd = channels.filter((c) => !!c.events.length), numCh = channelsToAdd.length, multiCh = numCh > 1;
    return new Uint8Array(getHeader(multiCh ? numCh + 1 : numCh).concat(multiCh ? getTrackChunk([], true) : [], // Time info only
        channelsToAdd.reduce((chunks, channel) => {
            const engine = channel.engine;
            return chunks.concat(getTrackChunk(channel.events, !multiCh, engine.midiTrackName, engine.midiInstrument));
        }, [])));
}

export default toMIDI;
