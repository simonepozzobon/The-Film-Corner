<template lang="html">
    <router-view name="conference"></router-view>
</template>

<script>
export default {
    name: 'Dummy',
    mounted: function() {
        this.$root.conferenceMenu = true
    },
    beforeDestroy: function() {
        this.$root.conferenceMenu = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
