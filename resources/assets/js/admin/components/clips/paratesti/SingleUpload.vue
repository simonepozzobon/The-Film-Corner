<template>
<container
    :contains="true"
    :top-margin="false"
    padding="no"
>
    <block-panel
        ref="panel"
        :title="`Aggiungi ${title}`"
        title-size="h4"
    >
        <container
            :contains="true"
            :top-margin="false"
            padding="no"
        >

            <text-editor
                ref="content"
                :has-animation="false"
                label="Descrizione"
                min-height="50px"
                :has-label="false"
                input-size="col-md-12"
                @update="updateContent"
            />

            <upload-zone
                ref="upload"
                :accept="mime"
                url="/api/v2/admin/clips/paratexts/upload"
                :params.sync="requestParams"
                :auto-process-queue="false"
                @success="addParatext"
            />

            <div class="w-100 d-flex justify-content-center mt-4">
                <ui-button
                    title="Aggiungi paratesto"
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
    PanelTitle,
    Select2Input,
    UploadZone,
}
from '../../../adminui'



import {
    UiButton,
    UiTitle,
}
from '../../../../ui'
export default {
    name: 'SingleUpload',
    components: {
        BlockPanel,
        Container,
        TextEditor,
        UiTitle,
        UploadZone,
        PanelTitle,
        UiButton,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        paratext: {
            type: Object,
            default: function () {
                return {}
            },
        },
        clipId: {
            type: Number,
            default: 0,
        }
    },
    data: function () {
        return {
            isLoading: false,
            content: null,
        }
    },
    computed: {
        hasMedia: function () {
            if (this.paratext.has_media == 1) {
                return true
            }
            else {
                return false
            }
        },
        mediaType: function () {
            if (this.paratext.type === 'image') {
                return 1
            }
            else if (this.paratext.type === 'audio') {
                return 2
            }
            else if (this.paratext.type === 'video') {
                return 3
            }
            else {
                return 0
            }
        },
        mime: function () {
            if (this.paratext.type === 'image') {
                return 'image/*'
            }
            else if (this.paratext.type === 'audio') {
                return 'audio/*'
            }
            else if (this.paratext.type === 'video') {
                return 'video/mp4'
            }

            return null
        },
        panelBtn: function () {
            if (this.isOpen) {
                return 'Minimizza'
            }
            else {
                return 'Espandi'
            }
        },
        tableShadows: function () {
            return
        },
        requestParams: function () {
            return {
                clip_id: this.clipId,
                paratext_type_id: this.paratext.id,
                content: this.content,
            }
        },
    },
    methods: {
        addParatext: function (response) {
            this.$emit('add-paratext', response)
            this.$refs.content.editor.setContent(null)
            this.content = null
        },
        updateContent: function (json, html) {
            this.content = html
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
