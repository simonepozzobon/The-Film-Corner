import Vue from 'vue'
export const EventBus = new Vue({
    created: function() {
        console.log('EventBus loaded')
    }
})

export default EventBus
