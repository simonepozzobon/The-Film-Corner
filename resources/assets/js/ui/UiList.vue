<template>
    <ul
        class="ui-list"
        :class="startClass">
        <slot></slot>
    </ul>
</template>

<script>
export default {
    name: 'UiList',
    props: {
        hasStart: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        startClass: function() {
            if (!this.hasStart) {
                return 'ui-list--no-start'
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-list {
    $self: &;

    &#{$self}--no-start {
        // padding: 0;
        // list-style-position: inside;
        margin-inline-start: 1em;
        padding-inline-start: 0
    }
}
</style>
