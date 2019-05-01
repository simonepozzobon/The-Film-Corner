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
                    d="M0.502232742,17.0113214 C0.223214552,17.2903396 0,17.1898931 0,16.7992676 L0,0.370676601 C0,-0.0199488651 0.223214552,-0.120395413 0.502232742,0.158622776 L8.42634933,8.08273937 C8.4933137,8.14970373 8.53795661,8.2166681 8.57143879,8.29479319 L8.57143879,0.370676601 C8.57143879,-0.0199488651 8.79465334,-0.120395413 9.07367153,0.158622776 L16.9977881,8.08273937 C17.2768063,8.36175756 17.2768063,8.80818666 16.9977881,9.08720485 L9.07367153,17.0113214 C8.79465334,17.2903396 8.57143879,17.1898931 8.57143879,16.7992676 L8.57143879,8.87515102 C8.53795661,8.95327612 8.4933137,9.02024048 8.42634933,9.08720485 L0.502232742,17.0113214 Z"
                    fill="#000000" />
            </g>
    </svg>
</template>

<script>
export default {
    name: 'Forward',
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
