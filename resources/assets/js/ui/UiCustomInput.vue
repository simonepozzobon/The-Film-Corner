<template>
<section class="custom-input">
    <label
        :for="name"
        class="custom-input__label"
    >
        {{ label }}
    </label>
    <input
        type="text"
        :name="name"
        class="custom-input__input"
        v-model="valueInternal"
    />
</section>
</template>

<script>
export default {
    name: 'UiCustomInput',
    props: {
        label: {
            type: String,
            default: 'Label',
        },
        name: {
            type: String,
            default: 'name'
        },
        value: {
            type: String,
            default: null
        }
    },
    data: function () {
        return {
            valueInternal: null,
        }
    },
    watch: {
        valueInternal: function (v) {
            this.$emit('update:value', v)
        },
        value: function (v) {
            this.valueInternal = v
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
