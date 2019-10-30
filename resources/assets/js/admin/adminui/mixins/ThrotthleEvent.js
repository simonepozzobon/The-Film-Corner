const throttle = require('lodash.throttle')

const ThrottleEvent = {
    methods: {
        throttleEvent: throttle(function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }, 150)
    }
}

export default ThrottleEvent
