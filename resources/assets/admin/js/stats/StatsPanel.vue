<template lang="html">
    <div id="stats-panel">
        <div id="only-desktop" class="pb-3">
            <div class="box gray">
                <div class="box-body">
                    <p>Le statistiche sono visibili solo su desktop</p>
                </div>
            </div>
        </div>
        <div id="stats">
            <div class="row pb-3">
                <div class="col-md-6">
                    <app-box title="Classifica app" color="gray">
                        <p>In ordine di utilizzo, dalla più usata a quella meno usata</p>
                        <moon-loader :loading="this.appsChartLoader" color="#ff878f"></moon-loader>
                        <ol>
                            <li v-for="app in this.appsChart" :key="app.id">
                                {{ app.name }}
                            </li>
                        </ol>
                    </app-box>
                </div>
                <div class="col-md-6">
                    <div class="row pb-3">
                        <div class="col-12">
                            <app-box title="Iscritti alla conferenza" color="gray">
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <h1>{{ this.statsObj.conference_applications }}</h1>
                                    </div>
                                </div>
                            </app-box>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-12">
                            <app-box title="Account Globali" color="gray">
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <h1>{{ this.statsObj.global_accounts }}</h1>
                                    </div>
                                </div>
                            </app-box>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-4">
                    <app-box title="N. Teacher" color="gray">
                        <div class="d-flex justify-content-around">
                            <div>
                                <h1>{{ this.statsObj.teachers_count }}</h1>
                            </div>
                        </div>
                    </app-box>
                </div>
                <div class="col-md-4">
                    <app-box title="N. Studenti" color="gray">
                        <div class="d-flex justify-content-around">
                            <div>
                                <h1>{{ this.statsObj.students_count }}</h1>
                            </div>
                        </div>
                    </app-box>
                </div>
                <div class="col-md-4">
                    <app-box title="N. Ospiti" color="gray">
                        <div class="d-flex justify-content-around">
                            <div>
                                <h1>{{ this.statsObj.guests_count }}</h1>
                            </div>
                        </div>
                    </app-box>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-12">
                    <geo-chart :geosOrdered="this.geosOrdered"/>
                </div>
            </div>
            <div id="row-2" class="row pb-3">
                <div class="col-md-6">
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <app-box title="Pagina della settimana" color="gray">
                                <p>Pagina più visitata della settimana</p>
                                <h1 class="d-inline-block">{{ this.statsObj.most_visited_page.pageViews }}</h1><span> Visite</span>
                                - <a :href="this.statsObj.most_visited_page.url" target="_blank">{{ this.statsObj.most_visited_page.pageTitle }}</a>
                            </app-box>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <app-box title="Insegnanti" color="gray">
                                <p>Numero di applicazioni svolte dagli insegnanti</p>
                                <h1>{{ this.statsObj.teacher_sessions }}</h1>
                            </app-box>
                        </div>
                        <div class="col-md-6">
                            <app-box title="Studenti" color="gray">
                                <p>Numero di applicazioni svolte dagli studenti</p>
                                <h1>{{ this.statsObj.student_sessions }}</h1>
                            </app-box>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <browser-chart :browsers="this.statsObj.browsers"/>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-4">
                    <app-box title="Visitatori" color="gray">
                        <p>Visitatori Unici</p>
                        <h1>{{ this.statsObj.visitors_tot }}</h1>
                    </app-box>
                </div>
                <div class="col-md-8">
                    <app-box title="Tipi di Utenti" color="gray">
                        <div class="d-flex justify-content-around">
                            <div v-for="userType in this.statsObj.users_type">
                                <p>{{ userType.type }}</p><h1>{{ userType.sessions }}</h1>
                            </div>
                        </div>
                    </app-box>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-6">
                    <app-box title="Visualizzazioni" color="gray">
                        <p>Visualizzazioni di pagina totali</p>
                        <moon-loader :loading="this.pageViewsLoader" color="#ff878f"></moon-loader>
                        <h1 v-if="!this.pageViewsLoader">{{ this.pageViews.global }}</h1>
                        <!-- <h1>{{ this.statsObj.page_views_60dd }}</h1> -->
                    </app-box>
                </div>
                <div class="col-md-6">
                    <app-box title="Durata Media Utilizzo" color="gray">
                        <p>Durata media delle sessioni</p>
                        <h1>{{ this.statsObj.session_time_avg }}</h1>
                    </app-box>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-4">
                    <app-box title="Admin" color="gray">
                        <p>Visualizzazioni di pagina solo del pannello admin</p>
                        <moon-loader :loading="this.pageViewsLoader" color="#ff878f"></moon-loader>
                        <h1 v-if="!this.pageViewsLoader">{{ this.pageViews.admin }}</h1>
                    </app-box>
                </div>
                <div class="col-md-4">
                    <app-box title="Interne" color="gray">
                        <p>Visualizzazioni di pagina all'interno dell'area privata</p>
                        <moon-loader :loading="this.pageViewsLoader" color="#ff878f"></moon-loader>
                        <h1 v-if="!this.pageViewsLoader">{{ this.pageViews.inside }}</h1>
                    </app-box>
                </div>
                <div class="col-md-4">
                    <app-box title="Esterne" color="gray">
                        <p>Visualizzazioni di pagina della parte pubblica</p>
                        <moon-loader :loading="this.pageViewsLoader" color="#ff878f"></moon-loader>
                        <h1 v-if="!this.pageViewsLoader">{{ this.pageViews.outside }}</h1>
                    </app-box>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-12">
                    <users-age
                        :users_age="this.statsObj.users_age"
                        :users_gender="this.statsObj.users_gender"/>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-12">
                    <tracking-time
                        :start_date="this.statsObj.start_date"
                        :end_date="this.statsObj.end_date" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import axios from 'axios'
import AppBox from '../components/AppBox.vue'
import BrowserChart from './BrowserChart.vue'
import EventBus from '_js/EventBus'
import GeoChart from './GeoChart.vue'
import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
import TrackingTime from './TrackingTime.vue'
import UsersAge from './UsersAge.vue'

export default {
    name: 'StatsPanel',
    components: {
        AppBox,
        BrowserChart,
        GeoChart,
        MoonLoader,
        TrackingTime,
        UsersAge,
    },
    props: {
        stats: {
            type: String,
            default: '',
        }
    },
    data: function() {
        return {
            appsChart: [],
            appsChartLoader: true,
            chart: {},
            chartEl: null,
            geoStats: 0,
            pageViews: {},
            pageViewsLoader: true,
        }
    },
    computed: {
        geosOrdered: function() {
            return _.orderBy(this.statsObj.geos, geo => {
                return parseInt(geo.views)
            }, ['desc'])
        },
        statsObj: function() {
            return JSON.parse(this.stats)
        },
    },
    methods: {
        loadScriptLib: function() {
            return new Promise( (resolve, reject) => {
                var body = document.getElementsByTagName('body')[0]
                var script = document.createElement('script')
                script.type = 'text/javascript'
                script.onload = function() {
                    const google = window.google
                    google.charts.load('current', {
                        'packages': ['corechart', 'table'],
                        'mapsApiKey': 'AIzaSyD8GZXY7AJNQpmkq9gg_KMxbcbQ6LoN_mY',
                    });
                    google.charts.setOnLoadCallback(() => {
                        resolve('loaded')
                    })
                }
                script.src = 'https://www.gstatic.com/charts/loader.js'
                body.appendChild(script)
            } )
        },
        getAppCharts: function() {
            axios.get('/api/v1/app-chart').then(response => {
                this.appsChart = response.data
                this.appsChartLoader = false
                this.getPageViews()
            })
        },
        getPageViews: function() {
            axios.get('/test').then(response => {
                console.log(response.data)
                this.pageViews = response.data
                this.pageViewsLoader = false
            }).catch(errors => {
                console.log(errors)
            })
        },
    },
    mounted: function() {
        this.chartEl = document.getElementById('geo-chart')
        this.loadScriptLib().then(() => {
            EventBus.$emit('google-charts-load', google)
            this.getAppCharts()
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

#only-desktop {
    display: block;
    opacity: 1;
    transition: $transition-base;
}

#stats {
    display: none;
    opacity: 0;
    transition: $transition-base;
}

@include media-breakpoint-up('lg') {
    #only-desktop {
        display: none;
        opacity: 0;
        transition: $transition-base;
    }

    #stats {
        display: block;
        opacity: 1;
        transition: $transition-base;
    }
}

</style>
