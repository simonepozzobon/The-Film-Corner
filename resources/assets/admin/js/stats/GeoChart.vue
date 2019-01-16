<template lang="html">
    <app-box title="Paesi" color="gray">
        <p>Paesi di Provenienza dei visitatori</p>
        <div id="geo-chart"></div>
        <ul id="geo-list" class="list-unstyled">
            <li v-for="geo in this.geosOrdered">{{ geo.views }} - {{ geo.country }}</li>
        </ul>

        <!-- Tools -->
        <div id="country-tools" slot="tools" class="d-flex align-items-center">
            <div class="map pr-3" :class="this.mapClass" @click="toggleGeoChart('map')">
                <i class="fa fa-map-marker"></i> Mappa
            </div>
            <div class="listed" :class="this.listClass" @click="toggleGeoChart('list')">
                <i class="fa fa-list"></i> Lista
            </div>
        </div>
    </app-box>
</template>

<script>
import {TimelineMax} from 'gsap'
import AppBox from '../components/AppBox.vue'
import EventBus from '_js/EventBus'

export default {
    name: 'GeoChart',
    components: {
        AppBox,
    },
    props: {
        geosOrdered: {
            type: Array,
            default: function() {},
        },
    },
    data: function() {
        return {
            chart: {},
            geoStats: 0,
        }
    },
    computed: {
        mapClass: function() {
            if (this.geoStats == 0) {
                return 'active'
            }
            return ''
        },
        listClass: function() {
            if (this.geoStats == 1) {
                return 'active'
            }
            return ''
        }
    },
    methods: {
        geoChart: function() {
            var data = new google.visualization.DataTable()
            data.addColumn('string', 'Country')
            data.addColumn('number', 'Views')

            var convertedArr = this.convertData()
            data.addRows(convertedArr)

            var options = {
                backgroundColor: { fill: '' },
                colorAxis: { colors: ['#DEF4FB', '#DCED9A', '#F1DC72', '#EDC697'] },
                datalessRegionColor: '#f3f3f3',
                defaultColor: '#f5f5f5',
                is3D: true,
            }

            this.chart = new google.visualization.GeoChart(document.getElementById('geo-chart'))
            this.chart.draw(data, options)
        },
        convertData: function() {
            var data = []
            for (var i = 0; i < this.geosOrdered.length; i++) {
                var converted = [this.geosOrdered[i].country, parseInt(this.geosOrdered[i].views)]
                data.push(converted)
            }
            return data
        },
        toggleGeoChart: function(type) {
            if (this.geoStats == 0 && type == 'list') {
                var t1 = new TimelineMax()
                t1.to('#geo-chart', .2, {
                        display: 'none',
                        opacity: 0,
                    })
                    .to('#geo-list', .2, {
                        display: 'block',
                        opacity: 1,
                        onComplete: () => {
                            this.geoStats = 1
                        }
                    })
                return true
            }

            if (this.geoStats == 1 && type == 'map') {
                var t1 = new TimelineMax()
                t1.to('#geo-list', .2, {
                        display: 'none',
                        opacity: 0,
                    })
                    .to('#geo-chart', .2, {
                        display: 'block',
                        opacity: 1,
                        onComplete: () => {
                            this.geoStats = 0
                        }
                    })
                return true
            }
        },
    },
    mounted: function() {
        EventBus.$on('google-charts-load', () => {
            this.geoChart()
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

    #geo-list {
        display: none;
        opacity: 0;
        transition: $transition-collapse;
    }

    #geo-chart {
        transition: $transition-collapse;
    }

    #country-tools {
        > .map, > .listed {
            cursor: pointer;
            transition: $transition-base;

            &:hover {
                color: rgba($black, .33);
            }

            &.active {
                color: $tfc-red;
                transition: $transition-base;
            }
        }
    }
</style>
