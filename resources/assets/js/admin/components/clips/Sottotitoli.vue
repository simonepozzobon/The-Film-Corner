<template>
<block-panel title="Sottotitoli">
    <container
        :contains="true"
        :top-margin="false"
        padding="no"
    >
        <select
            class="form-control mb-2"
            name=""
            v-model="capLocale"
        >
            <option value="it">Italiano</option>
            <option value="en">Inglese</option>
            <option value="fr">Francese</option>
            <option value="sr">Serbo</option>
            <option value="ka">Georgiano</option>
            <option value="sl">Sloveno</option>
        </select>
        <upload-zone
            ref="upload"
            :accept="mime"
            url="/api/v2/admin/clips/captions/upload"
            :params.sync="requestParams"
            :auto-process-queue="false"
            @success="addCaptions"
        />
        <div class="w-100 d-flex justify-content-center mt-4">
            <ui-button
                title="Carica Traccia sottotitoli"
                color="green"
                theme="outline"
                :disable="isLoading"
                :has-spinner="isLoading"
                :has-margin="false"
                :has-container="false"
                @click="save"
            />
        </div>
    </container>
</block-panel>
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

import {
    UiButton,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'Sottotitoli',
    components: {
        Container,
        BlockPanel,
        UploadZone,
        UiButton,
    },
    props: {
        clipId: {
            type: Number,
            default: 0,
        }
    },
    data: function () {
        return {
            mime: '',
            capLocale: '',
            isLoading: false,
        }
    },
    computed: {
        requestParams: function () {
            return {
                clip_id: this.clipId,
                cap_locale: this.capLocale,
            }
        },
    },
    methods: {
        addCaptions: function (response) {
            console.log('response', response);
        },
        save: function () {
            this.$refs.upload.$refs.drop.processQueue()
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
