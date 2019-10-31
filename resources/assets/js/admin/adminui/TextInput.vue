<template>
<div class="form-group row">
    <label
        :for="name"
        class="col-md-2"
    >
        {{ label }}
    </label>
    <div class="col-md-10">
        <input
            :type="type"
            class="form-control"
            :name="name"
            :placeholder="placeholder"
            v-model="value"
        />
        <small v-if="info">{{ info }}</small>
    </div>
</div>
</template>

<script>
export default {
    name: 'TextInput',
    props: {
        label: {
            type: String,
            default: 'label',
        },
        name: {
            type: String,
            default: 'name',
        },
        placeholder: {
            type: String,
            default: null,
        },
        type: {
            type: String,
            default: 'text',
        },
        info: {
            type: String,
            default: null,
        },
        initial: [String, Number],
    },
    data: function () {
        return {
            value: null,
        }
    },
    watch: {
        value: function (value) {
            this.$emit('update', value)
        },
        initial: function (value) {
            this.setInitial()
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
