/* *
 *
 *  This module implements sunburst charts in Highcharts.
 *
 *  (c) 2016-2021 Highsoft AS
 *
 *  Authors: Jon Arild Nygard
 *
 *  License: www.highcharts.com/license
 *
 *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
 *
 * */
'use strict';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
import U from '../../Core/Utilities.js';

const {seriesTypes: {treemap: TreemapSeries}} = SeriesRegistry;

const {isNumber, isObject, merge} = U;
/* *
 *
 *  Namespace
 *
 * */
var SunburstUtilities;
(function (SunburstUtilities) {
    /* *
     *
     *  Constants
     *
     * */
    SunburstUtilities.recursive = TreemapSeries.prototype.utils.recursive;
    /* *
     *
     *  Functions
     *
     * */

    /* eslint-disable valid-jsdoc */
    /**
     * @private
     * @function calculateLevelSizes
     *
     * @param {Object} levelOptions
     * Map of level to its options.
     *
     * @param {Highcharts.Dictionary<number>} params
     * Object containing number parameters `innerRadius` and `outerRadius`.
     *
     * @return {Highcharts.SunburstSeriesLevelsOptions|undefined}
     * Returns the modified options, or undefined.
     */
    function calculateLevelSizes(levelOptions, params) {
        let result, p = isObject(params) ? params : {}, totalWeight = 0, diffRadius, levels, levelsNotIncluded,
            remainingSize, from, to;
        if (isObject(levelOptions)) {
            result = merge({}, levelOptions);
            from = isNumber(p.from) ? p.from : 0;
            to = isNumber(p.to) ? p.to : 0;
            levels = range(from, to);
            levelsNotIncluded = Object.keys(result).filter(function (k) {
                return levels.indexOf(+k) === -1;
            });
            diffRadius = remainingSize = isNumber(p.diffRadius) ?
                p.diffRadius : 0;
            // Convert percentage to pixels.
            // Calculate the remaining size to divide between "weight" levels.
            // Calculate total weight to use in convertion from weight to
            // pixels.
            levels.forEach(function (level) {
                const options = result[level], unit = options.levelSize.unit, value = options.levelSize.value;
                if (unit === 'weight') {
                    totalWeight += value;
                } else if (unit === 'percentage') {
                    options.levelSize = {
                        unit: 'pixels',
                        value: (value / 100) * diffRadius
                    };
                    remainingSize -= options.levelSize.value;
                } else if (unit === 'pixels') {
                    remainingSize -= value;
                }
            });
            // Convert weight to pixels.
            levels.forEach(function (level) {
                let options = result[level], weight;
                if (options.levelSize.unit === 'weight') {
                    weight = options.levelSize.value;
                    result[level].levelSize = {
                        unit: 'pixels',
                        value: (weight / totalWeight) * remainingSize
                    };
                }
            });
            // Set all levels not included in interval [from,to] to have 0
            // pixels.
            levelsNotIncluded.forEach(function (level) {
                result[level].levelSize = {
                    value: 0,
                    unit: 'pixels'
                };
            });
        }
        return result;
    }

    SunburstUtilities.calculateLevelSizes = calculateLevelSizes;

    /**
     * @private
     */
    function getLevelFromAndTo({level, height}) {
        //  Never displays level below 1
        const from = level > 0 ? level : 1;
        const to = level + height;
        return {from, to};
    }

    SunburstUtilities.getLevelFromAndTo = getLevelFromAndTo;

    /**
     * TODO introduce step, which should default to 1.
     * @private
     */
    function range(from, to) {
        let result = [], i;
        if (isNumber(from) && isNumber(to) && from <= to) {
            for (i = from; i <= to; i++) {
                result.push(i);
            }
        }
        return result;
    }

    SunburstUtilities.range = range;
    /* eslint-enable valid-jsdoc */
})(SunburstUtilities || (SunburstUtilities = {}));
/* *
 *
 *  Default Export
 *
 * */
export default SunburstUtilities;
