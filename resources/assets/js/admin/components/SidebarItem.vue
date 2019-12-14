<template>
<div class="sidebar-item">
    <a
        href="#"
        class="sidebar-item__link"
        @click.stop.prevent="goTo"
    >
        {{ title }}
    </a>
</div>
</template>

<script>
export default {
    name: 'SidebarItem',
    props: {
        title: {
            type: String,
            default: 'Titolo',
        },
        url: {
            type: String,
            default: null,
        },
    },
    methods: {
        goTo: function () {
            this.$root.goTo(this.url)
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.sidebar-item {
    padding-top: $spacer / 3;
    padding-bottom: $spacer / 3;
}
</style>
