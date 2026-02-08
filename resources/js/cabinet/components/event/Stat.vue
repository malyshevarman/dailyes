<template>
    <div>
        <a-range-picker format="YYYY-MM-DD" :defaultValue="[defaults.from, defaults.to]" @change="onChangedate" />
        <line-chart :chart-data="datacollection" :options="options"></line-chart>

    </div>
</template>

<script>

    import moment from 'moment';
    import LineChart from '../LineChart';
    let str = window.location.pathname;
    let res = str.split("/");

    export default {
        name: "Stat",
        components: {
            LineChart
        },
        data() {
            return {

                datacollection: null,
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: { 
                        displayColors: false,                 
                        callbacks: {
                            label: function(tooltipItem, data) {
                                console.log(tooltipItem.value)
                                return `Просмотров: ${tooltipItem.value}`
                            },
                            title: function(tooltipItem) {
                                return ""
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            position: 'right',
                            ticks: {
                                fontSize: 12,
                                fontColor: '#8BA3B9',
                                padding: 20,
                                fontFamily: 'Monsterrat-sbold',
                                beginAtZero: true,
                                callback: function (value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                },
                            },
                            gridLines: {
                                color: '#E9F1F7',
                                zeroLineColor: "#E9F1F7",
                                drawBorder: false,
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize: 12,
                                fontColor: '#8BA3B9',
                                padding: 15,
                                fontFamily: 'Monsterrat-sbold',
                                beginAtZero: true,

                            },
                            gridLines: {
                                drawBorder: true,
                                display: false
                            }
                        }],
                    }
                },

                myChart: null,
                views: {},
                nullviews: {},
                defaults:{
                    from: moment.utc().subtract(6, 'd'),
                    to: moment.utc().add(1, 'd'),
                },
                chart: {
                    from: 0,
                    to: 0,
                },
                labels:[],
            }
        },
        mounted() {

            this.chart.from = moment.utc().subtract(6, 'd').format('YYYY-MM-DD')
            this.chart.to = moment.utc().add(1, 'd').format('YYYY-MM-DD')
            this.fetch()

        },
        methods: {
            fillData() {
                moment.locale('ru');
                let result = [];
                let now = moment(this.chart.from).utc().add(1, 'd');
                while (now < moment(this.chart.to).utc().add(2, 'd')) {
                    if (this.views.hasOwnProperty(now.format('YYYY-MM-DD'))) {
                        result.push({
                            date: now.clone(),
                            count: this.views[now.format('YYYY-MM-DD')]
                        })
                    } else {
                        result.push({
                            date: now.clone(),
                            count: 0
                        })
                    }
                    now.add(1, 'd')
                }
                console.log('result=', result)
                this.datacollection = {
                    labels: result.reduce((previous, current) => {
                        previous.push([current.date.format('MM-DD')]);
                        return previous;
                    }, []),
                    datasets: [{
                        label: 'Просмотров',
                        data: result.reduce((previous, current) => {
                            previous.push(current.count);
                            return previous;
                        }, []),
                        backgroundColor: 'rgba(82, 175, 255, 1)'
                    }]
                }
            },
            onChangedate(date, dateString) {
                this.chart.from = dateString[0]
                this.chart.to = dateString[1]
                if (this.chart.from !== '' && this.chart.to != '') {
                    this.fetch()
                }


            },
            fetch(){
                axios.get(`/cabinet/event/${res[3]}/stat`, {params: this.chart})
                    .then(response => {
                        let arrays = response.data.event_views
                        console.log('=>', arrays.length)
                        if (arrays.length != 0) {
                            arrays.forEach(item => {
                                Vue.set(this.views, item.date, item.count)

                            })
                            this.fillData()

                        } else {
                            this.views = {}
                            this.fillData()
                        }


                    })
                    .catch(error => {
                        this.$message.error('Ошибка')
                    })
            }

        },

    }
</script>

<style >

</style>
