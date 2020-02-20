<template>
<container :top-margin="false">
    <sottotitoli-single
        v-for="cap in caps"
        :key="cap.id"
        :cap="cap"
        @deleted="deleted"
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
from '../../../adminui'

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
    methods: {
        deleted: function (data) {
            this.$emit('deleted', data)
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
