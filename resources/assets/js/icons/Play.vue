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
                    class="ui-icon__path" d="M16.446447,9.00689729 L1.62500075,17.2435143 C1.27901819,17.4332466 1,17.2658357 1,16.8752102 L1,0.44661923 C1,0.0559937646 1.27901819,-0.111417149 1.62500075,0.0783152198 L16.446447,8.31493218 C16.7924295,8.50466455 16.7924295,8.81716492 16.446447,9.00689729 Z"
                    fill="#000000" />
            </g>
    </svg>
</template>

<script>
export default {
    name: 'Play',
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
