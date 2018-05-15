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
                <div class="col-md-12">
                    <geo-chart :geosOrdered="this.geosOrdered"/>
                </div>
            </div>
            <div id="row-2" class="row pb-3">
                <div class="col-md-6">
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <app-box title="Pagina della settimana" color="blue">
                                <p>Pagina più visitata della settimana</p>
                                <h1 class="d-inline-block">{{ this.statsObj.most_visited_page.pageViews }}</h1><span> Visite</span>
                                - <a :href="this.statsObj.most_visited_page.url" target="_blank">{{ this.statsObj.most_visited_page.pageTitle }}</a>
                            </app-box>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <app-box title="Insegnanti" color="green">
                                <p>Numero di applicazioni svolte dagli insegnanti</p>
                                <h1>{{ this.statsObj.teacher_sessions }}</h1>
                            </app-box>
                        </div>
                        <div class="col-md-6">
                            <app-box title="Studenti" color="yellow">
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
                    <app-box title="Visualizzazioni" color="orange">
                        <p>Visualizzazioni di pagina totali</p>
                        <h1>{{ this.statsObj.page_views_60dd }}</h1>
                    </app-box>
                </div>
                <div class="col-md-6">
                    <app-box title="Durata Media Utilizzo" color="blue">
                        <p>Durata media delle sessioni</p>
                        <h1>{{ this.statsObj.session_time_avg }}</h1>
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

import AppBox from '../components/AppBox.vue'
import BrowserChart from './BrowserChart.vue'
import EventBus from '_js/EventBus'
import GeoChart from './GeoChart.vue'
import TrackingTime from './TrackingTime.vue'
import UsersAge from './UsersAge.vue'

export default {
    name: 'StatsPanel',
    components: {
        AppBox,
        BrowserChart,
        GeoChart,
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
            chart: {},
            chartEl: null,
            geoStats: 0,
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
    },
    mounted: function() {
        this.chartEl = document.getElementById('geo-chart')
        this.loadScriptLib().then(() => {
            EventBus.$emit('google-charts-load', google)
        })
    }
}
</script>

<style lang="scss">
@import '~styles/variables';
@import '~styles/mixins';

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
