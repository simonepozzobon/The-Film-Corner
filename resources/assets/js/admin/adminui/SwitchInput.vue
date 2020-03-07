<template>
<div
    class="form-group row"
    v-if="hasRow"
>
    <label
        :for="uuid"
        :class="labelSize"
    >
        {{ label }}
    </label>
    <div
        class="form-group"
        :class="inputSize"
    >
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
<div
    v-else
    class="form-group"
    :class="inputSize"
>
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
        labelSize: {
            type: String,
            default: 'col-md-2',
        },
        inputSize: {
            type: String,
            default: 'col-md-10',
        },
        initial: {
            type: Boolean,
            default: false,
        },
        hasRow: {
            type: Boolean,
            default: true,
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
        created: function () {
            this.setInitial()
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
