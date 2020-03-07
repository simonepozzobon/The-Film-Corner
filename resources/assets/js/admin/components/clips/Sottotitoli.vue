<template>
<block-panel title="Sottotitoli">
    <sottotitoli-table
        :caps.sync="caps"
        @deleted="deleted"
    />

    <container
        :contains="true"
        padding="no"
    >
        <div class="a-clip-panel__row form-group row">
            <label
                for="cap_locale"
                class="col-md-2"
            >
                Lingua
            </label>
            <div class="col-md-10">
                <select
                    class="form-control mb-2"
                    name="cap_locale"
                    v-model="capLocale"
                >
                    <option value="it">Italiano</option>
                    <option value="en">Inglese</option>
                    <option value="fr">Francese</option>
                    <option value="sr">Serbo</option>
                    <option value="ka">Georgiano</option>
                    <option value="sl">Sloveno</option>
                </select>
            </div>
        </div>


        <file-input
            label="Traccia Sottotitoli"
            name="captions"
            accept=""
            :has-crop="false"
            :has-preview="false"
            @update="updateFile"
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

import SottotitoliTable from './SottotitoliTable.vue'

export default {
    name: 'Sottotitoli',
    components: {
        Container,
        BlockPanel,
        UploadZone,
        UiButton,
        FileInput,
        SottotitoliTable,
    },
    props: {
        clipId: {
            type: Number,
            default: 0,
        },
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            mime: '',
            capFile: null,
            capLocale: 'it',
            isLoading: false,
            caps: [],
        }
    },
    watch: {
        clip: {
            handler: function (clip) {
                if (clip.captions) {
                    this.caps = Object.assign([], clip.captions)
                }
            },
            deep: true,
        },
    },
    methods: {
        updateFile: function (file, src) {
            this.capFile = file
        },
        deleted: function (data) {
            let idx = this.caps.findIndex(item => item.id == data.id)
            // console.log(idx);
            if (idx > -1) {
                this.caps.splice(idx, 1)
            }

            let clip = Object.assign({}, data.clip)
            this.$emit('saved', clip)
        },
        save: function () {
            this.isLoading = true

            let data = new FormData()

            if (this.id != null && this.id > 0) {
                data.append('id', this.id)
            }

            data.append('clip_id', this.clip ? this.clip.id : 0)
            data.append('cap_locale', this.capLocale)
            data.append('cap_file', this.capFile)

            this.$http.post('/api/v2/admin/clips/captions/upload', data).then(response => {
                console.log('response', response);
                this.isLoading = false
                this.caps.push(response.data.caption)
                this.$emit('saved', response.data.clip)
            }).catch(() => {
                this.isLoading = false
            })

        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
