/* *
 *
 *  (c) 2010-2021 Torstein Honsi
 *
 *  License: www.highcharts.com/license
 *
 *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
 *
 * */
'use strict';
import ColorMapComposition from '../ColorMapComposition.js';
import MapUtilities from '../../Maps/MapUtilities.js';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
import U from '../../Core/Utilities.js';

const {boundsFromPath} = MapUtilities;

const {
// indirect dependency to keep product size low
    seriesTypes: {scatter: ScatterSeries}
} = SeriesRegistry;

const {extend, isNumber, pick} = U;

/* *
 *
 *  Class
 *
 * */
class MapPoint extends ScatterSeries.prototype.pointClass {
    constructor() {
        /* *
         *
         *  Properties
         *
         * */
        super(...arguments);
        this.options = void 0;
        this.path = void 0;
        this.series = void 0;
        /* eslint-enable valid-jsdoc */
    }

    /* *
     *
     *  Functions
     *
     * */
    /* eslint-disable valid-jsdoc */
    // Get the projected path based on the geometry. May also be called on
    // mapData options (not point instances), hence static.
    static getProjectedPath(point, projection) {
        if (!point.projectedPath) {
            if (projection && point.geometry) {
                // Always true when given GeoJSON coordinates
                projection.hasCoordinates = true;
                point.projectedPath = projection.path(point.geometry);
                // SVG path given directly in point options
            } else {
                point.projectedPath = point.path;
            }
        }
        return point.projectedPath || [];
    }

    /**
     * Extend the Point object to split paths.
     * @private
     */
    applyOptions(options, x) {
        const series = this.series, point = super.applyOptions.call(this, options, x), joinBy = series.joinBy;
        if (series.mapData && series.mapMap) {
            const joinKey = joinBy[1], mapKey = super.getNestedProperty.call(point, joinKey),
                mapPoint = typeof mapKey !== 'undefined' &&
                    series.mapMap[mapKey];
            if (mapPoint) {
                extend(point, mapPoint); // copy over properties
            } else if (series.pointArrayMap.indexOf('value') !== -1) {
                point.value = point.value || null;
            }
        }
        return point;
    }

    /*
     * Get the bounds in terms of projected units
     * @param projection
     * @return MapBounds|undefined The computed bounds
     */
    getProjectedBounds(projection) {
        const path = MapPoint.getProjectedPath(this, projection), bounds = boundsFromPath(path),
            properties = this.properties, mapView = this.series.chart.mapView;
        if (bounds) {
            // Cache point bounding box for use to position data labels, bubbles
            // etc
            const propMiddleLon = properties && properties['hc-middle-lon'],
                propMiddleLat = properties && properties['hc-middle-lat'];
            if (mapView && isNumber(propMiddleLon) && isNumber(propMiddleLat)) {
                const projectedPoint = projection.forward([propMiddleLon, propMiddleLat]);
                bounds.midX = projectedPoint[0];
                bounds.midY = projectedPoint[1];
            } else {
                const propMiddleX = properties && properties['hc-middle-x'],
                    propMiddleY = properties && properties['hc-middle-y'];
                bounds.midX = (bounds.x1 + (bounds.x2 - bounds.x1) * pick(this.middleX, isNumber(propMiddleX) ? propMiddleX : 0.5));
                let middleYFraction = pick(this.middleY, isNumber(propMiddleY) ? propMiddleY : 0.5);
                // No geographic geometry, only path given => flip
                if (!this.geometry) {
                    middleYFraction = 1 - middleYFraction;
                }
                bounds.midY =
                    bounds.y2 - (bounds.y2 - bounds.y1) * middleYFraction;
            }
            return bounds;
        }
    }

    /**
     * Stop the fade-out
     * @private
     */
    onMouseOver(e) {
        U.clearTimeout(this.colorInterval);
        if (
            // Valid...
            (!this.isNull && this.visible) ||
            // ... or interact anyway
            this.series.options.nullInteraction) {
            super.onMouseOver.call(this, e);
        } else {
            // #3401 Tooltip doesn't hide when hovering over null points
            this.series.onMouseOut(e);
        }
    }

    setVisible(vis) {
        const method = vis ? 'show' : 'hide';
        this.visible = this.options.visible = !!vis;
        // Show and hide associated elements
        if (this.dataLabel) {
            this.dataLabel[method]();
        }
        // For invisible map points, render them as null points rather than
        // fully removing them. Makes more sense for color axes with data
        // classes.
        if (this.graphic) {
            this.graphic.attr(this.series.pointAttribs(this));
        }
    }

    /**
     * Highmaps only. Zoom in on the point using the global animation.
     *
     * @sample maps/members/point-zoomto/
     *         Zoom to points from buttons
     *
     * @requires modules/map
     *
     * @function Highcharts.Point#zoomTo
     */
    zoomTo(animOptions) {
        const point = this, chart = point.series.chart, mapView = chart.mapView;
        let bounds = point.bounds;
        if (mapView && bounds) {
            const inset = isNumber(point.insetIndex) &&
                mapView.insets[point.insetIndex];
            if (inset) {
                // If in an inset, translate the bounds to pixels ...
                const px1 = inset.projectedUnitsToPixels({
                        x: bounds.x1,
                        y: bounds.y1
                    }), px2 = inset.projectedUnitsToPixels({
                        x: bounds.x2,
                        y: bounds.y2
                    }),
                    // ... then back to projected units in the main mapView
                    proj1 = mapView.pixelsToProjectedUnits({
                        x: px1.x,
                        y: px1.y
                    }), proj2 = mapView.pixelsToProjectedUnits({
                        x: px2.x,
                        y: px2.y
                    });
                bounds = {
                    x1: proj1.x,
                    y1: proj1.y,
                    x2: proj2.x,
                    y2: proj2.y
                };
            }
            mapView.fitToBounds(bounds, void 0, false);
            point.series.isDirty = true;
            chart.redraw(animOptions);
        }
    }
}

extend(MapPoint.prototype, {
    dataLabelOnNull: ColorMapComposition.pointMembers.dataLabelOnNull,
    moveToTopOnHover: ColorMapComposition.pointMembers.moveToTopOnHover,
    isValid: ColorMapComposition.pointMembers.isValid
});
/* *
 *
 *  Default Export
 *
 * */
export default MapPoint;
