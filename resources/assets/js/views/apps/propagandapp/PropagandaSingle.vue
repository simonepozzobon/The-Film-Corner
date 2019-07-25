<template>
<ui-container>
    <div class="propaganda-back">
        <div class="propaganda-back__container">
            <div class="propaganda-back__content">
                <ui-row class="prop-top">
                    <ui-block
                        :size="8"
                        :has-container="false"
                    >
                        <ui-app-propaganda-player
                            :title="content.title"
                            :src="content.video"
                        />
                    </ui-block>
                    <ui-block
                        :size="4"
                        :has-container="false"
                    >
                        <ui-app-depth-texts
                            :subs="content.subs"
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
                    >
                        <ui-button
                            color="yellow"
                            title="Go to exercises"
                            display="inline-block"
                            :has-container="false"
                            :has-margin="false"
                        />
                    </ui-block>
                </ui-row>
            </div>
        </div>
    </div>
    <modal-panel
        ref="modal"
        :modal="modal"
    />
</ui-container>
</template>

<script>
import {
    movies
}
from '../../../dummies/PropagandAppContent'

import Utility from '../../../Utilities'
import ModalPanel from '../../../uiapp/sub/propaganda/ModalPanel.vue'
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
    UiRow,
}
from '../../../ui'

import {
    UiAppDepthTexts,
    UiAppPropagandaPlayer,
}
from '../../../uiapp'

export default {
    name: 'PropagandaSingle',
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
    },
    data: function () {
        return {
            title: null,
            content: null,
            modal: null
        }
    },
    watch: {},
    computed: {},
    methods: {
        getData: function () {
            let id = this.$route.params.id
            // perform api call
            this.content = movies.find(movie => movie.id == id)
            // this.debug()
        },
        debug: function () {
            // this.selectChannel(this.channels[2])
            this.openModal(5, 1)
        },
        enter: function () {},
        leave: function () {},
        openModal: function (idx, subId = null) {
            console.log(idx, subId);
            let content = this.content.subs.find(content => content.id == idx)
            if (subId && content.hasChildren) {
                let childrens = content.childrens
                let sub = childrens.find(children => children.id == subId)
                this.modal = Object.assign({}, sub)
            }
            else {
                this.modal = Object.assign({}, content)
            }

            console.log(this.modal);

            this.$nextTick(() => {
                this.$refs.modal.show()
            })
        }
    },
    created: function () {
        this.getData()
    },
    mounted: function () {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
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
</style>
