<template lang="html">
    <div :class="'ui-block col-md-' + size" ref="block" v-if="hasContainer">
        <div class="ui-block__container" ref="container">
            <slot></slot>
        </div>
    </div>
    <div :class="'ui-block col-md-' + size" ref="block" v-else>
            <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiBlock',
    props: {
        size: {
            type: Number,
            default: 6,
        },
        hasContainer: {
            type: Boolean,
            default: true,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-block {

    &__container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
}

</style>
