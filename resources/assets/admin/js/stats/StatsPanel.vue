<template lang="html">
    <div id="stats-panel">
        <div class="row pb-3">
        <div class="col-md-8">
          <div class="row pb-3">
            <div class="col-md-12">
              <app-box title="Pagina della settimana" color="yellow">
                <p>Pagina più visitata della settimana</p>
                <h1 class="d-inline-block">{{ this.statsObj.most_visited_page.pageViews }}</h1><span> Visite</span>
                - <a :href="this.statsObj.most_visited_page.url" target="_blank">{{ this.statsObj.most_visited_page.pageTitle }}</a>
              </app-box>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <app-box title="App Insegnanti" color="green">
                <p>Numero di applicazioni svolte dagli insegnanti</p>
                <h1>{{ this.statsObj.teacher_sessions }}</h1>
              </app-box>
            </div>
            <div class="col-md-6">
              <app-box title="App Studenti" color="orange">
                <p>Numero di applicazioni svolte dagli studenti</p>
                <h1>{{ this.statsObj.student_sessions }}</h1>
              </app-box>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <app-box title="10 Browser più usati" color="blue">
            <ul class="list-unstyled">
                <li v-for="browser in this.statsObj.browsers">{{ browser.sessions }} - {{ browser.browser }}</li>
            </ul>
          </app-box>
        </div>
      </div>
      <div class="row pb-3">
        <div class="col-md-4">
          <app-box title="Visitatori" color="blue">
            <p>Visitatori Unici</p>
            <h1>{{ this.statsObj.visitors_tot }}</h1>
          </app-box>
        </div>
        <div class="col-md-8">
          <app-box title="Tipi di Utenti" color="yellow">
            <div class="d-flex justify-content-around">
                <div v-for="userType in this.statsObj.users_type">
                    <h1>{{ userType.sessions }}</h1><p>{{ userType.type }}</p>
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
          <app-box title="Durata Media Utilizzo" color="green">
            <p>Durata media delle sessioni</p>
            <h1>{{ this.statsObj.session_time_avg }}</h1>
          </app-box>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <app-box title="Paesi" color="gray">
            <p>Paesi di Provenienza dei visitatori</p>
            <ul class="list-unstyled">
                <li v-for="geo in this.geosOrdered">{{ geo.views }} - {{ geo.country }}</li>
            </ul>
          </app-box>
        </div>
      </div>
    </div>
</template>

<script>
import _ from 'lodash'
import AppBox from '../components/AppBox.vue'
export default {
    name: 'StatsPanel',
    components: {
        AppBox,
    },
    props: {
        stats: {
            type: String,
            default: '',
        }
    },
    data: function() {
        return {

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
}
</script>

<style lang="css">
</style>
