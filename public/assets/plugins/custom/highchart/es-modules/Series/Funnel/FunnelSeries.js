/* *
 *
 *  Highcharts funnel module
 *
 *  (c) 2010-2021 Torstein Honsi
 *
 *  License: www.highcharts.com/license
 *
 *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
 *
 * */
'use strict';
import Chart from '../../Core/Chart/Chart.js';
import H from '../../Core/Globals.js';
import BorderRadius from '../../Extensions/BorderRadius.js';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
import U from '../../Core/Utilities.js';

const {noop} = H;

const {series: Series, seriesTypes: {pie: PieSeries}} = SeriesRegistry;

const {addEvent, extend, fireEvent, isArray, merge, pick, relativeLength} = U;

/**
 * @private
 * @class
 * @name Highcharts.seriesTypes.funnel
 *
 * @augments Highcharts.Series
 */
class FunnelSeries extends PieSeries {
    constructor() {
        /* *
         *
         *  Static Properties
         *
         * */
        super(...arguments);
        this.data = void 0;
        this.options = void 0;
        this.points = void 0;
        /* eslint-enable valid-jsdoc */
    }

    /* *
     *
     *  Functions
     *
     * */

    /* eslint-disable valid-jsdoc */
    /**
     * @private
     */
    alignDataLabel(point, dataLabel, options, alignTo, isNew) {
        let series = point.series, reversed = series.options.reversed, dlBox = point.dlBox || point.shapeArgs,
            align = options.align, verticalAlign = options.verticalAlign,
            inside = ((series.options || {}).dataLabels || {}).inside, centerY = series.center[1],
            pointPlotY = (reversed ?
                2 * centerY - point.plotY :
                point.plotY), widthAtLabel = series.getWidthAt(pointPlotY - dlBox.height / 2 +
                dataLabel.height), offset = verticalAlign === 'middle' ?
                (dlBox.topWidth - dlBox.bottomWidth) / 4 :
                (widthAtLabel - dlBox.bottomWidth) / 2, y = dlBox.y, x = dlBox.x;
        // #16176: Only SVGLabel has height set
        const dataLabelHeight = pick(dataLabel.height, dataLabel.getBBox().height);
        if (verticalAlign === 'middle') {
            y = dlBox.y - dlBox.height / 2 + dataLabelHeight / 2;
        } else if (verticalAlign === 'top') {
            y = dlBox.y - dlBox.height + dataLabelHeight +
                options.padding;
        }
        if (verticalAlign === 'top' && !reversed ||
            verticalAlign === 'bottom' && reversed ||
            verticalAlign === 'middle') {
            if (align === 'right') {
                x = dlBox.x - options.padding + offset;
            } else if (align === 'left') {
                x = dlBox.x + options.padding - offset;
            }
        }
        alignTo = {
            x: x,
            y: reversed ? y - dlBox.height : y,
            width: dlBox.bottomWidth,
            height: dlBox.height
        };
        options.verticalAlign = 'bottom';
        // Call the parent method
        if (!inside || point.visible) {
            Series.prototype.alignDataLabel.call(this, point, dataLabel, options, alignTo, isNew);
        }
        if (inside) {
            if (!point.visible && point.dataLabel) {
                // Avoid animation from top
                point.dataLabel.placed = false;
            }
            // If label is inside and we have contrast, set it:
            if (point.contrastColor) {
                dataLabel.css({
                    color: point.contrastColor
                });
            }
        }
    }

    /**
     * Extend the pie data label method.
     * @private
     */
    drawDataLabels() {
        let series = this, data = series.data, labelDistance = series.options.dataLabels.distance, leftSide, sign,
            point, i = data.length, x, y;
        // In the original pie label anticollision logic, the slots are
        // distributed from one labelDistance above to one labelDistance
        // below the pie. In funnels we don't want this.
        series.center[2] -= 2 * labelDistance;
        // Set the label position array for each point.
        while (i--) {
            point = data[i];
            leftSide = point.half;
            sign = leftSide ? 1 : -1;
            y = point.plotY;
            point.labelDistance = pick(point.options.dataLabels &&
                point.options.dataLabels.distance, labelDistance);
            series.maxLabelDistance = Math.max(point.labelDistance, series.maxLabelDistance || 0);
            x = series.getX(y, leftSide, point);
            // set the anchor point for data labels
            point.labelPosition = {
                // initial position of the data label - it's utilized for
                // finding the final position for the label
                natural: {
                    x: 0,
                    y: y
                },
                computed: {
                    // used for generating connector path -
                    // initialized later in drawDataLabels function
                    // x: undefined,
                    // y: undefined
                },
                // left - funnel on the left side of the data label
                // right - funnel on the right side of the data label
                alignment: leftSide ? 'right' : 'left',
                connectorPosition: {
                    breakAt: {
                        x: x + (point.labelDistance - 5) * sign,
                        y: y
                    },
                    touchingSliceAt: {
                        x: x + point.labelDistance * sign,
                        y: y
                    }
                }
            };
        }
        SeriesRegistry.seriesTypes[series.options.dataLabels.inside ? 'column' : 'pie'].prototype.drawDataLabels.call(this);
    }

    /**
     * Overrides the pie translate method.
     * @private
     */
    translate() {
        let sum = 0, series = this, chart = series.chart, options = series.options, reversed = options.reversed,
            ignoreHiddenPoint = options.ignoreHiddenPoint,
            borderRadiusObject = BorderRadius.optionsToObject(options.borderRadius), plotWidth = chart.plotWidth,
            plotHeight = chart.plotHeight, cumulative = 0, // start at top
            center = options.center, centerX = getLength(center[0], plotWidth),
            centerY = getLength(center[1], plotHeight), width = getLength(options.width, plotWidth), tempWidth,
            height = getLength(options.height, plotHeight), neckWidth = getLength(options.neckWidth, plotWidth),
            neckHeight = getLength(options.neckHeight, plotHeight),
            neckY = (centerY - height / 2) + height - neckHeight, data = series.data, path, fraction,
            borderRadius = relativeLength(borderRadiusObject.radius, width), radiusScope = borderRadiusObject.scope,
            alpha, // the angle between top and left point's edges
            maxT, roundingFactors = (angle) => {
                const tan = Math.tan(angle / 2), cosA = Math.cos(alpha), sinA = Math.sin(alpha);
                let r = borderRadius, t = r / tan, k = Math.tan((Math.PI - angle) / 3.2104);
                if (t > maxT) {
                    t = maxT;
                    r = t * tan;
                }
                k *= r;
                return {
                    dx: [t * cosA, (t - k) * cosA, t - k, t],
                    dy: [t * sinA, (t - k) * sinA, t - k, t]
                        .map((i) => (reversed ? -i : i))
                };
            }, half = (options.dataLabels.position === 'left' ?
                1 :
                0), x1, y1, x2, x3, y3, x4, y5;

        /**
         * Get positions - either an integer or a percentage string must be
         * given.
         * @private
         * @param {number|string|undefined} length
         *        Length
         * @param {number} relativeTo
         *        Relative factor
         * @return {number}
         *         Relative position
         */
        function getLength(length, relativeTo) {
            return (/%$/).test(length) ?
                relativeTo * parseInt(length, 10) / 100 :
                parseInt(length, 10);
        }

        series.getWidthAt = function (y) {
            const top = (centerY - height / 2);
            return (y > neckY || height === neckHeight) ?
                neckWidth :
                neckWidth + (width - neckWidth) *
                (1 - (y - top) / (height - neckHeight));
        };
        series.getX = function (y, half, point) {
            return centerX + (half ? -1 : 1) *
                ((series.getWidthAt(reversed ? 2 * centerY - y : y) / 2) +
                    point.labelDistance);
        };
        // Expose
        series.center = [centerX, centerY, height];
        series.centerX = centerX;
        /*
        Individual point coordinate naming:

        x1,y1 _________________ x2,y1
            \                         /
            \                       /
            \                     /
            \                   /
                \                 /
            x3,y3 _________ x4,y3

        Additional for the base of the neck:

                |               |
                |               |
                |               |
            x3,y5 _________ x4,y5

        */
        // get the total sum
        data.forEach(function (point) {
            if (point.y && point.isValid() &&
                (!ignoreHiddenPoint || point.visible !== false)) {
                sum += point.y;
            }
        });
        data.forEach(function (point) {
            // set start and end positions
            y5 = null;
            fraction = sum ? point.y / sum : 0;
            y1 = centerY - height / 2 + cumulative * height;
            y3 = y1 + fraction * height;
            tempWidth = series.getWidthAt(y1);
            x1 = centerX - tempWidth / 2;
            x2 = x1 + tempWidth;
            tempWidth = series.getWidthAt(y3);
            x3 = centerX - tempWidth / 2;
            x4 = x3 + tempWidth;
            // the entire point is within the neck
            if (y1 > neckY) {
                x1 = x3 = centerX - neckWidth / 2;
                x2 = x4 = centerX + neckWidth / 2;
                // the base of the neck
            } else if (y3 > neckY) {
                y5 = y3;
                tempWidth = series.getWidthAt(neckY);
                x3 = centerX - tempWidth / 2;
                x4 = x3 + tempWidth;
                y3 = neckY;
            }
            if (reversed) {
                y1 = 2 * centerY - y1;
                y3 = 2 * centerY - y3;
                if (y5 !== null) {
                    y5 = 2 * centerY - y5;
                }
            }
            if (borderRadius && (radiusScope === 'point' ||
                point.index === 0 ||
                point.index === data.length - 1 ||
                y5 !== null)) {
                // Creating the path of funnel points with rounded corners
                // (#18839)
                const h = Math.abs(y3 - y1), xSide = x2 - x4, lBase = x4 - x3, lSide = Math.sqrt(xSide * xSide + h * h);
                alpha = Math.atan(h / xSide);
                maxT = lSide / 2;
                if (y5 !== null) {
                    maxT = Math.min(maxT, Math.abs(y5 - y3) / 2);
                }
                if (lBase >= 1) {
                    maxT = Math.min(maxT, lBase / 2);
                }
                // Creating a point base
                let f = roundingFactors(alpha);
                if (radiusScope === 'stack' && point.index !== 0) {
                    path = [
                        ['M', x1, y1],
                        ['L', x2, y1]
                    ];
                } else {
                    path = [
                        ['M', x1 + f.dx[0], y1 + f.dy[0]],
                        ['C',
                            x1 + f.dx[1], y1 + f.dy[1],
                            x1 + f.dx[2], y1,
                            x1 + f.dx[3], y1
                        ],
                        ['L', x2 - f.dx[3], y1],
                        ['C',
                            x2 - f.dx[2], y1,
                            x2 - f.dx[1], y1 + f.dy[1],
                            x2 - f.dx[0], y1 + f.dy[0]
                        ]
                    ];
                }
                if (y5 !== null) {
                    // Closure of point with extension
                    const fr = roundingFactors(Math.PI / 2);
                    f = roundingFactors(Math.PI / 2 + alpha);
                    path.push(['L', x4 + f.dx[0], y3 - f.dy[0]], ['C',
                        x4 + f.dx[1], y3 - f.dy[1],
                        x4, y3 + f.dy[2],
                        x4, y3 + f.dy[3]
                    ]);
                    if (radiusScope === 'stack' &&
                        point.index !== data.length - 1) {
                        path.push(['L', x4, y5], ['L', x3, y5]);
                    } else {
                        path.push(['L', x4, y5 - fr.dy[3]], ['C',
                            x4, y5 - fr.dy[2],
                            x4 - fr.dx[2], y5,
                            x4 - fr.dx[3], y5
                        ], ['L', x3 + fr.dx[3], y5], ['C',
                            x3 + fr.dx[2], y5,
                            x3, y5 - fr.dy[2],
                            x3, y5 - fr.dy[3]
                        ]);
                    }
                    path.push(['L', x3, y3 + f.dy[3]], ['C',
                        x3, y3 + f.dy[2],
                        x3 - f.dx[1], y3 - f.dy[1],
                        x3 - f.dx[0], y3 - f.dy[0]
                    ]);
                } else if (lBase >= 1) {
                    // Closure of point without extension
                    f = roundingFactors(Math.PI - alpha);
                    if (radiusScope === 'stack' && point.index === 0) {
                        path.push(['L', x4, y3], ['L', x3, y3]);
                    } else {
                        path.push(['L', x4 + f.dx[0], y3 - f.dy[0]], ['C',
                            x4 + f.dx[1], y3 - f.dy[1],
                            x4 - f.dx[2], y3,
                            x4 - f.dx[3], y3
                        ], ['L', x3 + f.dx[3], y3], ['C',
                            x3 + f.dx[2], y3,
                            x3 - f.dx[1], y3 - f.dy[1],
                            x3 - f.dx[0], y3 - f.dy[0]
                        ]);
                    }
                } else {
                    // Creating a rounded tip of the "pyramid"
                    f = roundingFactors(Math.PI - alpha * 2);
                    path.push(['L', x3 + f.dx[0], y3 - f.dy[0]], ['C',
                        x3 + f.dx[1], y3 - f.dy[1],
                        x3 - f.dx[1], y3 - f.dy[1],
                        x3 - f.dx[0], y3 - f.dy[0]
                    ]);
                }
            } else {
                // Creating the path of funnel points without rounded corners
                path = [
                    ['M', x1, y1],
                    ['L', x2, y1],
                    ['L', x4, y3]
                ];
                if (y5 !== null) {
                    path.push(['L', x4, y5], ['L', x3, y5]);
                }
                path.push(['L', x3, y3]);
            }
            path.push(['Z']);
            // prepare for using shared dr
            point.shapeType = 'path';
            point.shapeArgs = {d: path};
            // for tooltips and data labels
            point.percentage = fraction * 100;
            point.plotX = centerX;
            point.plotY = (y1 + (y5 || y3)) / 2;
            // Placement of tooltips and data labels
            point.tooltipPos = [
                centerX,
                point.plotY
            ];
            point.dlBox = {
                x: x3,
                y: y1,
                topWidth: x2 - x1,
                bottomWidth: x4 - x3,
                height: Math.abs(pick(y5, y3) - y1),
                width: NaN
            };
            // Slice is a noop on funnel points
            point.slice = noop;
            // Mimicking pie data label placement logic
            point.half = half;
            if (point.isValid() &&
                (!ignoreHiddenPoint || point.visible !== false)) {
                cumulative += fraction;
            }
        });
        fireEvent(series, 'afterTranslate');
    }

    /**
     * Funnel items don't have angles (#2289).
     * @private
     */
    sortByAngle(points) {
        points.sort(function (a, b) {
            return a.plotY - b.plotY;
        });
    }
}

/**
 * Funnel charts are a type of chart often used to visualize stages in a
 * sales project, where the top are the initial stages with the most
 * clients. It requires that the modules/funnel.js file is loaded.
 *
 * @sample highcharts/demo/funnel/
 *         Funnel demo
 *
 * @extends      plotOptions.pie
 * @excluding    innerSize,size,dataSorting
 * @product      highcharts
 * @requires     modules/funnel
 * @optionparent plotOptions.funnel
 */
FunnelSeries.defaultOptions = merge(PieSeries.defaultOptions, {
    /**
     * Initial animation is by default disabled for the funnel chart.
     */
    animation: false,
    /**
     * The corner radius of the border surrounding all points or series. A
     * number signifies pixels. A percentage string, like for example `50%`,
     * signifies a size relative to the series width.
     *
     * @sample highcharts/plotoptions/funnel-border-radius
     *         Funnel and pyramid with rounded border
     */
    borderRadius: 0,
    /**
     * The center of the series. By default, it is centered in the middle
     * of the plot area, so it fills the plot area height.
     *
     * @type    {Array<number|string>}
     * @default ["50%", "50%"]
     * @since   3.0
     */
    center: ['50%', '50%'],
    /**
     * The width of the funnel compared to the width of the plot area,
     * or the pixel width if it is a number.
     *
     * @type  {number|string}
     * @since 3.0
     */
    width: '90%',
    /**
     * The width of the neck, the lower part of the funnel. A number defines
     * pixel width, a percentage string defines a percentage of the plot
     * area width.
     *
     * @sample {highcharts} highcharts/demo/funnel/
     *         Funnel demo
     *
     * @type  {number|string}
     * @since 3.0
     */
    neckWidth: '30%',
    /**
     * The height of the funnel or pyramid. If it is a number it defines
     * the pixel height, if it is a percentage string it is the percentage
     * of the plot area height.
     *
     * @sample {highcharts} highcharts/demo/funnel/
     *         Funnel demo
     *
     * @type  {number|string}
     * @since 3.0
     */
    height: '100%',
    /**
     * The height of the neck, the lower part of the funnel. A number
     * defines pixel width, a percentage string defines a percentage of the
     * plot area height.
     *
     * @type {number|string}
     */
    neckHeight: '25%',
    /**
     * A reversed funnel has the widest area down. A reversed funnel with
     * no neck width and neck height is a pyramid.
     *
     * @since 3.0.10
     */
    reversed: false,
    /**
     * To avoid adapting the data label size in Pie.drawDataLabels.
     * @ignore-option
     */
    size: true,
    dataLabels: {
        connectorWidth: 1,
        verticalAlign: 'middle'
    },
    /**
     * Options for the series states.
     */
    states: {
        /**
         * @excluding halo, marker, lineWidth, lineWidthPlus
         * @apioption plotOptions.funnel.states.hover
         */
        /**
         * Options for a selected funnel item.
         *
         * @excluding halo, marker, lineWidth, lineWidthPlus
         */
        select: {
            /**
             * A specific color for the selected point.
             *
             * @type {Highcharts.ColorString|Highcharts.GradientColorObject|Highcharts.PatternObject}
             */
            color: "#cccccc" /* Palette.neutralColor20 */,
            /**
             * A specific border color for the selected point.
             *
             * @type {Highcharts.ColorString}
             */
            borderColor: "#000000" /* Palette.neutralColor100 */
        }
    }
});
extend(FunnelSeries.prototype, {
    animate: noop
});
/* *
 *
 *  Hack
 *
 * */
/* eslint-disable no-invalid-this */
addEvent(Chart, 'afterHideAllOverlappingLabels', function () {
    this.series.forEach(function (series) {
        let dataLabelsOptions = series.options && series.options.dataLabels;
        if (isArray(dataLabelsOptions)) {
            dataLabelsOptions = dataLabelsOptions[0];
        }
        if (series.is('pie') &&
            series.placeDataLabels &&
            dataLabelsOptions &&
            !dataLabelsOptions.inside) {
            series.placeDataLabels();
        }
    });
});
SeriesRegistry.registerSeriesType('funnel', FunnelSeries);
/* *
 *
 *  Default Export
 *
 * */
export default FunnelSeries;
/* *
 *
 *  API Options
 *
 * */
/**
 * A `funnel` series. If the [type](#series.funnel.type) option is
 * not specified, it is inherited from [chart.type](#chart.type).
 *
 * @extends   series,plotOptions.funnel
 * @excluding dataParser, dataURL, stack, xAxis, yAxis, dataSorting,
 *            boostBlending, boostThreshold
 * @product   highcharts
 * @requires  modules/funnel
 * @apioption series.funnel
 */
/**
 * An array of data points for the series. For the `funnel` series type,
 * points can be given in the following ways:
 *
 * 1.  An array of numerical values. In this case, the numerical values
 * will be interpreted as `y` options. Example:
 *
 *  ```js
 *  data: [0, 5, 3, 5]
 *  ```
 *
 * 2.  An array of objects with named values. The following snippet shows only a
 * few settings, see the complete options set below. If the total number of data
 * points exceeds the series' [turboThreshold](#series.funnel.turboThreshold),
 * this option is not available.
 *
 *  ```js
 *     data: [{
 *         y: 3,
 *         name: "Point2",
 *         color: "#00FF00"
 *     }, {
 *         y: 1,
 *         name: "Point1",
 *         color: "#FF00FF"
 *     }]
 *  ```
 *
 * @sample {highcharts} highcharts/chart/reflow-true/
 *         Numerical values
 * @sample {highcharts} highcharts/series/data-array-of-arrays/
 *         Arrays of numeric x and y
 * @sample {highcharts} highcharts/series/data-array-of-arrays-datetime/
 *         Arrays of datetime x and y
 * @sample {highcharts} highcharts/series/data-array-of-name-value/
 *         Arrays of point.name and y
 * @sample {highcharts} highcharts/series/data-array-of-objects/
 *         Config objects
 *
 * @type      {Array<number|null|*>}
 * @extends   series.pie.data
 * @excluding sliced
 * @product   highcharts
 * @apioption series.funnel.data
 */
''; // keeps doclets above in transpiled file
