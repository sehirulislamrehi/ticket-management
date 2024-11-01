<script>
    function sync_over_time_report() {
        spinner.removeAttribute('hidden');
        const task_counting_route = "{{ route('dashboard.over.time.report') }}"
        fetch(task_counting_route)
            .then(response => response.json())
            .then(response => {
                if (response.status == "success") {

                    let complaint_submitted = Array();
                    let total_resolved = Array();
                    let total_closed = Array();
                    let time = Array();

                    response.data.map((value, key) => {
                        complaint_submitted.push(value.complaint_submitted)
                        total_resolved.push(value.total_resolved)
                        total_closed.push(value.total_closed)
                        time.push(`${value.month}, ${value.year}`)
                    })

                    var options = {
                        series: [{
                            name: 'Complaint Submitted',
                            type: 'column',
                            data: complaint_submitted
                        }, {
                            name: 'Resolved',
                            type: 'column',
                            data: total_resolved
                        }, {
                            name: 'Closed',
                            type: 'column',
                            data: total_closed
                        }],
                        chart: {
                            height: 350,
                            type: 'line', // Mixed chart with line and columns
                        },
                        stroke: {
                            width: [0, 4]
                        },
                        dataLabels: {
                            enabled: true,
                            enabledOnSeries: [1]
                        },
                        labels: time,
                        xaxis: {
                            categories: time,
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

                    const options2 = {
                        series: [{
                            name: 'Resolved',
                            data: total_resolved
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            }
                        },
                        colors: ['#FFA07A'], // Color for ratio line
                        dataLabels: {
                            enabled: false, // Show data labels
                            formatter: function(val) {
                                return val + " %"; // Format for data labels
                            }
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // Background color for grid rows
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: time,
                            title: {
                                text: 'Times'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Resolve count'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        }
                    };


                    var chart = new ApexCharts(document.querySelector("#over_time_report"), options);
                    chart.render();

                    chart2 = new ApexCharts(document.querySelector("#resolved_ratio_report"), options2);
                    chart2.render();

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