<template lang="html">
    <nav class="main-menu navbar navbar-light bg-faded navbar-expand-lg fixed-top">
        <div class="main-menu__brand navbar-brand">
            <logo width="126px" class="main-menu__logo"/>
            <logo-europa width="77px" class="main-menu__logo"/>
        </div>
        <ul class="navbar-nav ml-auto">
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
            <li class="main-menu__item nav-item dropdown">
                <a class="main-menu__link nav-link dropdown-toggle" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="loginDropdown">
                    <a class="dropdown-item" href="#">Teacher Login</a>
                    <a class="dropdown-item" href="#">Student Login</a>
                    <a class="dropdown-item" href="#">Guest Login</a>
                </div>
            </li>
            <li class="main-menu__item nav-item dropdown">
                <a href="#" id="languageDropdown" class="main-menu__link nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        </ul>
    </nav>
</template>

<script>
import { Logo, LogoEuropa } from '../icons'
export default {
    name: 'MainNav',
    components: {
        Logo,
        LogoEuropa
    },
    methods: {
        goTo: function(event, name) {
            event.preventDefault()
            this.$router.push({ name: name })
        }
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
</style>
