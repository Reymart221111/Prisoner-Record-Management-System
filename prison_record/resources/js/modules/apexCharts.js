//apexChart.js
export const initializePrisonCharts = (chartData) => {
    // Security Level Distribution Chart
    const securityChart = new ApexCharts(document.querySelector("#securityLevelChart"), {
        series: Object.values(chartData.securityLevelDistribution),
        chart: {
            type: 'donut',
            height: 350
        },
        labels: Object.keys(chartData.securityLevelDistribution),
        colors: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    });

    // Monthly Admissions Chart
    const admissionsChart = new ApexCharts(document.querySelector("#monthlyAdmissionsChart"), {
        series: [{
            name: 'Admissions',
            data: chartData.monthlyAdmissions.counts
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: chartData.monthlyAdmissions.months
        },
        colors: ['#3B82F6']
    });

    // Prisoner Trends Chart
    const trendsChart = new ApexCharts(document.querySelector("#prisonerTrendsChart"), {
        series: [{
            name: 'Admissions',
            data: chartData.prisonerTrends.map(t => t.admissions)
        }, {
            name: 'Releases',
            data: chartData.prisonerTrends.map(t => t.releases)
        }, {
            name: 'Escapees',
            data: chartData.prisonerTrends.map(t => t.escapees)
        }, {
            name: 'Deceases',
            data: chartData.prisonerTrends.map(t => t.deceases)
        },  {
            name: 'Transferees',
            data: chartData.prisonerTrends.map(t => t.transferees)
        }],
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        xaxis: {
            categories: chartData.prisonerTrends.map(t => t.month)
        },
        colors: ['#3B82F6', '#EF4444', '#a17074', '#1ecf0e', '#ede60e']
    });

    // Medical Cases Chart
    const medicalChart = new ApexCharts(document.querySelector("#medicalCasesChart"), {
        series: [{
            name: 'Cases',
            data: chartData.medicalCaseTypes.counts
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 4,
                dataLabels: {
                    position: 'center',
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val
            },
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
        xaxis: {
            categories: chartData.medicalCaseTypes.conditions,
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        colors: ['#10B981'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + ' cases'
                }
            }
        }
    });

    // Render all charts remain the same
    securityChart.render();
    admissionsChart.render();
    trendsChart.render();
    medicalChart.render();

    // Update the Livewire event listener
    Livewire.on('chartDataUpdated', (newChartData) => {
        securityChart.updateOptions({
            series: Object.values(newChartData.securityLevelDistribution),
            labels: Object.keys(newChartData.securityLevelDistribution)
        });

        admissionsChart.updateSeries([{
            data: newChartData.monthlyAdmissions.counts
        }]);

        trendsChart.updateSeries([{
            data: newChartData.prisonerTrends.map(t => t.admissions)
        }, {
            data: newChartData.prisonerTrends.map(t => t.releases)
        }]);

        // Update medical chart with new data
        medicalChart.updateSeries([{
            name: 'Cases',
            data: newChartData.medicalCaseTypes.counts
        }]);

        medicalChart.updateOptions({
            xaxis: {
                categories: newChartData.medicalCaseTypes.conditions
            }
        });
    });

    // Return chart instances if needed
    return {
        securityChart,
        admissionsChart,
        trendsChart,
        medicalChart
    };
};