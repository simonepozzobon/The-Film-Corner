<template lang="html">
    <nav class="conference-nav navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <ul class="navbar-nav ml-auto">
            <li class="conference-nav__item nav-item">
                <a href="#" @click="goTo($event, 'conference')" class="nav-link conference-nav__link">General Info</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" @click="goTo($event, 'conf-about')" class="nav-link conference-nav__link">About</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" class="nav-link conference-nav__link">Schedule Draft</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" class="nav-link conference-nav__link">Accomodation</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" @click="goTo($event, 'conf-downloads')" class="nav-link conference-nav__link">Download & Press</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" @click="goTo($event, 'conf-contact')" class="nav-link conference-nav__link">Contact Info</a>
            </li>
            <li class="conference-nav__item nav-item">
                <a href="#" class="nav-link conference-nav__link">Gallery</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'ConferenceNav',
    methods: {
        goTo: function(event, name) {
            event.preventDefault()
            this.$router.push({name: name})
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.conference-nav {
    top: 60px;
    z-index: $zindex-fixed - 1;

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-base;
        color: $white;
    }
}
</style>
