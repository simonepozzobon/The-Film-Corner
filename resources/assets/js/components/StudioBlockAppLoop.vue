<template lang="html">
    <div>
        <li
            class="menu-item"
            v-for="app in sortedApps"
            @click="goToApp(app.slug)"
        >
            {{ app | translate("title", $root.locale) }}
        </li>
    </div>
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

<style lang="scss" scoped>
@import "~styles/shared";

.menu-item {
    cursor: pointer;

    &:hover {
        text-decoration: underline;
    }
}
</style>
