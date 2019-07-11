<template>
<div class="admin-container">
    <div class="admin-container__content">
        <slot></slot>
    </div>
</div>
</template>

<script>
export default {
    name: 'Container',
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-container {
    &__content {
        background-color: $gray-100;
        padding: $spacer * 2;
        @include border-radius($border-radius);
        @include custom-box-shadow($black);
        margin-bottom: $spacer * 1.618;
        z-index: 2;
    }
}
</style>
