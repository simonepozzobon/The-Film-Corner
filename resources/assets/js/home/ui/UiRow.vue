<template lang="html">
    <div
        class="row ui-row"
        ref="row"
        :class="[alignClass, justifyClass, verAlignClass]">
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
        },
        justify:{
            type: String,
            default: null,
        },
        verAlign:{
            type: String,
            default: null,
        },
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-row--center'
            }
        },
        justifyClass: function() {
            if (this.justify == 'center') {
                return 'ui-row--justify-center'
            }
        },
        verAlignClass: function() {
            if (this.verAlign == 'center') {
                return 'ui-row--v-center'
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

    &--center {
        justify-content: center;
    }

    &--v-center {
        align-items: center;
    }

    &--justify-center {
        justify-content: center;
    }
}

</style>
