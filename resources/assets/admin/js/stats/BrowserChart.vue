<template lang="html">
    <app-box title="10 Browser più usati" color="blue">
        <div id="browser-chart"></div>
        <div id="browser-list">
            <ul class="list-unstyled">
                <li v-for="browser in this.browsers">{{ browser.sessions }} - {{ browser.browser }}</li>
            </ul>
        </div>
        <div id="browser-tools" class="d-flex align-items-center pl-3" slot="tools">
            <div class="pie pr-3" :class="pieClass" @click="tooglePieChart('pie')">
                <i class="fa fa-pie-chart"></i>
            </div>
            <div class="listed" :class="listClass" @click="tooglePieChart('list')">
                <i class="fa fa-list"></i>
            </div>
        </div>
    </app-box>
</template>

<script>
import AppBox from '../components/AppBox.vue'
import EventBus from '_js/EventBus'

export default {
    name: 'BrowserChart',
    components: {
        AppBox,
    },
    props: {
        browsers: {
            type: Array,
            default: function() {},
        }
    },
    data: function() {
        return {
            browserOpts: 0,
            chart: {},
        }
    },
    computed: {
        pieClass: function() {
            if (this.browserOpts == 0) {
                return 'active'
            }
            return ''
        },
        listClass: function() {
            if (this.browserOpts == 1) {
                return 'active'
            }
            return ''
        }
    },
    methods: {
        pieChart: function() {
            var data = new google.visualization.DataTable()
            data.addColumn('string', 'Browser')
            data.addColumn('number', 'Sessions')

            var convertedArr = this.convertData()
            data.addRows(convertedArr)

            var options = {
                backgroundColor: { fill: '' },
            }

            this.chart = new google.visualization.PieChart(document.getElementById('browser-chart'))
            this.chart.draw(data, options)
        },
        convertData: function() {
            var data = []
            for (var i = 0; i < this.browsers.length; i++) {
                data.push([
                    this.browsers[i].browser,
                    parseInt(this.browsers[i].sessions)
                ])
            }
            return data
        },
        tooglePieChart: function(type) {
            if (this.browserOpts == 0 && type == 'list') {
                var t1 = new TimelineMax()
                t1.to('#browser-chart', .2, {
                        display: 'none',
                        opacity: 0,
                    })
                    .to('#browser-list', .2, {
                        display: 'block',
                        opacity: 1,
                        onComplete: () => {
                            this.browserOpts = 1
                        }
                    })
                return true
            }

            if (this.browserOpts == 1 && type == 'pie') {
                var t1 = new TimelineMax()
                t1.to('#browser-list', .2, {
                        display: 'none',
                        opacity: 0,
                    })
                    .to('#browser-chart', .2, {
                        display: 'block',
                        opacity: 1,
                        onComplete: () => {
                            this.browserOpts = 0
                        }
                    })
                return true
            }
        }
    },
    mounted: function() {
        EventBus.$on('google-charts-load', () => {
            this.pieChart()
        })
    }
}
</script>

<style lang="scss">
@import '~styles/variables';
@import '~styles/mixins';

#browser-list {
    display: none;
    opacity: 0;
}

#browser-tools {
    > .pie, > .listed {
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

#browser-chart {
    min-height: 400px;
}

</style>
