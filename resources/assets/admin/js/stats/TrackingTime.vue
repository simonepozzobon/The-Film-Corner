<template lang="html">
    <app-box title="Periodo analizzato" color="gray">
        <div class="d-flex justify-content-between align-items-center">
            <div class="start-date">
                <h4>{{ this.convertStart }}</h4>
            </div>
            <div class="arrow text-muted">
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="end-date">
                <h4>{{ this.convertEnd }}</h4>
            </div>
        </div>
    </app-box>
</template>

<script>
import AppBox from '../components/AppBox.vue'
import moment from 'moment'

export default {
    name: 'TrackingTime',
    components: {
        AppBox,
    },
    props: {
        start_date: {
            type: String,
            default: ''
        },
        end_date: {
            type: String,
            default: ''
        }
    },
    computed: {
        convertStart: function() {
            return moment(this.start_date).format('lll')
        },
        convertEnd: function() {
            return moment(this.end_date).format('lll')
        }
    }
}
</script>

<style lang="css">
</style>
