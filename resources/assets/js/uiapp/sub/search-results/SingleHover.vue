<template>
<svg
    :width="size"
    :height="size"
    class="single-hover"
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 64 64"
>
    <path
        ref="path"
        class="single-hover__path"
        d="M61.57,26.67V37.32H38V63H26V37.32H2.43V26.67H26V1H38V26.67Z"
    />
</svg>
</template>

<script>
import {
    TweenMax
}
from 'gsap/all'

export default {
    name: 'LibraryHover',
    props: {
        size: {
            type: String,
            default: '32px'
        },
    },
    data: function () {
        return {}
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.single-hover {
    &__path {
        fill: $white;
    }
}
</style>
