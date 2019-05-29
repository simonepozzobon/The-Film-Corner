<template>
    <div>
        <nav class="main-menu navbar navbar-light bg-faded navbar-expand-lg fixed-top">
            <div class="main-menu__brand navbar-brand">
                <logo width="126px" class="main-menu__logo"/>
                <logo-europa width="77px" class="main-menu__logo"/>
            </div>
            <ul class="navbar-nav ml-auto" ref="navbar">
                <li class="main-menu__item nav-item">
                    <a href="#" @click="goTo($event, 'home')" class="main-menu__link nav-link">Home</a>
                </li>
                <li class="main-menu__item nav-item">
                    <a href="#" @click="goTo($event, 'project')" class="main-menu__link nav-link">The Project</a>
                </li>
                <li class="main-menu__item nav-item">
                    <a href="#" @click="goTo($event, 'schools')" class="main-menu__link nav-link">Schools</a>
                </li>
                <li class="main-menu__item nav-item">
                    <a href="#" @click="goTo($event, 'conference')" class="main-menu__link nav-link">Conference</a>
                </li>
                <li class="main-menu__item nav-item">
                    <a href="#" @click="goTo($event, 'filmography')" class="main-menu__link nav-link">Filmography</a>
                </li>
                <li class="main-menu__item nav-item">
                    <a @click="logInOrOut" class="main-menu__link nav-link" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ this.loginTxt }}
                    </a>
                </li>
                <li class="main-menu__item nav-item dropdown disabled" >
                    <a href="#" id="languageDropdown" class="main-menu__link nav-link dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Language
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                        <a class="dropdown-item" href="/set-locale/en">
                            English
                        </a>
                        <a class="dropdown-item" href="/set-locale/fr">
                            Francais
                        </a>
                        <a class="dropdown-item" href="/set-locale/it">
                            Italiano
                        </a>
                        <a class="dropdown-item" href="/set-locale/sr">
                            српски
                        </a>
                    </div>
                </li>
                <li class="main-menu__item nav-item user-profile" v-if="$root.user">
                    <a href="#" class="main-menu__link nav-link user-profile__avatar">
                        SP
                    </a>
                </li>
            </ul>
            <ui-burger
                ref="burger"
                @ready="timelineReady('burger')"
                @main-click="toggle"/>
        </nav>
        <menu-overlay
            ref="overlay"
            @ready="timelineReady('overlay')"
            @main-click="toggle"/>
        <logged-nav v-if="$root.user"/>
        <app-nav v-if="$root.user && $root.isApp"/>
        <network-nav v-if="$root.user && $root.isNetwork"/>
    </div>
</template>

<script>
import AppNav from './AppNav.vue'
import NetworkNav from './NetworkNav.vue'
import { Logo, LogoEuropa } from '../icons'
import LoggedNav from './LoggedNav.vue'
import MenuOverlay from './MenuOverlay.vue'
import { UiBurger } from '../ui'

export default {
    name: 'MainNav',
    components: {
        AppNav,
        LoggedNav,
        Logo,
        LogoEuropa,
        UiBurger,
        MenuOverlay,
        NetworkNav
    },
    watch: {
        '$root.window': function() {
            this.setMenu()
        },
        '$root.user': function(user) {
            this.setLoginTxt()
        }
    },
    data: function() {
        return {
            loginTxt: 'Login',
            ready: {
                burger: false,
                overlay: false,
            },
        }
    },
    methods: {
        setMenu: function() {
            if (this.$root.window.w <= 992) {
                this.$refs.navbar.style.display = 'none'
                this.$refs.burger.$el.style.display = 'flex'
            } else {
                this.$refs.navbar.style.display = 'flex'
                this.$refs.burger.$el.style.display = 'none'
            }
            this.setLoginTxt()
        },
        setLoginTxt: function() {
            if (this.$root.user) {
                this.loginTxt = 'Logout'
            } else {
                this.loginTxt = 'Login'
            }
        },
        timelineReady: function(key) {
            this.ready[key] = true
        },
        goTo: function(event, name) {
            event.preventDefault()
            this.$router.push({ name: name })
        },
        toggle: function() {
            let burger = this.$refs.burger
            let overlay = this.$refs.overlay

            // se l'overlay è aperto
            if (this.ready.burger && this.ready.overlay) {
                this.$refs.burger.toggle()
                this.$refs.overlay.toggle()
            }
        },
        logInOrOut: function() {
            if (this.$root.user) {
                // logout
                this.$http.get('/api/v2/logout').then(response => {
                    if (response.data.success) {
                        this.$root.logout()
                    }
                })
            } else {
                // login
                this.$root.goTo('login')
            }
        }
    },
    mounted: function() {
        this.setMenu()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.main-menu {
    min-height: 60px;

    &__logo {
        margin-right: $spacer;
    }

    &__link {
        text-transform: uppercase;
        font-weight: $font-weight-bold;
        font-size: $font-size-sm;
    }
}

.user-profile {
    position: relative;
    width: $spacer * 2;
    height: $spacer * 2;
    background-color: $gray-600;
    @include border-radius(50%);

    &__avatar {
        line-height: 1;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: $white !important;
    }
}
</style>
