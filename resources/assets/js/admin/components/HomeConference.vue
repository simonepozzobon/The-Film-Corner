<template>
    <container :contains="true" :has-animations="true">
        <block-panel title="Conferenza" :has-footer="true">
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
                    title="Salva"
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
    name: "Conferenza",
    components: {
        Container,
        BlockPanel,
        TextEditor,
        UiButton
    },
    data: function() {
        return {
            initials: {},
            ready: {
                it: false,
                en: false,
                fr: false,
                sr: false,
                sl: false,
                ka: false
            },
            content: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null
            },
            isLoading: true
        };
    },
    watch: {
        initials: function(initials) {
            // this.setInitials();
        }
    },
    methods: {
        getData: function() {
            this.$http
                .get("/api/v2/admin/home/get-conference")
                .then(response => {
                    let contents = response.data.text.translations;
                    for (let i = 0; i < contents.length; i++) {
                        const element = contents[i];
                        const locale = element.locale;
                        this.initials[locale] = element.content;
                    }
                    // console.log(this.initials);
                    this.$nextTick(this.setInitials);
                });
        },
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
                this.$nextTick(() => {
                    this.setInitials();
                    this.isLoading = false;
                });
            }
        },
        setInitials: function() {
            // console.log("set initials");
            let keys = Object.keys(this.content);
            for (let i = 0; i < keys.length; i++) {
                const key = keys[i];
                if (
                    this.initials.hasOwnProperty(key) &&
                    this.$refs.hasOwnProperty(key) &&
                    this.$refs[key].editor
                ) {
                    let value = this.initials[key];
                    // console.log("setting editor");
                    this.$refs[key].editor.setContent(value);
                }
            }
        },
        update: function(value, isEditor = false, key = null) {
            if (key && this.content.hasOwnProperty(key)) {
                this.content[key] = value;
            }
        },
        save: function() {
            this.isLoading = true;

            let data = new FormData();
            data.append("it", this.content.it);
            data.append("en", this.content.en);
            data.append("fr", this.content.fr);
            data.append("sr", this.content.sr);
            data.append("sl", this.content.sl);
            data.append("ka", this.content.ka);

            this.$http
                .post("/api/v2/admin/home/save-conference", data)
                .then(response => {
                    // console.log(response.data);
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;
                });
        }
    },
    created: function() {
        this.getData();
    },
    mounted: function() {
        // this.setInitials();
    }
};
</script>
<style lang="scss"></style>
