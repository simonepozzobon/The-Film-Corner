<template>
<ui-container
    class="app-container"
    :class="isOpenClass"
>
    <ui-container
        :contain="true"
        v-if="this.app"
        ref="folder"
    >
        <ui-row>
            <ui-block
                size="auto"
                direction="row"
                align="end"
                justify="end"
            >

                <ui-breadcrumbs
                    :app="app | translate('title', $root.locale)"
                    :appPath="app.slug"
                    :cat="app.category | translate('name', $root.locale)"
                    :catPath="app.category.slug"
                    :pavilion="app.category.section | translate('name', $root.locale)"
                    :pavilionPath="app.category.section.slug"
                />

                <ui-folder-corner
                    @click="togglePanel"
                    :color="app.category.color_class"
                    :has-times="open"
                />

            </ui-block>
        </ui-row>
        <ui-row justify="center">
            <ui-block
                size="auto"
                :color="app.category.color_class"
                :radius="true"
                radius-size="md"
            >
                <ui-title
                    tag="h2"
                    font-size="h2"
                    :title="app | translate('title', $root.locale)"
                    class="pt-5"
                />
                <ui-paragraph
                    class="pt-5 app-container__paragraph"
                    align="justify"
                    v-html="translatedDescription"
                />
                <div class="pb-4">
                    <ui-button
                        color="dark"
                        display="inline-block"
                        @click.native="startApp"
                    >
                        Start a new session
                    </ui-button>
                    <ui-button
                        color="dark"
                        display="inline-block"
                        @click.native="togglePanel"
                    >
                        {{ buttonText }}
                    </ui-button>
                </div>
            </ui-block>
        </ui-row>
    </ui-container>
    <ui-app-session-manager
        :app="this.app"
        :open="open"
        :app-sessions="sessions"
        @open-session="startApp"
    />
</ui-container>
</template>

<script>
const clipper = require('text-clipper')
import TranslationFilter from '../../TranslationFilter'
import {
    UiAppSession,
    UiAppSessionManager,
}
from '../../uiapp'
import {
    UiBlock,
    UiBlockHead,
    UiBreadcrumbs,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiList,
    UiListItem,
    UiParagraph,
    UiRow,
    UiSpecialText,
    UiTitle
}
from '../../ui'
export default {
    name: 'AppSingle',
    components: {
        UiAppSession,
        UiAppSessionManager,
        UiBlock,
        UiBlockHead,
        UiBreadcrumbs,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTitle,
    },
    data: function () {
        return {
            slug: null,
            app: null,
            sessions: [],
            open: false,
            description: null,
            buttonText: 'Open existing session',
            isOpenClass: null,
        }
    },
    watch: {
        app: function (app) {
            this.description = app.description
        },
        description: function (newText, oldText) {
            // console.log(oldText, newText);
        }
    },
    computed: {
        section: function () {
            return this.app.category.section.name
        },
        category: function () {
            return this.app.category.name
        },
        appPath: function () {
            return this.app.title
        },
        path: function () {
            return 'Studios / ' + this.section + ' / ' + this.category +
                ' / ' + this.appPath
        },
        translatedDescription: function () {
            return this.$options.filters.translate(this.app, 'description', this.$root.locale)
        }
    },
    methods: {
        getData: function () {
            let slug = this.$route.params.app
            this.$http.get('/api/v2/get-app/' + slug)
                .then(response => {
                    if (response.data.success) {
                        this.app = response.data.app
                        this.sessions = response.data.sessions

                        this.debug()
                    }
                })
        },
        debug: function () {
            this.$nextTick(() => {
                this.togglePanel()
            })
        },
        startApp: function () {
            this.$root.goTo(this.app.slug)
        },
        togglePanel: function () {
            if (this.open) {
                this.open = false
                this.isOpenClass = null
                this.description = this.app.description
                this.buttonText = 'Open existing session'
            }
            else {
                this.open = true
                this.isOpenClass = 'app-container--is-open'
                this.description = clipper(this.app.description, 150, {
                    html: true
                })
                this.buttonText = 'Close Panel'
            }
        }
    },
    filters: {
        ...TranslationFilter,
    },
    created: function () {
        this.getData()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.app-container {
    margin-top: $spacer * 5;

    &__paragraph-container {
        // display: flex;
        // flex-direction: column;
        // justify-content: flex-start;
    }

    &__paragraph {}

    &--is-open &__paragraph {}
}
</style>
