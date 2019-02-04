import Vue from 'vue';
import mojs from 'mo-js';
import axios from 'axios';

import AppBox from './components/AppBox.vue';
import AlertTutorial from './components/AlertTutorial.vue';
import StatsPanel from './stats/StatsPanel.vue'

const app = new Vue({
    el: '#app',
    components: {
        AppBox,
        AlertTutorial,
        StatsPanel,
    }
})
