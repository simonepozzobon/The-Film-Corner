<template lang="html">
    <div class="row" ref="row">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiRow',
    props: {
        minWidth: {
            type: String,
            default: null,
        },
    },
    mounted: function() {
        if (this.minWidth) {
        this.$refs.row.style.minWidth = this.minWidth
        }
    }
}
</script>

<style lang="css" scoped>
</style>
