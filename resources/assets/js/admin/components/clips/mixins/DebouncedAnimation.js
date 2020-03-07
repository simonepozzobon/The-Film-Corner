const throttle = require('lodash.throttle')

const DebouncedAnimation = {
    methods: {
        debouncedEvent: function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }
    }
}

export default DebouncedAnimation
