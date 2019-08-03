<template>
<div
    class="admin-template"
    :class="randomColorClass"
>
    <top-bar></top-bar>
    <div class="admin-template__container">
        <main-sidebar
            ref="sidebar"
            class="admin-template__sidebar"
        />
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
    data: function () {
        return {
            randomColorClass: null
        }
    },
    watch: {
        '$route': function () {
            this.randomColor()
        }
    },
    computed: {

    },
    methods: {
        randomColor: function () {
            let colors = ['blue', 'red', 'green', 'orange', 'purple']
            let idx = Math.floor(Math.random() * colors.length) + 0
            this.randomColorClass = 'admin-template--' + colors[idx]
        },
        observeMain: function () {},
    },
    mounted: function () {
        this.randomColor()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.admin-template {
    &__container {
        display: flex;
        height: 100%;
        min-height: 100vh;
    }

    &__sidebar {
        // min-height: 100vh;
        // height: 100%;
        width: 200px;
        padding: ($spacer * 5) $spacer $spacer;
        z-index: 2;
        @include custom-box-shadow(lighten($black, 25));
        @include gradient-directional($gray-100, lighten($gray-200, 10), 145deg);
    }

    &__content {
        padding: ($spacer * 6) ($spacer * 2) ($spacer * 2);
        width: 100%;
    }

    &--blue &__content {
        @include gradient-directional(lighten($blue, 35), lighten($blue, 40), 145deg);
    }

    &--red &__content {
        @include gradient-directional(lighten($red, 20), lighten($red, 25), 145deg);
    }

    &--green &__content {
        @include gradient-directional(lighten($green, 25), lighten($green, 35), 145deg);
    }

    &--orange &__content {
        @include gradient-directional(lighten($orange, 25), lighten($orange, 35), 145deg);
    }

    &--purple &__content {
        @include gradient-directional(lighten($purple, 55), lighten($purple, 60), 145deg);
    }
}
</style>
