<template>
<div class="col">
    <switch-input
        ref="switch"
        :label="option.title"
        label-size="col-md-6"
        input-size="col-md-6"
        :has-row="true"
        :initial="value"
        @update="updateSelection($event, option)"
    />
</div>
</template>

<script>
import {
    SwitchInput
}
from '../../adminui'
export default {
    name: 'SwitchContainer',
    components: {
        SwitchInput
    },
    props: {
        option: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            value: null
        }
    },
    // watch: {
    //     value: function (value) {
    //         this.$refs.switch.value = value
    //     }
    // },
    methods: {
        updateSelection: function ($event, option) {
            this.$emit('updateSelection', $event, option)
        },
        setInitials: function (value) {}
    },
    mounted: function () {
        this.$nextTick(() => {
            this.$emit('ready')
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
