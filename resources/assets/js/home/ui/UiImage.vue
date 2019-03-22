<template lang="html">
    <div class="ui-image">
        <img :src="src" :alt="alt" class="ui-image__content"/>
    </div>
</template>

<script>
export default {
    name: 'UiImage',
    props: {
        alt: {
            type: String,
            default: null
        },
        src: {
            type: String,
            default: null
        },
        altTitle: {
            type: String,
            default: null
        },
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-image {
    overflow: hidden;
    @include border-radius($spacer / 2.8);
    margin-bottom: $spacer;

    &__content {
        max-width: 100%;
    }
}
</style>
