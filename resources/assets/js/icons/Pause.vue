<template>
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
                    class="ui-icon__path" d="M17.1428776,0.714286566 L17.1428776,16.428591 C17.1428776,16.8192165 16.8192165,17.1428776 16.428591,17.1428776 L10.7142985,17.1428776 C10.323673,17.1428776 10.0000119,16.8192165 10.0000119,16.428591 L10.0000119,0.714286566 C10.0000119,0.3236611 10.323673,0 10.7142985,0 L16.428591,0 C16.8192165,0 17.1428776,0.3236611 17.1428776,0.714286566 Z M7.14286566,0.714286566 L7.14286566,16.428591 C7.14286566,16.8192165 6.81920456,17.1428776 6.42857909,17.1428776 L0.714286566,17.1428776 C0.3236611,17.1428776 0,16.8192165 0,16.428591 L0,0.714286566 C0,0.3236611 0.3236611,0 0.714286566,0 L6.42857909,0 C6.81920456,0 7.14286566,0.3236611 7.14286566,0.714286566 Z"
                    fill="#000000" />
            </g>
    </svg>
</template>

<script>
export default {
    name: 'Pause',
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
