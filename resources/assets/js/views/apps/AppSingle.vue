<template>
    <ui-container class="app-container">
        <ui-container :contain="true" v-if="this.app">
            <ui-row>
                <ui-block
                    size="auto"
                    direction="row"
                    align="end"
                    justify="end">

                    <ui-breadcrumbs
                        :app="app.title"
                        :appPath="app.slug"
                        :cat="app.category.name"
                        :catPath="app.category.slug"
                        :pavilion="app.category.section.name"
                        :pavilionPath="app.category.section.slug"
                        />

                    <ui-folder-corner
                        @closed="closed"
                        :color="app.category.color_class"
                        :has-times="true"/>

                </ui-block>
            </ui-row>
            <ui-row
                justify="center">
                <ui-block
                    size="auto"
                    :color="app.category.color_class"
                    :radius="true"
                    radius-size="md">
                    <ui-title
                        tag="h2"
                        font-size="h2"
                        :title="app.title"
                        class="pt-5"/>
                    <ui-paragraph
                        class="pt-5"
                        align="justify"
                        v-html="app.description" />
                    <div class="pb-4">
                        <ui-button
                            color="dark"
                            display="inline-block"
                            @click.native="startApp">
                            Start a new session
                        </ui-button>
                        <ui-button
                            color="dark"
                            display="inline-block">
                            Open existing session
                        </ui-button>
                    </div>
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container
            :contain="true"
            v-if="this.app"
            class="app-container__sessions">
            <ui-row
                justify="center">
                <ui-block-head
                    class="app-container__list"
                    :size="12"
                    title="Open Existing Session"
                    :color="app.category.color_class"
                    :radius="true"
                    radius-size="md">
                    <ui-app-session
                        v-for="(session, i) in sessions"
                        :key="session.id"
                        :counter="i"
                        :idx="session.id"
                        :title="session.title"
                        :token="session.token"
                        @open-session="openSession"
                        @delete-session="deleteSession"/>
                </ui-block-head>
            </ui-row>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiAppSession } from '../../uiapp'
import { UiBlock, UiBlockHead, UiBreadcrumbs, UiButton, UiContainer, UiFolderCorner, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'
export default {
    name: 'AppSingle',
    components: {
        UiAppSession,
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
    data: function() {
        return {
            slug: null,
            app: null,
            sessions: [],
        }
    },
    computed: {
        section: function() {
            return this.app.category.section.name
        },
        category: function() {
            return this.app.category.name
        },
        appPath: function() {
            return this.app.title
        },
        path: function() {
            return 'Studios / ' + this.section + ' / ' + this.category + ' / ' + this.appPath
        }
    },
    methods: {
        getData: function() {
            let slug = this.$route.params.app
            this.$http.get('/api/v2/get-app/' + slug).then(response => {
                if (response.data.success) {
                    this.app = response.data.app
                    this.sessions = response.data.sessions
                }
            })
        },
        closed: function() {
            this.$root.goToWithParams('cat-home', { cat: this.app.category.slug })
        },
        startApp: function() {
            this.$root.goTo(this.app.slug)
        },
        deleteSession: function(idx) {
            let url = '/api/v2/session/' + idx + '/false'
            this.$http.delete(url).then(response => {
                if (response.data.success) {
                    this.sessions = this.sessions.filter(session => session.token != idx)
                }
            })
        },
        openSession: function(idx) {
            let session = this.sessions.filter(session => session.token == idx)[0]
            session.content = JSON.parse(session.content)
            this.$root.session = session
            this.$nextTick(this.startApp)
        }
    },
    created: function() {
        this.getData()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.app-container {
    margin-top: $spacer * 5;

    &__sessions {
        margin-top: $spacer * 1.618;
    }
}
</style>
