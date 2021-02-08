<template>
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="The Film Corner International Online Conference"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph :has-padding="false">
                <ui-title title="Film Education. Rethinking the future" />
                The Film Corner International Conference, an online event
                promoted by Fondazione Cineteca Italiana to trace a common path
                of reflection around film education across Europe
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                Between october 22nd and November 5th, 2020, Piccolo Grande
                Cinema-Cineteca Milano Festival will host the final conference
                of the current edition of The Film Corner, the european project
                that aims to design, release and test an online ineractive
                platform for film education. The project involves 7 European
                institutions in 6 EU countries and is co-financed by the
                European Commission in the frame of the Creative Europe
                Programme. The conference will take place online in English as a
                series of four focused seminars plus an italian day focused on
                institutional initiatives and national best practices
                showcasing.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                From March 2020 until recently schools and cinemas across Europe
                have been closed. Teachers have had to find new ways of
                delivering all education, not simply film education. And now,
                with cinemas reopening, they will have to think of ways of
                bringing back audiences who for the past four/five months have
                been used to consuming films via streaming services.
                <br />
                Given that the world will not find its “new normal” shortly then
                key issues remain to be explored regarding film education – how
                it is delivered, how films can be legally accessed and also what
                a “new” film education pedagogy might look like. Is blended
                learning the answer? How can cinemas partake in this? What is on
                offer and what can be offered/developed? What might the future
                hold and what might European cooperation look like in 2021?
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                The conference will take place online on the Discord platform in
                English and in multiple panels and will host more than 20
                speakers from 15 countries, representants of transnational
                bodies such as EFADs-European Film Agencies Directors and some
                of the most relevant international organizations in the field of
                film education including Danish Film Institute (Denmark), Vision
                Kino (Germany), British Film Institute (UK), Institut Français
                (France).
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                It begins on October 22nd at 5.30 pm with a panel dedicated to
                the use of online educational resources for film education
                during which a preview of the new version of The Film Corner
                platform will be offered, on October 28th at 5.30 pm production
                of audiovisuals in education and schools will be discussed, on
                October 29 at 1730 we will discuss how festivals and reviews
                take up the challenge of social distancing and it will close on
                5 November with an international panel that includes the
                intervention of Maria Silvia Gatta, representative of the
                European Commission – DG Connect.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Schedule" />
                OCT 22, 5.30 pm (CET) - Learning on screen. Online teaching
                resources for Film Education<br />
                OCT 28, 5.30 pm (CET) - Young people make films. From creativity
                to self-expression<br />
                OCT 29, 5.30 pm (CET) - Screenings and festivals for children
                and social distancing. What impact for the future?<br />
                NOV 4, 4 pm (CET) - Tra vedere e fare. Storie e testimonianze di
                film education (italian day)<br />
                NOV 5, 5.30 pm (CET) - Film Education. A European perspective<br />
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Scientific Committee" />
                Aleksandar Erdeljanovic (Yugoslovenska Kinoteka, SR)<br />
                Emanuela Mancino (University of Milano-Bicocca, IT)<br />
                Ian Wall (The Film Space, UK)<br />
                Eavan King (The Nerve Centre, UK)<br />
                Ana Cerar (Otok, SI)<br />
                Tea Gabidzashvili (Georgian National FilmCentre, KA)<br />
                Florence Dupont (Enfances au cinéma, FR)<br />
                Enzo Bevar (Fondazione Cinemovel, IT)<br />
                Rosa Ferro (Nuovo Fantarca, IT)<br />
                Simone Venturini (University of Udine, IT)<br />
                Simone Moraldi (Fondazione Cineteca Italiana, IT)<br />
                Silvia Pareti (Fondazione Cineteca Italiana, IT)<br />
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Scientific Secretary" />
                Simone Moraldi (Fondazione Cineteca Italiana, IT) <br />
                Chiara Scurati (Fondazione Cineteca Italiana, IT) <br />
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Press Office" />
                Cristiana Ferrari (Fondazione Cineteca Italiana, IT)
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Speakers" />
                Vincenzo Ardito (Cooperativa GET, Sinapsi produzioni
                partecipate, IT)<br />
                Ralitsa Assenova (Arte Urbana Collectif, BG)<br />
                Enzo Bevar (Fondazione Cinemovel ,IT)<br />
                Emilie Boucheteil (Institu Français, FR)<br />
                Marco Chiarini (Cineforum Teramo, IT)<br />
                Letizia Cortini (Archivio Audiovisivo del Movimento Operaio e
                Democratico, IT)<br />
                Jon Etcheverria (A bao a qu, ES)<br />
                Rosa Ferro (Nuovo Fantarca, IT)<br />
                Maria Leonida (Karpos, GR)<br />
                Bernard McCloskey (Northern Ireland Screen, NI)<br />
                Maria Silvia Gatta (European Commission, DG Connect)<br />
                Sabine Genz (Vision Kino, DE)<br />
                Charlotte Giese (Danish Film Institute, DE)<br />
                Elisa Giovannelli (Fondazione Cineteca di Bologna, IT)<br />
                Claus Noer Hjorth (EFADs- European Film Agencies Directors,
                DE)<br />
                Emanuela Mancino (University of Milano-Bicocca, IT)<br />
                Leonardo Moggi (Lanterne Magiche/Fondazione Sistema Toscana,
                IT)<br />
                Tommi Nevala (Oulu Film School for Children, FI)<br />
                Manlio Piva (Università di Padova IT)<br />
                Mark Reid (British Film Institute, UK)<br />
                Olaf Schneider (Neue Wege des Lernens, DE)<br />
                Claire Shaw (Cinemagic, NI)<br />
                Ania Stadnik-Wojtowicz (Cinema in Sneakers, PL)<br />
                Raffaella Traniello (Corti a ponte, IT)<br />
                Simone Venturini (Università di Udine, IT)<br />
            </ui-paragraph>
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
export default {
    name: "ConferenceOnline",
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
    }
};
</script>
<style lang="scss"></style>
