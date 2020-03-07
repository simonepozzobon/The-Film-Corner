<template>
<div
    ref="modal"
    class="modal fade translate"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
    >
        <div class="modal-content translate__content">
            <div class="modal-body translate__body">
                <container
                    :contains="false"
                    :top-margin="false"
                    padding="no"
                    :has-animations="false"
                    :no-parent="true"
                >
                    <block-panel
                        ref="panel"
                        title="Traduci clip esercizio"
                        title-size="h4"
                        :has-animations="false"
                        :has-footer="true"
                    >
                        <container>
                            <ui-title title="Italiano" />
                            <text-input
                                label="Titolo"
                                name="it_title"
                                :initial="values.it.title"
                                @update="updateTitle('it', arguments)"
                            />
                            <text-editor
                                ref="it"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('it')"
                                @update="update('it', arguments)"
                            />
                        </container>
                        <container class="mt-2">
                            <ui-title title="English" />
                            <text-input
                                label="Titolo"
                                name="en_title"
                                :initial="values.en.title"
                                @update="updateTitle('en', arguments)"
                            />
                            <text-editor
                                ref="en"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('en')"
                                @update="update('en', arguments)"
                            />
                        </container>

                        <container class="mt-2">
                            <ui-title title="Francais" />
                            <text-input
                                label="Titolo"
                                name="fr_title"
                                :initial="values.fr.title"
                                @update="updateTitle('fr', arguments)"
                            />
                            <text-editor
                                ref="fr"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('fr')"
                                @update="update('fr', arguments)"
                            />
                        </container>

                        <container class="mt-2">
                            <ui-title title="Serbian" />
                            <text-input
                                label="Titolo"
                                name="sr_title"
                                :initial="values.sr.title"
                                @update="updateTitle('sr', arguments)"
                            />
                            <text-editor
                                ref="sr"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sr')"
                                @update="update('sr', arguments)"
                            />
                        </container>

                        <container class="mt-2">
                            <ui-title title="Georgiano" />
                            <text-input
                                label="Titolo"
                                name="ka_title"
                                :initial="values.ka.title"
                                @update="updateTitle('ka', arguments)"
                            />
                            <text-editor
                                ref="ka"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('ka')"
                                @update="update('ka', arguments)"
                            />
                        </container>

                        <container class="mt-2">
                            <ui-title title="Slovenian" />
                            <text-input
                                label="Titolo"
                                name="sl_title"
                                :initial="values.sl.title"
                                @update="updateTitle('sl', arguments)"
                            />
                            <text-editor
                                ref="sl"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sl')"
                                @update="update('sl', arguments)"
                            />
                        </container>

                        <sottotitoli-table
                            class="mt-2"
                            :caps.sync="caps"
                            @deleted="deleted"
                        />

                        <container class="mt-2">
                            <ui-title label="Sottotitoli" />
                            <div class="a-clip-panel__row form-group row">
                                <label
                                    for="locale"
                                    class="col-md-2"
                                >
                                    Lingua
                                </label>
                                <div class="col-md-10">
                                    <select
                                        class="form-control mb-2"
                                        name="locale"
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
                                    :disable="isLoadingCap"
                                    :has-spinner="isLoadingCap"
                                    :has-margin="false"
                                    :has-container="false"
                                    @click="uploadCaption"
                                />
                            </div>
                        </container>

                        <template v-slot:footer>
                            <ui-button
                                title="salva"
                                color="green"
                                theme="outline"
                                :disable="isLoading"
                                :has-spinner="isLoading"
                                :has-margin="false"
                                :has-container="false"
                                @click="save"
                            />
                        </template>
                    </block-panel>
                </container>
            </div>
        </div>
    </div>
</div>
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

import SottotitoliTable from './SottotitoliTable.vue'

import {
    UiButton,
    UiTitle,
}
from '../../../../ui'

export default {
    name: 'TraduzioniMedia',
    components: {
        BlockPanel,
        Container,
        TextEditor,
        TextInput,
        UiTitle,
        UploadZone,
        PanelTitle,
        UiButton,
        FileInput,
        SottotitoliTable,
    },
    props: {
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            isLoading: false,
            isLoadingCap: false,
            item: null,
            media_id: null,
            mime: '',
            capLocale: 'it',
            capFile: null,
            caps: [],
            values: {
                it: {
                    title: null,
                    description: null,
                },
                en: {
                    title: null,
                    description: null,
                },
                fr: {
                    title: null,
                    description: null,
                },
                sr: {
                    title: null,
                    description: null,
                },
                sl: {
                    title: null,
                    description: null,
                },
                ka: {
                    title: null,
                    description: null,
                },
            },
        }
    },
    methods: {
        editorReady: function (key) {},
        update: function (key, values = arguments) {
            let value = values[1]
            this.values[key].description = value
        },
        updateTitle: function (key, values = arguments) {
            let value = values[0]
            if (value) {
                this.values[key].title = value
            }
            else {
                this.values[key].title = null
            }
        },
        updateFile: function (file, src) {
            this.capFile = file
        },
        uploadCaption: function () {
            this.isLoadingCap = true
            let data = new FormData()

            data.append('library_media_id', this.item.id) // deve aggiungere l'id della clip degli esercizi
            data.append('cap_locale', this.capLocale)
            data.append('cap_file', this.capFile)

            this.$http.post('/api/v2/admin/clips/libraries/captions/upload', data).then(response => {
                this.isLoadingCap = false
                if (response.data.success) {
                    this.caps.push(response.data.caption)
                    this.$emit('saved', response.data.clip)
                }
            }).catch(() => {
                this.isLoadingCap = false
            })
        },
        save: function () {
            this.isLoading = true

            let data = new FormData()
            data.append('library_media_id', this.item.id)

            let translations = []

            for (let key in this.values) {
                if (this.values.hasOwnProperty(key)) {
                    translations.push({
                        locale: key,
                        title: this.values[key].title,
                        description: this.values[key].description
                    })
                }
            }
            data.append('translations', JSON.stringify(translations))

            this.$http.post('/api/v2/admin/clips/libraries/translations', data).then(response => {
                // console.log(response.data);
                this.isLoading = false
                if (response.data.success) {
                    this.$emit('saved', response.data.clip)

                    this.hide()
                }
            }).catch(() => {
                this.isLoading = false
            })
        },
        resetValues: function () {
            this.item = null
            this.caps = []
            this.capFile = null
            this.capLocale = 'it'
            this.isLoading = false
            this.isLoadingCap = false

            this.values = {
                it: {
                    title: null,
                    description: null,
                },
                en: {
                    title: null,
                    description: null,
                },
                fr: {
                    title: null,
                    description: null,
                },
                sr: {
                    title: null,
                    description: null,
                },
                sl: {
                    title: null,
                    description: null,
                },
                ka: {
                    title: null,
                    description: null,
                },
            }
        },
        show: function (item) {
            console.log('traduzioni', item);
            this.resetValues()

            this.setItem(item).then(() => {
                $(this.$refs.modal).modal('show')
            })
        },
        hide: function () {
            this.resetValues()
            $(this.$refs.modal).modal('hide')
        },
        deleted: function (data) {
            let idx = this.caps.findIndex(item => item.id == data.id)
            if (idx > -1) {
                this.caps.splice(idx, 1)
            }

            this.$emit('saved', data.clip)
        },
        setItem: function (item) {
            return new Promise((resolve, reject) => {
                this.item = item


                // set Translations
                let translations = item.translations

                for (let i = 0; i < translations.length; i++) {
                    let current = translations[i]
                    let locale = current.locale

                    if (this.values.hasOwnProperty(locale)) {
                        this.values[locale] = {
                            title: current.title,
                            description: current.description
                        }

                        this.$refs[locale].editor.setContent(current.description)
                    }
                }

                let captions = item.library_captions
                this.caps = captions

                this.$nextTick(() => {
                    resolve()
                })
            });
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
