<template lang="html">
    <svg
        :width="width"
        :height="width"
        class="ui-icon"
        :class="colorClass"
        viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <path
                    class="ui-icon__path"
                    d="M40.6153846,16.2307692 L40.6153846,21.3076923 L37.5961538,21.3076923 C35.2307692,21.3076923 34.7884615,22.4423077 34.7884615,24.0769231 L34.7884615,27.7115385 L40.4230769,27.7115385 L39.6730769,33.4038462 L34.7884615,33.4038462 L34.7884615,48 L28.9038462,48 L28.9038462,33.4038462 L24,33.4038462 L24,27.7115385 L28.9038462,27.7115385 L28.9038462,23.5192308 C28.9038462,18.6538462 31.8846154,16 36.2307692,16 C38.3076923,16 40.0961538,16.1538462 40.6153846,16.2307692 Z"
                    fill="#000000"></path>
            </g>
    </svg>
</template>

<script>
export default {
    name: 'CheckPoint',
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
