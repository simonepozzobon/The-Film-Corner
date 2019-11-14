<template>
<div>
    <nav class="main-menu navbar navbar-light bg-faded navbar-expand-lg fixed-top">
        <div class="main-menu__brand navbar-brand">
            <logo
                width="126px"
                class="main-menu__logo"
            />
            <logo-europa
                width="77px"
                class="main-menu__logo"
            />
        </div>
        <ul
            class="navbar-nav ml-auto"
            ref="navbar"
        >
            <li class="main-menu__item nav-item">
                <a
                    href="#"
                    @click="goTo($event, 'home')"
                    class="main-menu__link nav-link"
                >
                    {{ this.$root.getCmd('home') }}
                </a>
            </li>
            <li class="main-menu__item nav-item">
                <a
                    href="#"
                    @click="goTo($event, 'project')"
                    class="main-menu__link nav-link"
                >
                    {{ this.$root.getCmd('the_project') }}
                </a>
            </li>
            <li class="main-menu__item nav-item">
                <a
                    href="#"
                    @click="goTo($event, 'schools')"
                    class="main-menu__link nav-link"
                >
                    {{ this.$root.getCmd('schools') }}
                </a>
            </li>
            <li class="main-menu__item nav-item">
                <a
                    href="#"
                    @click="goTo($event, 'conference')"
                    class="main-menu__link nav-link"
                >
                    {{ this.$root.getCmd('conference') }}
                </a>
            </li>
            <li class="main-menu__item nav-item">
                <a
                    href="#"
                    @click="goTo($event, 'filmography')"
                    class="main-menu__link nav-link"
                >
                    {{ this.$root.getCmd('filmography') }}
                </a>
            </li>
            <li class="main-menu__item nav-item">
                <a
                    @click="logInOrOut"
                    class="main-menu__link nav-link"
                    href="#"
                    id="loginDropdown"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    {{ this.loginTxt }}
                </a>
            </li>
            <li class="main-menu__item nav-item dropdown">
                <a
                    href="#"
                    id="languageDropdown"
                    class="main-menu__link nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    {{ this.$root.getCmd('language') }}
                </a>
                <div
                    class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="languageDropdown"
                >
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('en')"
                    >
                        English
                    </a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('fr')"
                    >
                        Francais
                    </a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('it')"
                    >
                        Italiano
                    </a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('sr')"
                    >
                        српски
                    </a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('ka')"
                    >
                        ქართული
                    </a>
                    <a
                        class="dropdown-item"
                        href="#"
                        @click.stop.prevent="setLocale('sl')"
                    >
                        slovenski
                    </a>
                </div>
            </li>
            <li
                class="main-menu__item nav-item user-profile"
                v-if="$root.user"
            >
                <a
                    href="#"
                    class="main-menu__link nav-link user-profile__avatar"
                >
                    {{ initialsName }}
                </a>
            </li>
        </ul>
        <ui-burger
            ref="burger"
            @ready="timelineReady('burger')"
            @main-click="toggle"
        />
    </nav>
    <!-- <menu-overlay
        ref="overlay"
        @ready="timelineReady('overlay')"
        @main-click="toggle"
    /> -->
    <logged-nav v-if="$root.user" />
    <app-nav v-if="$root.user && $root.isApp" />
    <network-nav v-if="$root.user && $root.isNetwork" />
    <loader-nav v-if="$root.user" />
    <toasts />
</div>
</template>

<script>
import AppNav from './AppNav.vue'
import LoaderNav from './LoaderNav.vue'
import {
    Logo,
    LogoEuropa
}
from '../icons'
import LoggedNav from './LoggedNav.vue'
import MenuOverlay from './MenuOverlay.vue'
import NetworkNav from './NetworkNav.vue'
import Toasts from './Toasts.vue'
import {
    UiBurger
}
from '../ui'
export default {
    name: 'MainNav',
    components: {
        AppNav,
        LoaderNav,
        LoggedNav,
        Logo,
        LogoEuropa,
        UiBurger,
        MenuOverlay,
        NetworkNav,
        Toasts
    },
    data: function () {
        return {
            loginTxt: null,
            ready: {
                burger: false,
                overlay: false,
            },
        }
    },
    watch: {
        '$root.window': function () {
            this.setMenu()
        },
        '$root.user': function (user) {
            this.setLoginTxt()
        }
    },
    computed: {
        initialsName: function () {
            if (this.$root.user) {
                let first = this.$root.user.name.charAt(0)
                let second = this.$root.user.name.charAt(1)
                if (this.$root.user.surname) {
                    second = this.$root.user.surname.charAt(0)
                }

                return `${first}${second}`
            }
            return null
        },
    },
    methods: {
        setLocale: function (locale) {
            this.$root.locale = locale
        },
        setMenu: function () {
            if (this.$root.window.w <= 992) {
                this.$refs.navbar.style.display = 'none'
                this.$refs.burger.$el.style.display = 'flex'
            }
            else {
                this.$refs.navbar.style.display = 'flex'
                this.$refs.burger.$el.style.display = 'none'
            }
            this.setLoginTxt()
        },
        setLoginTxt: function () {
            if (this.$root.user) {
                this.loginTxt = this.$root.getCmd('logout')
            }
            else {
                this.loginTxt = this.$root.getCmd('login')
            }
        },
        timelineReady: function (key) {
            this.ready[key] = true
        },
        goTo: function (event, name) {
            event.preventDefault()
            this.$router.push({
                name: name
            })
        },
        toggle: function () {
            let burger = this.$refs.burger
            let overlay = this.$refs.overlay
            // se l'overlay è aperto
            if (this.ready.burger && this.ready.overlay) {
                this.$refs.burger.toggle()
                this.$refs.overlay.toggle()
            }
        },
        logInOrOut: function () {
            if (this.$root.user) {
                // logout
                this.$http.get('/api/v2/logout')
                    .then(response => {
                        if (response.data.success) {
                            this.$root.logout()
                        }
                    })
            }
            else {
                // login
                this.$root.goTo('login')
            }
        }
    },
    mounted: function () {
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
