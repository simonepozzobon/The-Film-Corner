<template lang="html">
    <div
        class="row ui-row"
        ref="row"
        :class="alignClass">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'UiRow',
    props: {
        minWidth: {
            type: String,
            default: null,
        },
        align:{
            type: String,
            default: null,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-row--center'
            }
        }
    },
    mounted: function() {
        if (this.minWidth) {
            this.$refs.row.style.minWidth = this.minWidth
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-row {
    $self: &;

    &#{$self}--center {
        justify-content: center;
    }
}

</style>
