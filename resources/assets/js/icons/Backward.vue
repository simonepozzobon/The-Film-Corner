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
                    class="ui-icon__path"
                    d="M16.704819,0.158622776 C16.9838372,-0.120395413 17.2070518,-0.0199488651 17.2070518,0.370676601 L17.2070518,16.7992676 C17.2070518,17.1898931 16.9838372,17.2903396 16.704819,17.0113214 L8.78070243,9.08720485 C8.71373807,9.02024048 8.66909516,8.95327612 8.63561297,8.87515102 L8.63561297,16.7992676 C8.63561297,17.1898931 8.41239842,17.2903396 8.13338023,17.0113214 L0.209263642,9.08720485 C-0.0697545474,8.80818666 -0.0697545474,8.36175756 0.209263642,8.08273937 L8.13338023,0.158622776 C8.41239842,-0.120395413 8.63561297,-0.0199488651 8.63561297,0.370676601 L8.63561297,8.29479319 C8.66909516,8.2166681 8.71373807,8.14970373 8.78070243,8.08273937 L16.704819,0.158622776 Z"
                    fill="#000000" />
            </g>
    </svg>
</template>

<script>
export default {
    name: 'Backward',
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
