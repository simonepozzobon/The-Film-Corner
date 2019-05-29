<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="The Project"
                    color="white"/>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph :has-padding="false">
                “THE FILM CORNER. Online and offline activities for Film Literacy” project is aimed to the design, release and testing of an online digital virtual user-centered platform for Film Literacy, taking advantage of the opportunities offered by web 2.0 and crossmedia innovative approach in the digital era in order to raise the average film literacy level of EU young audiences. The general aim of the project is to contribute to draw an easy-going model for Film Literacy that could improve Film Literacy skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                The platform consists of an interactive narrative-based environmental layout with game-based didactical resources integrated as apps the user can interact with. Didactical resources will be both based on generic Film Literacy skills and on a set of EU national and non-national films. The platform is to be developed in at least 4 EU languages including english, french, italian and serbian.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                In november 2017, an international conference will take place in the frame of the 10th edition of “Piccolo Grande Cinema” Festival, a film festival dedicated to young audience promoted by Fondazione Cineteca Italiana. During the international conference the platform blueprint will be officially presented and some panels discussing several issues concerning Film Literacy, cross-media and Audience Development and engagement will be discussed. A call for papers will be issued and keynote speakers, including representants from other film literacy project financed in the frame of the Creative Europe Programme will be invited.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-list>
                    <ui-list-item>
                        PROJECT TITLE: The Film Corner. New online and offline activities for Film Literacy
                    </ui-list-item>
                    <ui-list-item>
                        CONTRACT REFERENCE: 2016-2127/001-001-577573-CREA-1-2016-1-IT-MED-AUDEV
                    </ui-list-item>
                    <ui-list-item>
                        LEADING INSTITUTION: Fondazione Cineteca Italiana, Milan, Italy
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-row align="center">
                <ui-block :size="6">
                    <ui-image src="/img/home/eu-flag.jpg" alt="Eu Flag"/>
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title
                title="Partners"
                font-size="h1"/>
            <ui-team
                name="Fondazione Cineteca Italiana"
                img="/img/partners/fondazione-cineteca-italiana.jpg">
                Fondazione Cineteca Italiana (Milan Italy) was established in Milan in 1947 by directors Luigi Comencini and Alberto Lattuada. Member of FIAF since 1948 it develops its activities in collaboration with the Ministry of Culture, Regione Lombardia, Città Metropolitana, Comune di Milano, Comune di Paderno Dugnano, SIAE, Epson, ECFA, Europa Cinemas, University of Milano Bicocca, Parco Nord Milano, Fondazione Mondadori, AEM Milano. Among the 25.000 titles of worldwide films dating since 1895, the Film Archive also preserves a selection of Italian animation. The heritage of Cineteca also boasts about 300 antique cinema devices. Cineteca stores a photo collection of 100.000 pictures, original screenplays, books and magazines and 15.000 affiches. In 2011 Cineteca created two interactive sections for the Museum: MIC-Interactive Film Museum, and the Augmented Reality Film Archive, two permanent exhibitions in which archive, Film Literacy, crossmedia and audience engagement are integrated. Cineteca’s theatres, Spazio Oberdan, Area Metropolis and MIC Theatre, offer around 2,000 screenings and host around 130.000 spectators a year. Cineteca also provides a wide range of educational activities. These are some of the activities provided in 2015: MIC and Augmented Reality Film Archive guided tours with 967 admissions, 65 screenings for schools for a whole of 7.500 spectators with didactical material provision and Q&A, 42 workshops and masterclasses with professionals with 1.067 admissions. Cineteca also organizes Piccolo Grande Cinema Festival, the Festival for schools and families. In 2015 more than 5,000 people were admitted and in 2016 the 9th edition will take place.
            </ui-team>
            <ui-team
                name="Yugoslavenska Kinoteka"
                img="/img/partners/jugoslovenska-kinoteka.jpg">
                Yugoslav Cinémathèque (Belgrade, Serbia) is the national film archive of the Republic of Serbia, founded in 1949, as The Central Film Archives of the Yugoslavenska Filmoteka. Is one of the founders and a permanent member of FIAF since 1951. It consists of four units: Archive of the Yugoslav Cinémathèques, the Museum of Yugoslav Film Archive, Library and General Services. The Archive hosts over 95000 film prints of various national productions, of all genres, silent and sound, black & white and color, both nitrate and acetate. This collection is continuously being added to by means of exchange with foreign archives and by its legal dept. Around 85% of the entire film collection consists of foreign films. The heart of the institution includes the Yugoslav Film Archives, which performs the basic activity of the institution: collecting, permanently preserved and documented on video or film material and supporting film material: photographs, posters, advertising materials, documentation, models, old items in the field of cinema. The Film Archive encourages and helps research and education activities. There are particularly close connections with the Faculty of Dramatic Arts of the University of Arts in Belgrade and the Academy of Arts of the University of Novi Sad. Yugoslav Cinémathèques also takes active part in retrospectives, film workshops, educational screenings, seminars and lectures in cooperation with other film archives.
            </ui-team>
            <ui-team
                name="The Nerve Centre"
                img="/img/partners/the-nerve-centre.jpg">
                The Nerve Centre (Derry, Northern Ireland) is Northern Ireland’s leading creative media arts centre. More than 120000 people a year benefit from the Nerve Centre’s wide-ranging programme of arts events, cutting edge projects, creative learning centres and training opportunities. The Nerve Centre employs more than 40 staff at sites in Derry and Belfast. The Foyle Film Festival is Northern Ireland’s longest running film festival and programmes a range of activity throughout the year. Nerve Centre partners with NI Screen and the BFI in film education for over 5000 young people per year.
            </ui-team>
            <ui-team
                name="The Film Space"
                img="/img/partners/the-film-space.jpg">
                The Film Space (London, UK) recognises the key role that teachers play in introducing children and young people to a wide variety of moving images. Film Space website makes available a raft of teaching interactive resources. The Film Space offers methodologies for developing an understanding of film, encouraging to deliver sustained involvement in long term projects. The Film Space also offers training for teachers across a wide spectrum of film literacy issues.
            </ui-team>
            <ui-team
                name="University of Milano Bicocca"
                img="/img/partners/universita-degli-studi-milano-bicocca.jpg">
                The University of Milano-Bicocca (Milan, Italy) was founded as autonomous organization on June, 10th 1998. The institution of the Department of Educational Human Sciences “Riccardo Massa” was created by a group of professors and researchers involved in the areas of Human and Natural Sciences, History, Philosophy and Pedagogy. Their aim was to promote the study of the educational process at an interdisciplinary level. Areas of research include the evaluation of autobiographical writing methodology in adult education, the educational process of skills and learning models in business, the study of philosophical practices applied to concrete relationships, anthropological research, and the study of Oriental languages.
            </ui-team>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiContainer, UiHeroBanner, UiImage, UiList, UiListItem, UiParagraph, UiRow, UiTeam, UiTitle } from '../ui'

export default {
    name: 'About',
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
        UiTitle,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
