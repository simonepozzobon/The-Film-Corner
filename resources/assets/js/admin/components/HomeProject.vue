<template>
    <container :contains="true" :has-animations="true">
        <block-panel title="Progetto" :has-footer="true">
            <text-editor
                ref="it"
                :has-animation="false"
                min-height="50px"
                label="Italiano"
                field-key="it"
                @ready="setReady('it')"
                @update="update"
            />
            <text-editor
                ref="en"
                :has-animation="false"
                min-height="50px"
                label="Inglese"
                field-key="en"
                @ready="setReady('en')"
                @update="update"
            />
            <text-editor
                ref="fr"
                :has-animation="false"
                min-height="50px"
                label="Francese"
                field-key="fr"
                @ready="setReady('fr')"
                @update="update"
            />
            <text-editor
                ref="sr"
                :has-animation="false"
                min-height="50px"
                label="Serbo"
                field-key="sr"
                @ready="setReady('sr')"
                @update="update"
            />
            <text-editor
                ref="sl"
                :has-animation="false"
                min-height="50px"
                label="Sloveno"
                field-key="sl"
                @ready="setReady('sl')"
                @update="update"
            />
            <text-editor
                ref="ka"
                :has-animation="false"
                min-height="50px"
                label="Georgiano"
                field-key="ka"
                @ready="setReady('ka')"
                @update="update"
            />

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
</template>
<script>
import { Container, BlockPanel, TextEditor } from "../adminui";
import { UiButton } from "../../ui";
export default {
    name: "Progetto",
    components: {
        Container,
        BlockPanel,
        TextEditor,
        UiButton
    },
    data: function() {
        return {
            initials: {
                it: "gianni",
                en: "porco",
                ka: "dfkjdkdjjfdk"
            },
            ready: {
                it: false,
                en: false,
                fr: false,
                sr: false,
                ka: false
            },
            content: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                ka: null
            },
            isLoading: true
        };
    },
    methods: {
        setReady: function(key) {
            this.ready[key] = true;

            let keys = Object.keys(this.ready);
            let completed = true;
            for (let i = 0; i < keys.length; i++) {
                const current = keys[i];
                if (current == false) {
                    completed = false;
                }
            }

            if (completed) {
                this.setInitials();
            }
        },
        setInitials: function() {
            let keys = Object.keys(this.content);
            for (let i = 0; i < keys.length; i++) {
                const key = keys[i];
                if (
                    this.initials.hasOwnProperty(key) &&
                    this.$refs.hasOwnProperty(key) &&
                    this.$refs[key].editor
                ) {
                    let value = this.initials[key];
                    this.$refs[key].editor.setContent(value);
                }
            }
        },
        update: function(value, isEditor = false, key = null) {
            if (key && this.content.hasOwnProperty(key)) {
                this.content[key] = value;
            }
        },
        save: function() {}
    },
    mounted: function() {
        // this.setInitials();
    }
};
</script>
<style lang="scss"></style>
