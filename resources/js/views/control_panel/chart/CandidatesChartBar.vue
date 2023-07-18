<template>
    <div class="container">
        <section id="chartSection" v-if="loadChart">
            <div class="row align-items-center">
                <div class="col-lg-12 mb-5">
                    <div class="card rounded-4 shadow">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="fw-bold text-primary">Grafik Kandidat</h2>
                            </div>
                            <apexchart ref="bar" type="bar" :options="chart.bar.options" :series="chart.bar.series"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-5">
                    <div class="card rounded-4 shadow">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="fw-bold text-primary">Grafik Kandidat</h2>
                            </div>
                            <apexchart ref="donut" type="donut" :options="chart.donut.options" :series="chart.donut.series"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card rounded-4 shadow">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="fw-bold text-primary">Melakukan Voting</h2>
                            </div>
                            <apexchart ref="voted" type="donut" :options="chart.voted.options" :series="chart.voted.series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Vue from 'vue'
import VueApexCharts from 'vue-apexcharts'
import axios from 'axios'
import Pusher from 'pusher-js'
Vue.use(VueApexCharts)
export default {
    name: 'CandidatesChart',
    components: {
        apexchart: VueApexCharts
    },
    data() {
        return {
            loadChart: false,
            chart: {
                bar: {
                    options: {
                        chart: {
                            toolbar: {
                                show: false
                            },
                            fontFamily: 'Rubik, sans-serif'
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '16px'
                        },
                        theme: {
                            palette: 'palette1' // upto palette10
                        },
                        plotOptions: {
                            bar: {
                                distributed: true
                            }
                        },
                        xaxis: {
                            categories: [],
                            labels: {
                                show: false
                            }
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    series: [
                        {
                            name: 'Total Suara',
                            data: []
                        }
                    ]
                },
                donut: {
                    options: {
                        chart: {
                            toolbar: {
                                show: false
                            },
                            fontFamily: 'Rubik, sans-serif'
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '14px'
                        },
                        theme: {
                            palette: 'palette1' // upto palette10
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true
                                    }
                                }
                                // customScale: 0.9
                            }
                        },
                        labels: []
                    },
                    series: []
                },
                voted: {
                    options: {
                        colors: ['#00DFA2', '#F24C3D'],
                        chart: {
                            toolbar: {
                                show: false
                            },
                            fontFamily: 'Rubik, sans-serif'
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '14px'
                        },
                        theme: {
                            palette: 'palette1' // upto palette10
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true
                                    }
                                }
                                // customScale: 0.9
                            }
                        },
                        labels: ['Sudah Vote', 'Belum Vote']
                    },
                    series: []
                }
            }
        }
    },
    mounted() {
        this.getChartData()
        let pusher = new Pusher('5d2754fa29b9a0ac1c80', {
            cluster: 'ap1'
        })
        var channel = pusher.subscribe('my-channel')
        let setChart = (data) => {
            // Updating bar chart
            this.chart.bar.series = [
                {
                    data: data.results.score
                }
            ]
            // this.chart.bar.options.colors = data.results.color
            this.$refs.bar.updateOptions({
                xaxis: {
                    categories: data.results.label
                }
            })

            // Updating donut chart
            this.chart.donut.series = data.results.score
            this.$refs.donut.updateOptions({
                labels: data.results.label
            })

            // Update voted chart
            this.chart.voted.series = data.results.voted
        }
        channel.bind('my-event', function (data) {
            setChart(data)
        })
    },
    methods: {
        getChartData() {
            axios
                .get('/api/v1/quick-count')
                .then((response) => {
                    this.chart.bar.series = [
                        {
                            data: response.data.results.score
                        }
                    ]
                    this.chart.bar.options.colors = response.data.results.color
                    setTimeout(() => {
                        this.$refs.bar.updateOptions({
                            xaxis: {
                                categories: response.data.results.label
                            }
                        })
                    }, 500)

                    this.chart.donut.series = response.data.results.score
                    this.chart.donut.options.colors = response.data.results.color
                    setTimeout(() => {
                        this.$refs.donut.updateOptions({
                            labels: response.data.results.label
                        })
                    }, 500)

                    this.chart.voted.series = response.data.results.voted
                    this.loadChart = true
                })
                .catch((error) => {
                    this.loadChart = false
                    console.log(error)
                    alert('Error: Failed to get quick count data.')
                })
        }
    }
}
</script>
