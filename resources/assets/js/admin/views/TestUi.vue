<template>
<div class="admin-home">
    <container :contains="true">
        <panel-title
            title="Sfondo Chiaro"
            size="h2"
            class="para-single__sub-title"
            letter-spacing="12px"
        />
        <div class="test-panel">
            <ui-custom-input
                label="Label di prova"
                name="prova"
                :value.sync="title"
            />
            <text-editor></text-editor>
        </div>
        <block-panel title="Sfondo scuro">
            <ui-custom-input
                label="Label di prova"
                name="prova"
                :value.sync="title"
            />
            <text-editor></text-editor>
        </block-panel>
    </container>
</div>
</template>

<script>
import {
    BlockPanel,
    Container,
    PanelTitle,
    TextEditor,
}
from '../adminui'

import {
    UiCustomInput
}
from '../../ui'

export default {
    name: 'TestUi',
    components: {
        BlockPanel,
        Container,
        PanelTitle,
        UiCustomInput,
        TextEditor,
    },
    data: function () {
        return {
            title: null,
        }
    },
    mounted: function () {
        console.log('home');
        this.$nextTick(() => {
            this.title = 'prova input test'
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.test-panel {
    margin-top: $spacer * 2.5;
    margin-bottom: $spacer * 2.5;
}
</style>
