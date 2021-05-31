<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Schools"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph
                v-for="(schools, country, key) in countries"
                :key="key"
            >
                <ui-title :title="country" />
                <ui-list>
                    <ui-list-item v-for="school in schools" :key="school.id">
                        {{ school.name }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { schools } from "../dummies/schools";
import {
    UiContainer,
    UiHeroBanner,
    UiList,
    UiListItem,
    UiParagraph,
    UiTitle
} from "../ui";

export default {
    name: "Schools",
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiTitle
    },
    data: function() {
        return {
            scIT: schools.IT,
            scNR: schools.Nr,
            scSR: schools.SR,
            scUK: schools.UK,
            scGE: schools.GE,
            scSL: schools.SL,
            countries: []
        };
    },
    methods: {
        getSchools: function() {
            this.$http.get("/api/v2/schools").then(response => {
                console.log(response);
                this.countries = response.data.schools;
            });
        }
    },
    mounted: function() {
        this.getSchools();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
