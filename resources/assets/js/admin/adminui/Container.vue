<template>
<div
    class="admin-container"
    :class="paddingClass"
>
    <div class="admin-container__content">
        <slot></slot>
    </div>
</div>
</template>

<script>
export default {
    name: 'Container',
    props: {
        padding: {
            type: String,
            default: null,
        },
    },
    computed: {
        paddingClass: function () {
            if (this.padding) {
                return 'admin-container--padding-' + this.padding
            }
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-container {
    &__content {
        background-color: $gray-100;
        padding: $spacer * 2;
        @include border-radius($border-radius);
        @include custom-box-shadow(lighten($black, 25));
        margin-bottom: $spacer * 1.618;
        z-index: 2;
    }

    &--padding-sm &__content {
        padding: $spacer;
    }
}
</style>
