<template>
    <div>
        <container :contains="true" :top-margin="false" padding="no">
            <b-table
                :fields="fields"
                :items.sync="contents"
                hover
                striped
                borderless
            >
                <template v-slot:cell(tools)="data">
                    <ui-button
                        v-if="block.hasTranslations"
                        title="Aggiungi traduzioni"
                        color="orange"
                        size="sm"
                        theme="outline"
                        :has-margin="false"
                        :has-container="false"
                        @click="translate(data.item)"
                    />
                    <ui-button
                        title="Elimina"
                        color="red"
                        size="sm"
                        theme="outline"
                        :has-margin="false"
                        :has-container="false"
                        @click="destroy(data.item)"
                    />
                </template>
            </b-table>
        </container>
        <container :contains="true" padding="no">
            <block-panel ref="panel" :title="`Aggiungi`" title-size="h4">
                <div v-for="field in fields" :key="field.key">
                    <text-editor
                        v-if="field.type == 'text-editor'"
                        ref="content"
                        :has-animation="false"
                        :label="field.label"
                        min-height="50px"
                        @update="updateContent"
                    />
                    <text-input
                        v-else-if="field.type == 'string'"
                        ref="content"
                        :has-animation="false"
                        :label="field.label"
                        min-height="50px"
                        :has-label="false"
                        input-size="col-md-12"
                        @update="updateContent"
                    />
                </div>

                <div class="w-100 d-flex justify-content-center mt-4">
                    <ui-button
                        title="Aggiungi"
                        color="green"
                        theme="outline"
                        :disable="isLoading"
                        :has-spinner="isLoading"
                        :has-margin="false"
                        :has-container="false"
                        @click="save"
                    />
                </div>
            </block-panel>
        </container>
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
    Select2Input
} from "../adminui";

import { UiButton, UiTitle } from "../../ui";
import HomeListModal from "./HomeListModal";
export default {
    name: "HomeList",
    components: {
        BlockPanel,
        Container,
        HomeListModal,
        TextEditor,
        TextInput,
        PanelTitle,
        UiTitle,
        UiButton
    },
    props: {
        title: {
            type: String,
            default: "titolo"
        },
        initials: {
            type: Object,
            default: function() {
                return {};
            }
        },
        block: {
            type: Object,
            default: function() {
                return {};
            }
        },
        debug: {
            type: Boolean,
            default: false
        },
        fields: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data: function() {
        return {
            items: 1,
            contents: [],
            initialized: false,
            values: {},
            isLoading: false,
            current: {}
        };
    },
    watch: {
        initials: function() {
            this.setInitials();
        },
        block: {
            handler: function(block) {
                // console.log(this.block.data);
                this.contents = Object.assign([], block.data);
            },
            deep: true
        },
        values: {
            handler: function(values) {
                this.$emit("update", values);
            },
            deep: true
        }
    },
    computed: {
        hasDebug: function() {
            if (this.debug) {
                return true;
            }
            return false;
        }
    },
    methods: {
        init: function() {
            // console.log("campi per il form", this.fields);
            for (let i = 0; i < this.fields.length; i++) {
                const element = this.fields[i];
                if (element.included != false) {
                    // console.log("valore mancante", element.key);
                    this.values[element.key] = "campo vuoto";
                }
            }

            // console.log(this.block.data);
            if (this.block.data) {
                this.contents = Object.assign([], this.block.data);
            }
        },
        save: function() {
            let data = new FormData();
            const fields = this.fields.filter(field => field.included != false);
            console.log("fields", fields);
            console.log("type", this.block.key);
            data.append("type", this.block.key);
            data.append("fields", JSON.stringify(fields));
            for (let i = 0; i < fields.length; i++) {
                const element = fields[i];
                if (element.included != false) {
                    console.log(element.key, this.values[element.key]);
                    data.append(element.key, this.values[element.key]);
                }
            }

            this.$http
                .post("/api/v2/admin/home/add-list", data)
                .then(response => {
                    const { data } = response;
                });
        },
        updateContent: function() {},
        setInitials: function() {
            for (let key in this.initials) {
                if (
                    this.initials.hasOwnProperty(key) &&
                    this.$refs.hasOwnProperty(key) &&
                    this.$refs[key].editor
                ) {
                    this.$refs[key].editor.setContent(this.initials[key]);
                    this.values[key] = this.initials[key];
                }
            }
        },
        editorReady: function() {
            console.log("reads");
            this.items = this.items - 1;
            if (this.items == 0 && this.initialized == false) {
                this.initialized = true;
                this.$refs.panel.toggleAnim();
            }

            this.$nextTick(() => {
                this.setInitials();
            });
        },
        update: function(key, values = arguments) {
            let value = values[1];
            this.values[key] = value;
        },
        translate: function(item) {
            this.$emit("translate", item, this.block);
        },
        destroy: function(item) {
            this.$emit("destroy", item, this.block);
        }
    },
    mounted: function() {
        this.init();
        this.$nextTick(() => {
            this.setInitials();
        });
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);
.para-single {
    margin-bottom: $spacer * 2.5;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    &__content {
        width: 100%;
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        // @include custom-box-shadow($darken, 2px, 0.02);

        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
    }
}
</style>
