<template>
<container
    :contains="true"
    :top-margin="false"
    padding="no"
>
    <sottotitoli-single
        v-for="cap in caps"
        :key="cap.id"
        :cap="cap"
    />
</container>
</template>

<script>
import {
    BlockPanel,
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
    UploadZone,
}
from '../../adminui'

import SottotitoliSingle from './SottotitoliSingle.vue'

export default {
    name: 'SottotitoliTable',
    components: {
        Container,
        SottotitoliSingle,
    },
    props: {
        caps: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
