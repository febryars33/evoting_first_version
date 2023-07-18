<template>
    <div class="container">
        <div class="col-lg-4 mx-auto">
            <div class="text-center mb-5">
                <h1 class="fw-bold text-primary">Realtime Chart</h1>
                <p>
                    Berikut adalah grafik skor sementara calon ketua BEM periode
                    berikutnya di kampus STMIK Bandung
                </p>
            </div>
        </div>
        <section id="chartSection" v-if="loadChart">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <apexchart
                        ref="bar"
                        type="bar"
                        :options="chart.bar.options"
                        :series="chart.bar.series"
                    ></apexchart>
                </div>
                <div class="col-lg-6">
                    <apexchart
                        ref="donut"
                        type="donut"
                        :options="chart.donut.options"
                        :series="chart.donut.series"
                    ></apexchart>
                </div>
            </div>
            <div class="text-center mt-5">
                <button
                    type="button"
                    class="btn btn-outline-primary border-2 px-4"
                    @click="enableFullscreen()"
                >
                    <i class="bi bi-fullscreen me-2" /> Aktifkan Layar Penuh
                </button>
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
    name: 'QuickCount',
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
                    }, 100)

                    this.chart.donut.series = response.data.results.score
                    this.chart.donut.options.colors =
                        response.data.results.color
                    setTimeout(() => {
                        this.$refs.donut.updateOptions({
                            labels: response.data.results.label
                        })
                    }, 100)
                    this.loadChart = true
                })
                .catch((error) => {
                    this.loadChart = false
                    console.log(error)
                    alert('Error: Failed to get quick count data.')
                })
        },
        enableFullscreen() {
            let chartSection = document.getElementById('chartSection')
            chartSection
                ?.requestFullscreen()
                .then(() => {
                    //
                })
                .catch((error) => {
                    console.log(error.message)
                })
        }
    }
}
</script>

<style scoped>
/* backdrop for specific element when it enters fullscreen */
#chartSection::backdrop {
    background-color: white;
}
</style>
