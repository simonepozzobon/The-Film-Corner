<template>
    <div class="admin-home">
        <container
            :contains="true"
            :has-animations="true"
            v-for="block in blocks"
            :key="block.key"
        >
            <block-panel
                :title="block.title"
                :has-footer="true"
                v-if="block.type == 'text-editor'"
            >
                <home-block
                    v-for="lang in languages"
                    :key="lang.key"
                    :class="lang.key != 'it' ? 'mt-4' : null"
                    :title="lang.label"
                />
            </block-panel>
            <block-panel
                :title="block.title"
                :has-footer="true"
                v-else-if="block.type == 'list'"
            >
                <home-list
                    :fields="block.fields"
                    :block="block"
                    @translate="translate"
                ></home-list>
            </block-panel>
        </container>
        <home-list-modal ref="translate" :languages="languages" />
    </div>
</template>

<script>
import { Container, BlockPanel, TextEditor } from "../adminui";
import HomeBlock from "../components/HomeBlock";
import HomeList from "../components/HomeList";
import HomeListModal from "../components/HomeListModal";
export default {
    name: "AdminHome",
    components: {
        Container,
        BlockPanel,
        TextEditor,
        HomeBlock,
        HomeList,
        HomeListModal
    },
    data: () => {
        return {
            languages: [
                {
                    key: "it",
                    label: "Italiano"
                },
                {
                    key: "en",
                    label: "Inglese"
                },
                {
                    key: "fr",
                    label: "Francese"
                },
                {
                    key: "sr",
                    label: "Serbo"
                },
                {
                    key: "sl",
                    label: "Sloveno"
                },
                {
                    key: "ka",
                    label: "Georgiano"
                }
            ],
            keys: ["tech_info", "abstract", "historical_context", "foods"],
            values: {
                it: {},
                en: {},
                fr: {},
                sr: {},
                sl: {},
                ka: {}
            },
            blocks: [
                {
                    key: "project",
                    title: "Il Progetto",
                    type: "text-editor"
                },
                {
                    key: "schools",
                    title: "Scuole",
                    type: "list",
                    fields: [
                        {
                            key: "name",
                            label: "Nome",
                            type: "string"
                        },
                        {
                            key: "description",
                            label: "Descrizione",
                            type: "text-editor"
                        }
                    ]
                },
                {
                    key: "conference",
                    title: "Conferenza",
                    type: "text-editor"
                },
                {
                    key: "filmography",
                    title: "Filmografia",
                    type: "list",
                    hasTranslations: true,
                    fields: [
                        {
                            key: "id",
                            label: "id",
                            included: false
                        },
                        {
                            key: "title",
                            label: "Titolo",
                            type: "string"
                        },
                        {
                            key: "description",
                            label: "Descrizione",
                            type: "text-editor"
                        },
                        {
                            key: "tools",
                            label: "Tools",
                            included: false
                        }
                    ]
                }
            ]
        };
    },
    methods: {
        init: function() {
            this.$http.get("/api/v2/admin/home").then(response => {
                const { data } = response;
                // console.log(data);
                for (let i = 0; i < this.blocks.length; i++) {
                    const element = this.blocks[i];

                    if (element.type == "list") {
                        if (data.hasOwnProperty(element.key)) {
                            this.blocks.splice(i, 1, {
                                ...element,
                                data: data[element.key]
                            });
                        } else {
                            this.blocks[i]["data"] = [];
                        }
                    }
                }

                let block = this.blocks[3];
                let item = block.data[2];
                this.translate(item, block);
            });
        },
        translate: function(item, block) {
            this.$refs.translate.show(item, block);
            this.current = item;
        }
    },
    mounted: function() {
        this.init();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
