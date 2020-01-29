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
                        <div>
                            <ui-title title="Italiano" />
                            <text-input
                                label="Titolo"
                                name="it_title"
                            />
                            <text-editor
                                ref="it"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('it')"
                                @update="update('it', arguments)"
                            />
                        </div>

                        <div>
                            <ui-title title="English" />
                            <text-input
                                label="Titolo"
                                name="en_title"
                            />
                            <text-editor
                                ref="en"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('en')"
                                @update="update('en', arguments)"
                            />
                        </div>

                        <div>
                            <ui-title title="Francais" />
                            <text-input
                                label="Titolo"
                                name="fr_title"
                            />
                            <text-editor
                                ref="fr"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('fr')"
                                @update="update('fr', arguments)"
                            />
                        </div>

                        <div>
                            <ui-title title="Serbian" />
                            <text-input
                                label="Titolo"
                                name="sr_title"
                            />
                            <text-editor
                                ref="sr"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sr')"
                                @update="update('sr', arguments)"
                            />
                        </div>

                        <div>
                            <ui-title title="Georgiano" />
                            <text-input
                                label="Titolo"
                                name="ka_title"
                            />
                            <text-editor
                                ref="ka"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('ka')"
                                @update="update('ka', arguments)"
                            />
                        </div>

                        <div>
                            <ui-title title="Slovenian" />
                            <text-input
                                label="Titolo"
                                name="sl_title"
                            />
                            <text-editor
                                ref="sl"
                                label="Descrizione"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sl')"
                                @update="update('sl', arguments)"
                            />
                        </div>

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
            item: null,
            values: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null,
            },
        }
    },
    methods: {
        editorReady: function (key) {},
        update: function (key, values = arguments) {
            let value = values[1]
            this.values[key] = value
        },
        save: function () {},
        show: function (item) {
            this.item = null
            this.values = {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null,
            }

            this.setItem(item).then(() => {
                $(this.$refs.modal).modal('show')
            })
        },
        hide: function () {
            this.item = null
            $(this.$refs.modal).modal('hide')
        },
        setItem: function (item) {
            return new Promise((resolve, reject) => {
                this.item = item

                // let translations = item.translations
                //
                // for (let i = 0; i < translations.length; i++) {
                //     let current = translations[i]
                //     let locale = current.locale
                //
                //     if (this.values.hasOwnProperty(locale)) {
                //         this.values[locale] = current.content
                //
                //         this.$refs[locale].editor.setContent(current.content)
                //     }
                // }

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
