<template lang="html">
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="International Conference"
                    color="white"/>
                <ui-special-text color="white" align="center">
                    About the conference
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph :has-padding="false">
                The Film Corner International Conference is open to the public and addressed to professionals and trainers of film education, media education, information and communication technology as well as gaming professionals. The conference will take place during the 9th edition of Piccolo Grande Cinema Festival in Milan, a film festival dedicated to young audiences organised by Fondazione Cineteca Italiana. The main issues of the conference are:
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-list>
                    <ui-list-item>
                        Launch of The Film Corner platform: the first version of The Film Corner interactive online platform for film education will be launched at the conference.
                    </ui-list-item>
                    <ui-list-item>
                        Methodologies for film education in the digital era: during the last twenty years the audiovisual sector has been undergoing radical changes in all the aspects of the production and distribution value-chain. The crossover between film and web 2.0 has radically changed the relationship of people with film, both in filmmaking and in the accessibility to audiovisual content. These changes are also reflected in film education: how does film education change given the new experiences of the digital era? What are the potentials and risks within the new technological environment? How far have audiences’ experiences and best practices developed? Can we go further? What is the role of the institutions devoted to film heritage preservation in this process?
                    </ui-list-item>
                    <ui-list-item>
                        Integration between online and offline Film Literacy actions: the increased digitization of film both online and offline and importance of social media as the new site of public debate, have created a divide between the online and the offline world. This might be considered unimportant regarding access to film but concerning film education itself one must consider thechallenges that are presented: how do we integrate new online possibilities with our established “analogue” approaches to teaching film literacy? What are the benefits and challenges of offline and online approaches? What online activities can compliment offline provision and vice versa?
                    </ui-list-item>
                    <ui-list-item>
                        Crossmedia educational and promotional platforms in the digital film market: film education should not only be seen as a way to increase people’s ability to understand moving images. Film education is ,in addition, a way in which cinema gets in touch with its audiences, raises questions in the audiences’ minds – particularly with young audiences - on what the film is about and on how people see something that attracts them in a film. In this way film education is the missing link between the audience and the film itself, making it readable and understandable in its complexityas an artistic object. So how can the film industry take advantage of the link that film education creates with the audience to promote their products? What can be the advantages for the audience in using film education as a promotional resource? How can film education help distributors in building an online promotion strategy?
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title
                title="Speakers"
                font-size="h1"
                class="pb-4"/>
            <ui-team
                v-for="(speaker, i, key) in this.speakers"
                :key="speaker.id"
                :name="speaker.name"
                :img="speaker.img">
                {{ speaker.description }}
            </ui-team>
        </ui-container>
    </ui-container>
</template>

<script>
import speakers from '../../dummies/conferenceSpeakers'
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiSpecialText, UiTeam, UiTitle } from '../../ui'

export default {
    name: 'ConferenceContact',
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiSpecialText,
        UiTeam,
        UiTitle,
    },
    data: function() {
        return {
            speakers: speakers,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
