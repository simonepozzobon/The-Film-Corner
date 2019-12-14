<template>
<ui-title
    :title="title"
    :tag="size"
    :font-size="size"
    class="a-panel-title"
    :has-container="false"
    :has-margin="false"
    :style="this.styles"
/>
</template>

<script>
import {
    UiTitle
}
from '../../ui'

export default {
    name: 'PanelTitle',
    components: {
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: 'h2',
        },
        letterSpacing: {
            type: String,
            default: '12px'
        }
    },
    computed: {
        styles: function () {
            return 'letter-spacing: ' + this.letterSpacing + ';'
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
$color: $gray-100;
.a-panel-title {
    display: inline-block;
    color: darken($color, 50);
    padding: 0;
}
</style>
