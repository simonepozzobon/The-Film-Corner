<template>
<div class="admin-top-bar">
    <div class="admin-top-bar__logo">
        Admin Panel
    </div>
    <div class="admin-top-bar__logout">
        <ui-button
            title="logout"
            color="lightest-gray"
            :has-container="false"
            :has-margin="false"
            @click="logout"
        />
    </div>
</div>
</template>

<script>
import {
    UiButton
}
from '../../ui'

export default {
    name: 'TopBar',
    components: {
        UiButton
    },
    methods: {
        logout: function () {
            console.log('logout function');
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.admin-top-bar {
    position: fixed;
    height: $spacer * 4;
    width: 100%;
    background-color: $gray-100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: ($spacer / 2) $spacer;
    // @include custom-box-shadow(lighten($black, 25));
    z-index: $zindex-fixed;

    &__logo {
        font-size: 1.2em;
        font-weight: bold;
        text-transform: uppercase;
    }

    &__logout {}
}
</style>
