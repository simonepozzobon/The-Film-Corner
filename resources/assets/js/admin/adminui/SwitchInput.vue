<template>
<div class="form-group row">
    <label
        :for="uuid"
        class="col-md-2"
    >
        {{ label }}
    </label>
    <div class="form-group col-md-10">
        <span class="switch">
            <input
                type="checkbox"
                class="switch"
                :id="uuid"
                v-model="value"
            />
            <label :for="uuid"></label>
        </span>
        <small v-if="info">{{ info }}</small>
    </div>
</div>
</template>

<script>
import Utility from '../../Utilities'

export default {
    name: 'SwitchInput',
    props: {
        label: {
            type: String,
            default: null,
        },
        initial: {
            type: Boolean,
            default: false,
        },
        info: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            value: null
        }
    },
    watch: {
        value: function (v) {
            this.$emit('update', v)
        },
        initial: function (value) {
            this.setInitial()
        },
    },
    computed: {
        uuid: function () {
            return Utility.uuid()
        },
    },
    methods: {
        setInitial: function () {
            this.value = this.initial
        },
    },
    created: function () {
        this.setInitial()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
