<template lang="html">
    <app-box color="gray" title="Età e sesso degli utenti">
        <p>
            Età e sesso degli utenti che hanno usato la piattaforma.
            Purtroppo il tracciamento dell'età è legato al computer usato e non
            è veramente indicativo sulla reale età degli utenti. Potrebbe indicare
            più realisticamente l'età degli insegnanti.
        </p>
        <div id="charts-container">
            <div id="users-age-chart"></div>
            <div id="users-gender-chart"></div>
        </div>
    </app-box>
</template>

<script>
import AppBox from '../components/AppBox.vue'
import EventBus from '_js/EventBus'

export default {
    name: 'UsersAge',
    components: {
        AppBox,
    },
    props: {
        users_age: {
            type: Array,
            default: function() {},
        },
        users_gender: {
            type: Array,
            default: function() {},
        },
    },
    computed: {
        convertDataAge: function() {
            var data = []
            for (var i = 0; i < this.users_age.length; i++) {
                data.push([
                    this.users_age[i][0],
                    parseInt(this.users_age[i][1])
                ])
            }
            return data
        },
        convertDataGender: function() {
            var data = []
            for (var i = 0; i < this.users_gender.length; i++) {
                data.push([
                    this.users_gender[i][0],
                    parseInt(this.users_gender[i][1])
                ])
            }
            return data
        }
    },
    methods: {
        usersAge: function() {
            var data = new google.visualization.DataTable()
            data.addColumn('string', 'Età')
            data.addColumn('number', 'Indice')

            data.addRows(this.convertDataAge)

            var options = {
                backgroundColor: { fill: '' },
            }

            this.chart = new google.visualization.PieChart(document.getElementById('users-age-chart'))
            this.chart.draw(data, options)
        },
        userGender: function() {
            var data = new google.visualization.DataTable()
            data.addColumn('string', 'Sesso')
            data.addColumn('number', 'Indice')

            data.addRows(this.convertDataGender)

            var options = {
                backgroundColor: { fill: '' },
            }

            this.chart = new google.visualization.PieChart(document.getElementById('users-gender-chart'))
            this.chart.draw(data, options)
        }
    },
    mounted: function() {
        EventBus.$on('google-charts-load', () => {
            this.usersAge()
            this.userGender()
        })
    }
}
</script>

<style lang="scss">

#charts-container {
    display: flex;
    justify-content: space-around;

    > #users-age-chart,
    > #users-gender-chart {
        min-height: 400px;
        width: 50%;
    }
}

</style>
