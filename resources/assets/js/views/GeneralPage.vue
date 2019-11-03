<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            Pagina
        </ui-hero-banner>
    </ui-container>
</template>

<script>
import { UiContainer, UiHeroBanner } from '../ui'

export default {
    name: 'GeneralPage',
    components: {
        UiContainer,
        UiHeroBanner,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
