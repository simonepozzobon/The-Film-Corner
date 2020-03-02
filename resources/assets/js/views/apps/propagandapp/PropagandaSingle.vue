<template>
    <ui-container>
        <div class="propaganda-back">
            <div class="propaganda-back__container">
                <div class="propaganda-back__content">
                    <ui-row class="prop-top" v-if="content">
                        <ui-block
                            :size="8"
                            :has-container="false"
                            :v-if="false"
                        >
                            <ui-app-propaganda-player
                                :title="content.title"
                                :translations="content.translations"
                                :ages="content.age.translations"
                                :src="content.video"
                                :captions="content.captions"
                            />
                        </ui-block>
                        <ui-block :size="4" :has-container="false">
                            <ui-app-depth-texts
                                :subs="subs"
                                @open-modal="openModal"
                            />
                        </ui-block>
                        <ui-block
                            class="prop-single-tags"
                            :size="12"
                            :has-container="false"
                        >
                            <ui-button
                                v-for="tag in content.tags"
                                :key="tag.id"
                                :title="'#' + tag.title"
                                color="light-gray"
                                display="inline-block"
                                :has-container="false"
                                :has-margin="false"
                            />
                        </ui-block>
                        <ui-block
                            :size="12"
                            :has-container="false"
                            class="d-flex justify-content-between"
                        >
                            <div>
                                <exercise-button
                                    v-for="exercise in content.exercises"
                                    :key="exercise.id"
                                    class="prop-single-exercise"
                                    :exercise="exercise"
                                />
                            </div>
                            <ui-button
                                :title="$root.getCmd('back')"
                                color="yellow"
                                :has-container="false"
                                :has-margin="false"
                                display="inline-block"
                                @click="$root.goTo('propaganda-home')"
                            />
                        </ui-block>
                    </ui-row>
                </div>
            </div>
        </div>
        <modal-panel ref="modal" :modal="modal" />
    </ui-container>
</template>

<script>
import { movies } from "../../../dummies/PropagandAppContent";

import Utility from "../../../Utilities";
import ModalPanel from "../../../uiapp/sub/propaganda/ModalPanel.vue";
import ExerciseButton from "../../../uiapp/sub/propaganda/ExerciseButton.vue";
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiHeroBanner,
    UiHeroImage,
    UiLink,
    UiParagraph,
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow
} from "../../../ui";

import { UiAppDepthTexts, UiAppPropagandaPlayer } from "../../../uiapp";

export default {
    name: "PropagandaSingle",
    components: {
        ModalPanel,
        UiAppDepthTexts,
        UiAppPropagandaPlayer,
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
        ExerciseButton
    },
    data: function() {
        return {
            title: null,
            content: null,
            modal: null
        };
    },
    watch: {},
    computed: {
        hasContent: function() {
            if (this.content) {
                return true;
            }
            return false;
        },
        hasParatexts: function() {
            if (this.hasContent && this.content.paratexts_formatted) {
                return true;
            }
            return false;
        },
        detail: function() {
            if (this.hasContent && this.content.details.length > 0) {
                return this.content.details[0];
            }
            return null;
        },
        details: function() {
            let keys = ["tech_info", "abstract", "historical_context", "foods"];
            let details = [];

            if (this.detail) {
                for (let key in this.detail) {
                    if (this.detail.hasOwnProperty(key) && keys.includes(key)) {
                        let newObj = {
                            key: key,
                            clip_id: this.detail.clip_id,
                            detail_id: this.detail.id,
                            type: "text",
                            hasChildren: false,
                            description: this.detail[key]
                        };

                        details.push(newObj);
                    }
                }

                for (let i = 0; i < details.length; i++) {
                    let detail = details[i];
                    let translations = this.detail.translations.map(
                        translation => {
                            return {
                                locale: translation.locale,
                                content: translation[detail.key]
                            };
                        }
                    );

                    details[i] = {
                        idx: Utility.uuid(),
                        ...details[i],
                        translations: translations
                    };
                }
            }

            return details;
        },
        paratexts: function() {
            if (this.hasParatexts) {
                return Object.assign([], this.content.paratexts_formatted)
                    .filter(el => el != null)
                    .map(item => {
                        return {
                            idx: Utility.uuid(),
                            ...item,
                            paratext: Object.assign([], item.paratext).filter(
                                el => el != null
                            )
                        };
                    });
            }
            return [];
        },
        subs: function() {
            if (this.details.length > 0 && this.paratexts.length > 0) {
                let subs = [];
                return subs.concat(this.details).concat(this.paratexts);
            } else if (this.details.length > 0) {
                return this.details;
            } else if (this.paratexts.length > 0) {
                return this.paratexts;
            }

            return [];
        }
    },
    methods: {
        getData: function() {
            let id = this.$route.params.id;
            // perform api call
            let url = "/api/v2/propaganda/clip/" + id;
            this.$http.get(url).then(response => {
                // console.log(response);
                if (response.data.success) {
                    this.content = response.data.clip;
                }
                // console.log(this.paratexts);

                // this.debug()
            });
            // this.content = movies.find(movie => movie.id == id)
        },
        debug: function() {
            // Test dei modal per i paratesti
            // setTimeout(() => {
            //     let idx = this.details[1].idx
            //     console.log(this.details[1]);
            //     this.openModal(idx, null)
            // }, 1500)
            console.log(this.content);
        },
        enter: function() {},
        leave: function() {},
        openModal: function(idx, subId = null) {
            let content = this.subs.find(content => content.idx == idx);
            this.modal = Object.assign({}, content);

            this.$nextTick(() => {
                this.$refs.modal.show();
            });
        },
        goToExercise: function(id) {
            console.log("deprecata");
        }
    },
    created: function() {
        this.getData();
    },
    mounted: function() {}
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
.propaganda-back {
    padding-top: 90px;
    background-image: url("/img/grafica/propaganda/bg-app-80.jpg");
    background-position: top;
    background-size: cover;

    &__container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &__content {
        padding: $spacer * 2;
    }
}

.prop-single-tags {
    margin-top: $spacer;
    margin-bottom: $spacer;
}

.prop-single-exercise {
    margin-right: $spacer;
}
</style>
