const debounce = require('lodash.debounce')

const DebouncedAnimation = {
    methods: {
        debouncedEvent: debounce(function (name, anim, direction, uuid, callback) {
            this.$ebus.$emit(name, anim, direction, uuid, callback)
        }, 150)
    }
}

export default DebouncedAnimation
