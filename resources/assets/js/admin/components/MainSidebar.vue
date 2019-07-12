<template>
<div class="admin-sidebar">
    <sidebar-item
        title="Home"
        url="home"
    />
    <sidebar-item
        title="Applicazioni"
        url="apps"
    />
    <sidebar-item
        title="Traduzioni"
        url="home"
    />
    <sidebar-item
        title="Utenti"
        url="users"
    />
</div>
</template>

<script>
import SidebarItem from './SidebarItem.vue'

export default {
    name: 'MainSidebar',
    components: {
        SidebarItem
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.admin-sidebar {
    min-height: 100vh;
    height: 100%;
    width: 200px;
    padding: ($spacer * 5) $spacer $spacer;
    @include custom-box-shadow($black);
    z-index: 2;
    @include gradient-directional($gray-300, $gray-200, 145deg);
}
</style>
