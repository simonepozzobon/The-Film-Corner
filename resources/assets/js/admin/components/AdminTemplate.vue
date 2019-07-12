<template>
<div class="admin-template">
    <top-bar></top-bar>
    <div class="admin-template__container">
        <main-sidebar></main-sidebar>
        <div class="admin-template__content">
            <router-view></router-view>
        </div>
    </div>
</div>
</template>

<script>
import MainSidebar from './MainSidebar.vue'
import TopBar from './TopBar.vue'

export default {
    name: 'AdminTemplate',
    components: {
        MainSidebar,
        TopBar,
    },
    mounted: function () {}
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-template {
    &__container {
        display: flex;
    }

    &__content {
        padding: ($spacer * 6) ($spacer * 2) ($spacer * 2);
        width: 100%;
        @include gradient-directional(lighten($blue, 35), lighten($blue, 40), 145deg);
    }
}
</style>
