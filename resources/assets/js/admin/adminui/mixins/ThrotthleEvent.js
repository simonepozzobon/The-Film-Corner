const throttle = require('lodash.throttle')

const ThrottleEvent = {
    methods: {
        throttleEvent: function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }
    }
}

export default ThrottleEvent
