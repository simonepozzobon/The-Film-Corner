const throttle = require('lodash.throttle')

const DebouncedAnimation = {
    methods: {
        debouncedEvent: throttle(function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }, 150)
    }
}

export default DebouncedAnimation
