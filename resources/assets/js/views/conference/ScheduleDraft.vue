<template>
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
            <ui-title
                :has-padding="false"
                title="2017, November, 9th" />
            <ui-special-text :has-padding="false" class="pb-4">
                Fondazione Cineteca Italiana HQ, viale Fulvio Testi, 121
            </ui-special-text>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="17:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Visit to MIC-Interactive Film Museum and the Virtual Archive
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="19:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Networking cocktail
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title
                :has-padding="false"
                title="2017, November, 10th" />
            <ui-special-text :has-padding="false" class="pb-4">
                Spazio Oberdan, Viale Vittorio Veneto, 2
            </ui-special-text>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="9:30 to 10:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Institutional greetings
                    <ui-list>
                        <ui-list-item>
                            Matteo Solaro (EACEA, European Commission)
                        </ui-list-item>
                        <ui-list-item>
                            Nicola Borrelli (MIBACT-Ministero per i Beni e le Attività Culturali ed il Turismo-Direzione Generale Cinema)
                        </ui-list-item>
                        <ui-list-item>
                            Giuseppe Pierro (MIUR-Ministero dell’Istruzione, Università e Ricerca)
                        </ui-list-item>
                        <ui-list-item>
                            Delia Campanelli (Ufficio Scolastico Regionale, Regione Lombardia)
                        </ui-list-item>
                        <ui-list-item>
                            Cristina Cappellini (Assessore alla Cultura, Regione Lombardia)
                        </ui-list-item>
                        <ui-list-item>
                            Filippo del Corno (Assessore alla Cultura, Comune di Milano)
                        </ui-list-item>
                        <ui-list-item>
                            Matteo Pavesi (Fondazione Cineteca Italiana)
                        </ui-list-item>
                    </ui-list>
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="10:00 to 11:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Launch of The Film Corner Platform
                    <ui-list>
                        <ui-list-item>
                            Silvia Pareti, Simone Moraldi (Fondazione Cineteca Italiana)
                        </ui-list-item>
                        <ui-list-item>
                            Ian Wall (The Film space)
                        </ui-list-item>
                        <ui-list-item>
                            Aleksandar Erdeljanovic, Branislav Erdeljanovic (Jugoslovenska Kinoteka)
                        </ui-list-item>
                        <ui-list-item>
                            Marty Melarkey (The Nerve Centre)
                        </ui-list-item>
                        <ui-list-item>
                            Emanuela Mancino (University of Milano-Bicocca)
                        </ui-list-item>
                    </ui-list>
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="11:00 to 11:30"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Keynote Speech
                    <ui-list>
                        <ui-list-item>
                            Maria Grazia Mattei (Meet the Media Guru)
                        </ui-list-item>
                    </ui-list>
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="11:30 to 13:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    PANEL: Film education and audience development in the digital era
                    <ui-list>
                        <ui-list-item>
                            Alessandra Guarino (Fondazione Centro Sperimentale di Cinematografia)
                        </ui-list-item>
                        <ui-list-item>
                            Claus Noer Hjorth (Danish Film Institute)
                        </ui-list-item>
                        <ui-list-item>
                            Christine Eloy (Europa Distribution)
                        </ui-list-item>
                        <ui-list-item>
                            Alessandro Bollo (Polo del ‘900, Fondazione San Paolo)
                        </ui-list-item>
                        <ui-list-item>
                            Elisa Giovannelli (ECFA/Cineteca di Bologna)
                        </ui-list-item>
                        <ui-list-item>
                            Alice Arecco (Milano Film Network)
                        </ui-list-item>
                        <ui-list-item>
                            Chairman: Simone Moraldi (Fondazione Cineteca Italiana)
                        </ui-list-item>
                    </ui-list>
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="13:00 to 13:30"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Q&A
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="13:30 to 14:30"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Lunch Break
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="14:30 to 16:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    PANEL: Film literacy methodologies and best practices in the digital era
                    <ui-list>
                        <ui-list-item>
                            Mark Reid (British Film Institute)
                        </ui-list-item>
                        <ui-list-item>
                            Nathalie Bourgeois (Cinémathèque Française)
                        </ui-list-item>
                        <ui-list-item>
                            Christine Kopf (Deutsche Filmmuseum)
                        </ui-list-item>
                        <ui-list-item>
                            Núria Aidelman (A bao a Qu)
                        </ui-list-item>
                        <ui-list-item>
                            Marty Melarkey (The Nerve Centre)
                        </ui-list-item>
                        <ui-list-item>
                            Camilla Paternò di Montecupo (Dugong Production)
                        </ui-list-item>
                        <ui-list-item>
                            Chairman: Ian Wall (The Film Space)
                        </ui-list-item>
                    </ui-list>
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="16:00 to 16:30"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Q&A
                </ui-block>
            </ui-row>
            <ui-row class="pb-2">
                <ui-block :size="3" align="start">
                    <ui-title
                        title="16:30 to 17:00"
                        font-size="h6"
                        :uppercase="false"
                        :has-padding="false"
                        :has-margin="false"/>
                </ui-block>
                <ui-block :size="9" align="start">
                    Closing Remarks
                </ui-block>
            </ui-row>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTeam, UiTitle } from '../../ui'
export default {
    name: 'ScheduleDraft',
    components: {
        UiBlock,
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTeam,
        UiTitle,
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
