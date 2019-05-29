<template>
    <div
        class="row ui-row"
        ref="row"
        :class="[
            alignClass,
            justifyClass,
            verAlignClass,
            noGuttersClass,
        ]">
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
        align: {
            type: String,
            default: null,
        },
        justify: {
            type: String,
            default: null,
        },
        verAlign: {
            type: String,
            default: null,
        },
        noGutters: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-row--center'
            }
        },
        justifyClass: function() {
            switch (this.justify) {
                case 'center':
                    return 'ui-row--justify-center'
                case 'space-around':
                    return 'ui-row--justify-space-around'
                default:
                    return null
            }
        },
        verAlignClass: function() {
            if (this.verAlign == 'center') {
                return 'ui-row--v-center'
            }
        },
        noGuttersClass: function() {
            if (this.noGutters) {
                return 'no-gutters'
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

    &--center {
        justify-content: center;
    }

    &--v-center {
        align-items: center;
    }

    &--justify-center {
        justify-content: center;
    }

    &--justify-space-around {
        justify-content: space-around;
    }
}

</style>
