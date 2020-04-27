<template>
    <div
        ref="modal"
        class="modal fade translate"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg" role="document">
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
                            <text-editor
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
                            />

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
} from "../../../adminui";

import { UiButton, UiTitle } from "../../../../ui";
export default {
    name: "TraduzioniParatext",
    components: {
        BlockPanel,
        Container,
        TextEditor,
        UiTitle,
        UploadZone,
        PanelTitle,
        UiButton
    },
    props: {
        clip: {
            type: Object,
            default: function() {
                return {};
            }
        }
    },
    data: function() {
        return {
            isLoading: false,
            item: null,
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
        show: function(item) {
            this.item = null;
            this.values = {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null
            };

            this.setItem(item).then(() => {
                $(this.$refs.modal).modal("show");
            });
        },
        hide: function() {
            this.item = null;
            $(this.$refs.modal).modal("hide");
        },
        setItem: function(item) {
            return new Promise((resolve, reject) => {
                this.item = item;

                let translations = item.translations;

                for (let i = 0; i < translations.length; i++) {
                    let current = translations[i];
                    let locale = current.locale;
                    // console.log("tentativo", locale);
                    if (this.values.hasOwnProperty(locale)) {
                        this.values[locale] = current.content;
                        // console.log("setting item", locale, current.content);
                        this.$refs[locale].editor.setContent(current.content);
                    }
                }

                for (const locale in this.values) {
                    if (this.values.hasOwnProperty(locale)) {
                        const value = this.values[locale];
                        // console.log(value, locale);
                        if (value == null || !value) {
                            this.$refs[locale].editor.clearContent();
                            // console.log("da svuotare", locale);
                        }
                    }
                }

                this.$nextTick(() => {
                    resolve();
                });
            });
        },
        update: function(key, values = arguments) {
            let value = values[1];
            this.values[key] = value;
        },
        editorReady: function(key) {},
        save: function() {
            this.isLoading = true;
            let data = new FormData();
            let translations = [];

            data.append("id", this.item.id);
            data.append("clip_id", this.clip.id);

            for (let key in this.values) {
                if (this.values.hasOwnProperty(key) && this.values[key]) {
                    translations.push({
                        locale: key,
                        value: this.values[key]
                    });
                }
            }
            data.append("translations", JSON.stringify(translations));

            this.$http
                .post("/api/v2/admin/clips/translations/paratext", data)
                .then(response => {
                    this.isLoading = false;
                    this.$emit("saved", response.data.clip);
                    this.$ebus.$emit("paratext-saved", response.data.paratext);
                    this.hide();
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
