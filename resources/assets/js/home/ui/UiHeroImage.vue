<template lang="html">
    <div
        class="ui-hero-image">
        <img :src="image" alt="" class="ui-hero-image__image">
    </div>
</template>

<script>
export default {
    name: 'UiHeroImage',
    props: {
        image: {
            type: String,
            default: null,
        },
        fullHeight: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-hero-image {
    width: 100vw;
    height: auto;

    &__image {
        width: 100%;
        height: auto;
    }
}
</style>
