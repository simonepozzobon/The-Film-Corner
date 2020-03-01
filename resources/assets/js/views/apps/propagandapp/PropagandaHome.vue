<template>
    <ui-container>
        <ui-hero-banner
            image="/img/grafica/propaganda/bg-app-80.jpg"
            :full-width="true"
        >
            <ui-row align="center" ver-align="center">
                <div class="col-12">
                    <ui-row :full-width="true" align="center">
                        <ui-title
                            :title="title"
                            font-size="h1"
                            align="center"
                            :uppercase="false"
                            :has-container="true"
                        />
                    </ui-row>

                    <ui-row :full-width="true" align="center">
                        <ui-special-text
                            :has-padding="false"
                            display="inline-block"
                            class="mr-3"
                            :text="$root.getCmd('search_the_clips_intro_home')"
                        />
                    </ui-row>
                    <ui-row :full-width="true" align="center">
                        <ui-button
                            :title="$root.getCmd('advanced_search')"
                            color="red"
                            :has-container="false"
                            :has-margin="false"
                            @click="$root.goTo('propaganda-search')"
                            :disable="true"
                        />
                    </ui-row>

                    <ui-roadmap
                        :channels="channels"
                        @select-channel="selectChannel"
                    />

                    <ui-row align="center" :full-width="true">
                        <ui-button
                            :title="
                                $root.getCmd('go_to_the_creative_challenges')
                            "
                            color="yellow"
                            :has-container="false"
                            :has-margin="false"
                            @click="goToChallenges"
                        />
                    </ui-row>
                </div>
            </ui-row>
        </ui-hero-banner>
        <ui-app-channel-results
            id="channel-result"
            :contents="results"
            :title="currentChannelTitle"
        />
    </ui-container>
</template>

<script>
import Channels from "../../../dummies/PropagandAppContent";
import Utility from "../../../Utilities";

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

import { UiAppChannelResults } from "../../../uiapp";

import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollToPlugin);

export default {
    name: "PropagandaHome",
    components: {
        UiAppChannelResults,
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
    },
    data: function() {
        return {
            title: "Welcome",
            channels: [],
            currentChannel: null,
            results: []
        };
    },
    watch: {
        "$root.user": function(user) {
            this.setWelcome();
        },
        currentChannel: function(channel) {
            this.results = channel.clips;
        }
    },
    computed: {
        currentChannelTitle: function() {
            if (
                this.currentChannel &&
                this.currentChannel.hasOwnProperty("title")
            ) {
                return this.currentChannel.title;
            }

            return null;
        }
    },
    methods: {
        getData: function() {
            // perform api call
            this.$http.get("/api/v2/propaganda/clips").then(response => {
                // console.log(response);
                this.channels = response.data.periods;
            });
            // this.channels = Channels
            // this.debug()
        },
        debug: function() {
            // this.selectChannel(this.channels[2])
        },
        setWelcome: function() {
            this.title = "Welcome " + Utility.capitalize(this.$root.user.name);
            // console.log(this.title);
        },
        enter: function() {},
        leave: function() {},
        selectChannel: function(selected) {
            this.channels = this.channels.map(channel => {
                delete channel.isActive;

                if (channel.id == selected.id) {
                    channel.isActive = true;
                }

                return channel;
            });
            this.currentChannel = selected;

            gsap.to(window, {
                duration: 1,
                scrollTo: {
                    y: "#channel-result",
                    offsetY: 50
                }
            });
        },
        goToChallenges: function() {
            this.$root.goTo("propaganda-challenges");
        }
    },
    created: function() {
        this.getData();
    },
    mounted: function() {
        this.$nextTick(this.setWelcome);
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
