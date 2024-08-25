<script>
    document.addEventListener('DOMContentLoaded', function() {
        var element = document.getElementById('kt_apexcharts_1');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-primary');
        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

        if (!element) {
            return;
        }

        fetch("{{ route('landpage.chart.bar.dosen') }}")
            .then(response => response.json())
            .then(data => {
                var categories = data.map(item => item.fakultas);
                var lectureData = data.map(item => item.lecture);
                var asistenAhliData = data.map(item => item['asisten ahli']);
                var lektorData = data.map(item => item.lektor);
                var lektorKepalaData = data.map(item => item['lektor kepala']);
                var guruBesarData = data.map(item => item['guru besar']);

                var options = {
                    series: [{
                        name: 'Lecture',
                        data: lectureData
                    }, {
                        name: 'Asisten Ahli',
                        data: asistenAhliData
                    }, {
                        name: 'Lektor',
                        data: lektorData
                    }, {
                        name: 'Lektor Kepala',
                        data: lektorKepalaData
                    }, {
                        name: 'Guru Besar',
                        data: guruBesarData
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: categories,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' dosen'
                            }
                        }
                    },
                    colors: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1',
                    '#33FFDA'], // Variasi warna yang lebih menarik
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var element = document.getElementById('kt_apexcharts_2');
        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-primary');
        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

        fetch("{{ route('landpage.chart.pie.dosen') }}")
            .then(response => response.json())
            .then(data => {
                var labels = data.map(item => item.nama_fakultas);
                var series = data.map(item => item.presentase);
                var dosenCounts = data.map(item => item.jumlah_dosen);

                var options = {
                    series: series,
                    chart: {
                        type: 'pie',
                        height: height
                    },
                    labels: labels,
                    colors: [
                        '#FF5733', '#33FF57', '#3357FF', '#F033FF',
                        '#FF33A1', '#33FFA5', '#FF8C33', '#33FFF5'
                    ],
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: labelColor
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.globals.labels[opts.seriesIndex] + ": " + val.toFixed(2) +
                                "%"
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val, opts) {
                                return dosenCounts[opts.seriesIndex] + ' dosen';
                            }
                        }
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: true
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
