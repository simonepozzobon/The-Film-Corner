<template>
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="The Project"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <div v-if="content" v-html="translateContent"></div>
            <div
                v-else
                class="d-flex justify-content-center align-items-center w-100"
            >
                <span
                    class="spinner-border spinner-border-xl text-green w-16 h-16"
                    ref="spinner"
                    role="status"
                    aria-hidden="true"
                ></span>
            </div>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-row align="center">
                <ui-block :size="6">
                    <ui-image src="/img/home/eu-flag.jpg" alt="Eu Flag" />
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title title="Partners" font-size="h1" />
            <ui-team
                name="Fondazione Cineteca Italiana"
                img="/img/partners/fondazione-cineteca-italiana.jpg"
            >
                FONDAZIONE CINETECA ITALIANA (Milan, Italy) was established in
                Milan in 1947 by directors Luigi Comencini and Alberto Lattuada.
                Member of FIAF since 1948 it develops its activities in
                collaboration with the Ministry of Culture, Regione Lombardia,
                Città Metropolitana, Comune di Milano and other public and
                private institutions. Among the 25.000 titles of worldwide films
                dating since 1895, the Film Archive also preserves a batch of
                Italian animation. The heritage of Cineteca also boasts about
                300 antique early cinema devices. Cineteca stores a photo
                collection of 100.000 pictures, original screenplays, books and
                magazines and 15.000 affiches. In 2011 Cineteca created two
                interactive sections of the Museum: MIC-Interactive Film Museum,
                and the Augmented Reality Film Archive. Cineteca’s theatres,
                ex-Spazio Oberdan, Area Metropolis and MIC Theatre, offer around
                2,000 screenings and host around 130.000 spectators a year.
                Cineteca also provides a wide range of educational activities:
                MIC and Augmented Reality Film Archive guided tours with 967
                admissions, 65 screenings for schools for a whole of 7.500
                spectators, 42 workshops and masterclasses with professionals
                with 1.067 admissions. Cineteca also organizes Piccolo Grande
                Cinema Festival, the Festival for schools and families.
                Moreover, since february 2018 Fondazione Cineteca Italiana will
                collaborate with MEET, the first International Centre for
                Digital Culture in the ex-Spazio Oberdan. The project, designed
                by the digital centre Meet The Media Guru with the support of
                Fondazione Cariplo, shows and makes available creative ideas and
                innovative projects to reduce Italian digital cultural divide
                and guarantee an increasingly more active participation with an
                approach centred on meeting and inclusion. MEET proposes a
                massive plan of on line and on site initiatives that bring man
                back at the forefront of technological change with international
                partners throughout the world.
            </ui-team>
            <ui-team
                name="Yugoslovenska Kinoteka"
                img="/img/partners/jugoslovenska-kinoteka.jpg"
            >
                JUGOSLOVENSKA KINOTEKA (Belgrade, Serbia) is the national film
                archive of the Republic of Serbia, founded in 1949. Is one of
                the founders and a permanent member of FIAF since 1951. It
                consists of four units: Archive of the Yugoslav Cinémathèques,
                the Museum of Yugoslav Film Archive, Library and General
                Services. The Archive hosts over 95000 film prints of various
                national productions, Around 85% of the entire film collection
                consists of foreign films. Kinoteka organizes every year the
                “Nitrate film festival”.
            </ui-team>
            <ui-team
                name="The Nerve Centre"
                img="/img/partners/the-nerve-centre.jpg"
            >
                THE NERVE CENTRE (Derry, Northern Ireland) is Northern Ireland’s
                leading creative media arts centre. More than 120.000 people a
                year benefit from the Nerve Centre’s wide-ranging programme of
                arts events, cutting edge projects, creative learning centres
                and training opportunities. The Foyle Film Festival is Northern
                Ireland’s longest running film festival and programmes a range
                of activity throughout the year.
            </ui-team>
            <ui-team
                name="The Film Space"
                img="/img/partners/the-film-space.jpg"
            >
                THE FILM SPACE (Manchester, UK) recognises the key role that
                teachers play in introducing children and young people to a wide
                variety of moving images. Film Space website makes available a
                raft of teaching interactive resources. The Film Space offers
                methodologies for developing an understanding of film,
                encouraging to deliver sustained involvement in long term
                projects.
            </ui-team>
            <ui-team
                name="University of Milano Bicocca"
                img="/img/partners/universita-degli-studi-milano-bicocca.jpg"
            >
                THE UNIVERSITY OF MILANO-BICOCCA (Milan, Italy) was founded as
                autonomous organization in 1998. The institution of the
                Department of Educational Human Sciences “Riccardo Massa” was
                decided by a group of professors and researchers involved in the
                areas of Human and Natural Sciences, History, Philosophy and
                Pedagogy.
            </ui-team>
            <ui-team
                name="otok-institute for the development of film culture"
                img="/img/partners/logo_otok_zavod.png"
            >
                OTOK-INSTITUTE FOR THE DEVELOPMENT OF FILM CULTURE (Ljubliana,
                Slovenia) is a non-profit organisation established in 2003 and
                the main producer of the Kino Otok – Isola Cinema International
                Film Festival. Kino Otok brings a selection of about 100 films
                ranging all genres to an audience of 9,000. The relevance of the
                festival has been widely recognized throughout Slovenian public
                bodies, such as Slovene Ministry of Culture and Slovenian Film
                Centre. Otok Institute is also the organiser of film-related
                events. As part of the Kino Otok festival, the Submarine
                programme offers film education activities for children and
                youngsters between 4 and 18 years of age. Otok has been a part
                of Young Audience Award, organised by European Film Academy.
            </ui-team>
            <ui-team
                name="Georgian National Film Center"
                img="/img/partners/logo_feradi.png"
            >
                THE GEORGIAN NATIONAL FILM CENTER (Tbilisi, Georgia) is a legal
                entity of public law under the Ministry of Culture and Monument
                Protection of Georgia. The goal of GNFC is to secure and
                coordinate state support for the development of Georgian
                Cinema.The organization also conducts various workshops for film
                professionals.
            </ui-team>
        </ui-container>
    </ui-container>
</template>

<script>
import {
    UiBlock,
    UiContainer,
    UiHeroBanner,
    UiImage,
    UiList,
    UiListItem,
    UiParagraph,
    UiRow,
    UiTeam,
    UiTitle
} from "../ui";

import TranslationFilter from "../TranslationFilter";

export default {
    name: "About",
    mixins: [TranslationFilter],
    components: {
        UiBlock,
        UiContainer,
        UiHeroBanner,
        UiImage,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiTeam,
        UiTitle
    },
    data: function() {
        return {
            content: null
        };
    },
    computed: {
        translateContent: function() {
            return this.$options.filters.translate(
                this.content,
                "content",
                this.$root.locale
            );
        }
    },
    methods: {
        getData: function() {
            this.$http.get("/api/v2/project").then(response => {
                this.content = response.data.text;
            });
        }
    },
    created: function() {
        this.getData();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
