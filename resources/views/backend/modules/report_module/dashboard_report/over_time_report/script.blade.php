<script>
    function sync_over_time_report() {
        spinner.removeAttribute('hidden');
        const task_counting_route = "{{ route('dashboard.over.time.report') }}"
        fetch(task_counting_route)
            .then(response => response.json())
            .then(response => {
                if (response.status == "success") {
                    var options = {
                        series: [{
                            name: 'Total Complaints',
                            type: 'column',
                            data: [150, 180, 200] // Total Complaints data for This Month, Last Month, and 2 Months Ago
                        }, {
                            name: 'Resolved',
                            type: 'column',
                            data: [100, 120, 150] // Resolved data for This Month, Last Month, and 2 Months Ago
                        }, {
                            name: 'Closed',
                            type: 'column',
                            data: [70, 90, 130] // Closed data for This Month, Last Month, and 2 Months Ago
                        }],
                        chart: {
                            height: 350,
                            type: 'line', // Mixed chart with line and columns
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%',
                                endingShape: 'rounded'
                            }
                        },
                        stroke: {
                            width: [1, 1, 1]
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        labels: ['This Month', 'Last Month', '2 Months Ago'], // Labels for each month
                        xaxis: {
                            categories: ['This Month', 'Last Month', '2 Months Ago'], // X-axis labels
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Complaints'
                            }
                        },
                        legend: {
                            position: 'top'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#over_time_report"), options);
                    chart.render();



                } else {
                    console.log(response)
                }
                spinner.setAttribute('hidden', '');
            })
            .catch(response => {
                console.log(response)
                spinner.setAttribute('hidden', '');
            })
    }
    sync_over_time_report();
</script>