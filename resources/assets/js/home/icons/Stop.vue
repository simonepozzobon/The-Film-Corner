<template lang="html">
    <svg
        :width="width"
        :height="width"
        class="ui-icon"
        :class="[
            colorClass,
            hoverableClass,
        ]"
        viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <path
                    class="ui-icon__path"
                    d="M17.1428776,0.714286566 L17.1428776,16.428591 C17.1428776,16.8192165 16.8192165,17.1428776 16.428591,17.1428776 L0.714286566,17.1428776 C0.3236611,17.1428776 0,16.8192165 0,16.428591 L0,0.714286566 C0,0.3236611 0.3236611,0 0.714286566,0 L16.428591,0 C16.8192165,0 17.1428776,0.3236611 17.1428776,0.714286566 Z"
                    fill="#000000" />
            </g>
    </svg>
</template>

<script>
export default {
    name: 'Stop',
    props: {
        width: {
            type: String,
            default: '32px'
        },
        color: {
            type: String,
            default: null,
        },
        hoverable: {
            type: Boolean,
            default: false,
        },
        hoverColor: {
            type: String,
            default: 'primary',
        }
    },
    computed: {
        colorClass: function() {
            if (this.color) {
                return 'ui-icon--' + this.color
            }
        },
        hoverableClass: function() {
            if (this.hoverable) {
                return 'ui-icon--hoverable ui-icon--hover-' + this.hoverColor
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
@import '~styles/ui-icon';

</style>
