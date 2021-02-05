<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Privacy Policy"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                <ui-title title="Privacy policy" />
                Read the following carefully to learn more about our privacy
                policy. Pursuant to Article 13 of the GDPR - General Data
                Protection Regulation (EU / 2016/679).
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="1. Nature of the data" :uppercase="false" />
                This information concerns the processing of personal data,
                meaning personal data those c.d. common and / or identifying
                (such as: personal data, tax code, residence or domicile,
                telephone number, e-mail, fax, etc.).
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="2. Cookies" :uppercase="false" />
                For the discussion of this topic, refer to the
                <a href="/cookies">"Cookie Policy"</a> section.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="3. Source of Personal Data"
                    :uppercase="false"
                />
                Personal data are those provided by the Interested person
                through the www.thefilmcorner.eu website of Fondazione Cineteca
                Italiana.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="4. Obligation / optional nature of the provision of data"
                    :uppercase="false"
                />
                The provision of personal data by the interested party is
                necessary for the activity of The Film Corner project and
                service. The provision of data is optional but necessary to
                activate the aforementioned service.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="5. Purpose of the treatment"
                    :uppercase="false"
                />
                a) The processing of all the data acquired is aimed at providing
                the interested party with the services offered by The Film
                Corner platform.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="6. Methods of processing" :uppercase="false" />
                The personal data of the interested party are processed for the
                time strictly necessary to achieve the purposes for which they
                were collected. Specific security measures are observed to
                prevent data loss, illicit or incorrect use and unauthorized
                access.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="7. Rights of the interested party"
                    :uppercase="false"
                />
                The subjects to whom the personal data refer are entitled at any
                time to obtain confirmation of the existence or otherwise of the
                same data and to know its content and origin, verify its
                accuracy or request its updating. Pursuant to art. 13 GDPR -
                General Regulation on Data Protection, you have the right to
                request cancellation, transformation into anonymous form or
                blocking of data processed in violation of the law, and to
                oppose in any case, for legitimate reasons, to their treatment.
                In order to exercise these rights, the interested party may
                submit a request by writing to Fondazione Cineteca Italiana with
                registered office in Milan (20162), Viale Fulvio Testi, 121 or
                an e-mail to the following address info@cinetecamilano.it.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="8. Holder of data processing"
                    :uppercase="false"
                />
                The data controller is: Fondazione Cineteca Italiana, with
                headquarters in Milan, Viale Fulvio Testi 121.
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>
<script>
import {
    UiContainer,
    UiHeroBanner,
    UiList,
    UiListItem,
    UiParagraph,
    UiTitle
} from "../ui";
export default {
    name: "Privacy",
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiTitle
    }
};
</script>
<style lang="scss"></style>
