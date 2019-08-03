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
            v-model="valueInside"
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
        value: [String, Number],
    },
    data: function () {
        return {
            valueInside: null,
        }
    },
    watch: {
        valueInside: function (value) {
            this.$emit('value:update', value)
        },
    },
    created: function () {
        this.valueInside = this.value
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
