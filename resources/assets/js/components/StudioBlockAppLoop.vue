<template lang="html">
    <ul class="block-menu">
        <li
            class="menu-item"
            :class="itemClass"
            v-for="app in sortedApps"
            @click="goToApp(app.slug)"
        >
            {{ app | translate("title", $root.locale) }}
        </li>
    </ul>
</template>

<script>
import TranslationFilter from "../TranslationFilter";

export default {
    name: "StudioBlockAppLoop",
    mixins: [TranslationFilter],
    props: {
        apps: {
            type: Array,
            default: function() {
                return [];
            }
        },
        itemClass: {
            type: String,
            default: null
        }
    },
    computed: {
        sortedApps: function() {
            if (this.apps.length > 0) {
                return this.apps
                    .filter(app => app.active == 1)
                    .sort((a, b) => {
                        return a.order - b.order;
                    });
            }

            return [];
        }
    },
    methods: {
        goToApp: function(slug) {
            this.$root.goToWithParams("app-home", {
                app: slug
            });
        }
    },
    mounted: function() {}
};
</script>

<style lang="scss">
@import "~styles/shared";
.block-menu {
    text-align: center;
    list-style-type: none;
    padding-inline-start: 0;
    color: $black;
    font-size: $font-size-base;
}

.menu-item {
    cursor: pointer;

    &:hover {
        text-decoration: underline;
    }
}
</style>
