<template lang="html">
    <input
        :type="type"
        :name="name"
        v-model="value"
        class="ui-input" />
</template>

<script>
export default {
    name: 'UiInput',
    props: {
        name: {
            type: String,
            default: 'name'
        },
        type: {
            type: String,
            default: 'text'
        }
    },
    data: function() {
        return {
            value: null,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.ui-input {
    border-radius: 5px;
    min-width: 100%;
}
</style>
