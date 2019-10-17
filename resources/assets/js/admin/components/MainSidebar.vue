<template>
<div class="admin-sidebar">
    <sidebar-item
        title="Home"
        url="home"
    />
    <sidebar-item
        title="News"
        url="news"
    />
    <sidebar-item
        title="Applicazioni"
        url="apps"
    />
    <sidebar-item
        title="PropagandApp"
        url="propagandapp"
    />
    <sidebar-item
        title="Traduzioni"
        url="translate"
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

<style lang="scss">
@import '~styles/shared';
// .admin-sidebar {
//     // min-height: 100vh;
//     height: 100%;
//     width: 200px;
//     padding: ($spacer * 5) $spacer $spacer;
//     z-index: 2;
//     @include custom-box-shadow(lighten($black, 25));
//     @include gradient-directional($gray-100, lighten($gray-200, 10), 145deg);
// }
</style>
