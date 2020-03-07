<template lang="html">
    <div class="ui-container">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiContainer',
    methods: {
        emit: function(eventName, value) {
            this.$emit(eventName, value)
        }
    }
}
</script>

<style lang="css" scoped>
</style>
