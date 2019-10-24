<template>
<div class="a-clip-panel__group">
    <ui-title
        title="Paratesti"
        tag="span"
        font-size="h5"
        :has-padding="false"
        :has-margin="false"
        :has-container="false"
    />
    <hr class="a-clip-panel__divider">

    Paratesti
</div>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'Paratesti',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
    },
    props: {
        options: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            period: null,
            year: null,
            region: null,
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
