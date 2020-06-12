<template>
    <div
        ref="modal"
        class="modal fade translate"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl" role="document">
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
                            title="Traduci contenuto"
                            title-size="h4"
                            :has-animations="false"
                            :has-footer="true"
                        >
                            <div>
                                <container
                                    :contains="true"
                                    padding="no"
                                    v-for="lang in languages"
                                    :key="lang.key"
                                    :class="lang.key != 'it' ? 'mt-4' : null"
                                >
                                    <block-panel
                                        ref="panel"
                                        :title="lang.label"
                                        :has-animations="false"
                                        title-size="h4"
                                    >
                                        <div
                                            v-for="field in fields"
                                            :key="field.key"
                                        >
                                            <text-editor
                                                v-if="
                                                    field.type == 'text-editor'
                                                "
                                                :ref="`editor-${lang.key}`"
                                                :has-animation="true"
                                                :label="field.label"
                                                min-height="50px"
                                                @ready="editorReady(lang.key)"
                                                @update="
                                                    update(lang.key, arguments)
                                                "
                                            />
                                            <text-input
                                                v-else-if="
                                                    field.type == 'string'
                                                "
                                                :ref="`string-${lang.key}`"
                                                :has-animation="false"
                                                :label="field.label"
                                                min-height="50px"
                                                :has-label="false"
                                                input-size="col-md-12"
                                            />
                                        </div>
                                    </block-panel>
                                </container>
                            </div>
                            <!-- <text-editor
                                ref="it"
                                label="Italiano"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('it')"
                                @update="update('it', arguments)"
                            />

                            <text-editor
                                ref="en"
                                label="English"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('en')"
                                @update="update('en', arguments)"
                            />

                            <text-editor
                                ref="fr"
                                label="Francais"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('fr')"
                                @update="update('fr', arguments)"
                            />

                            <text-editor
                                ref="sr"
                                label="Serbian"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sr')"
                                @update="update('sr', arguments)"
                            />
                            <text-editor
                                ref="ka"
                                label="Georgiano"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('ka')"
                                @update="update('ka', arguments)"
                            />
                            <text-editor
                                ref="sl"
                                label="Slovenian"
                                :has-animation="true"
                                min-height="100px"
                                @ready="editorReady('sl')"
                                @update="update('sl', arguments)"
                            /> -->

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
                <!-- <div class="modal-footer">

            </div> -->
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
    UploadZone
} from "../adminui";

import { UiButton, UiTitle } from "../../ui";
export default {
    name: "TraduzioniParatext",
    components: {
        BlockPanel,
        Container,
        TextEditor,
        TextInput,
        UiTitle,
        UploadZone,
        PanelTitle,
        UiButton
    },
    props: {
        languages: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data: function() {
        return {
            isLoading: false,
            item: null,
            block: {},
            fields: [],
            values: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null
            }
        };
    },
    methods: {
        show: function(item, block) {
            this.item = null;
            this.block = block;
            this.fields = block.fields;
            this.values = {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null
            };

            this.item = item;
            $(this.$refs.modal).modal("show");
            // this.$nextTick(() => {
            //     this.setItem(item).then(() => {});
            // });
        },
        hide: function() {
            this.item = null;
            $(this.$refs.modal).modal("hide");
        },
        setItem: function(lang) {
            return new Promise((resolve, reject) => {
                let item = this.item;
                let translations = item.translations;
                const current = translations.find(
                    trans => trans.locale == lang
                );
                if (current) {
                    this.values[lang] = current;
                    for (let i = 0; i < this.fields.length; i++) {
                        const field = this.fields[i];
                        if (field.icluded != false) {
                            if (field.type == "string") {
                                const input = this.$refs[`string-${lang}`][0];
                                if (input) {
                                    input.value = current[field.key];
                                }
                            } else if (field.type == "text-editor") {
                                const editor = this.$refs[`editor-${lang}`][0];
                                if (editor) {
                                    editor.editor.setContent(
                                        current[field.key]
                                    );
                                }
                            }
                        }
                    }
                } else {
                    console.log("non trovato", lang);
                }

                this.$nextTick(() => {
                    resolve();
                });
            });
        },
        update: function(key, values = arguments) {
            console.log(key, values);

            let value = values[1];
            this.values[key] = value;
        },
        editorReady: function(key) {
            this.setItem(key);
        },
        save: function() {
            this.isLoading = true;
            let data = new FormData();
            const fields = this.fields.filter(field => field.included != false);
            let translations = [];
            // console.log(this.values);
            // console.log(this.item.id);

            data.append("type", this.block.key);
            data.append("id", this.item.id);
            data.append("fields", JSON.stringify(fields));

            for (let key in this.values) {
                if (this.values.hasOwnProperty(key)) {
                    console.log(this.values[key]);
                    const element = this.values[key];
                    if (element) {
                        let values = [];
                        for (let i = 0; i < fields.length; i++) {
                            const field = fields[i];
                            if (
                                field.included != false &&
                                element.hasOwnProperty(field.key)
                            ) {
                                values.push({
                                    key: field.key,
                                    value: element[field.key]
                                });
                                // console.log(field.key, element[field.key]);
                                // data.append(element.key, this.values[element.key]);
                            }
                        }
                        translations.push({
                            locale: key,
                            values: values
                        });
                    }
                }
            }
            data.append("translations", JSON.stringify(translations));
            console.log(translations);

            this.$http
                .post("/api/v2/admin/home/update-list", data)
                .then(response => {
                    this.isLoading = false;
                    // this.$emit("saved", response.data.clip);
                    // this.$ebus.$emit("paratext-saved", response.data.paratext);
                    // this.hide();
                })
                .catch(() => {
                    this.isLoading = false;
                });
        }
    },
    mounted: function() {
        // $(this.$refs.modal).on("shown.bs.modal", e => {
        //     console.log(this.item, this.values);
        // });
        $(this.$refs.modal).on("hide.bs.modal", e => {
            this.item = null;
            this.values = Object.assign(
                {},
                {
                    it: null,
                    en: null,
                    fr: null,
                    sr: null,
                    sl: null,
                    ka: null
                }
            );

            this.$emit("closed");
        });
    }
};
</script>

<style lang="scss">
@import "~styles/shared";

.translate {
    z-index: 9999;

    &__content {
        background-color: transparent;
        box-shadow: none;
        border: none;
    }
}
</style>
