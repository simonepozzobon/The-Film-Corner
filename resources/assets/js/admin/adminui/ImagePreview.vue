<template>
<div class="image-preview">
    <div class="form-group row">
        <label class="col-md-2">
            {{ label }}
        </label>
        <div class="col-md-10">
            <img
                v-if="src"
                :src="src"
                alt="image-preview"
                class="admin-image-preview"
            />
            <ui-button
                title="modifica"
                class="mt-3"
                size="sm"
                color="primary"
                @click="edit"
            />
        </div>
    </div>
</div>
</template>

<script>
import {
    UiButton
}
from '../../ui'

export default {
    name: 'ImagePreview',
    components: {
        UiButton,
    },
    props: {
        src: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: 'Titolo',
        },
    },
    methods: {
        edit: function () {
            this.$emit('edit')
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-image-preview {
    max-width: 100%;
    height: auto;
}
</style>
