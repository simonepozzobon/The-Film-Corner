<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Cookies"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                <ui-title title="Cookie policy" />
                Read the following carefully to learn more about our cookies
                policy.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="1. What are cookies" :uppercase="false" />
                A cookie is a small text file stored in a user's web browser on
                any device that contains information regarding the user's visit,
                such as preferences. When the user returns, the browser provides
                the cookie with the information stored by the site.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="2. For what cookies are used"
                    :uppercase="false"
                />
                Cookies are used to adjust the content of a website to satisfy
                the preferences of a user and optimize the website itself. They
                store useful information that improves the user experience of a
                website. They are commonly used for:
                <ui-list>
                    <ui-list-item>
                        Storing login information so that a user does not need
                        to re-log in on each visit.
                    </ui-list-item>
                    <ui-list-item>
                        Recognize the type of device of a user connected to a
                        site to optimize it for the device itself.
                    </ui-list-item>
                    <ui-list-item>
                        Creating statistics that help website owners understand
                        how their users interact with their website, and enable
                        them to improve their structure and content.
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
            <ui-paragraph>
                <ui-title
                    title="3. Cookies on www.cinetecamilano.it"
                    :uppercase="false"
                />
                Below you will find all the information on cookies installed
                through the website www.thefilmcorner.eu of Fondazione Cineteca
                Italiana (hereinafter "Site"), and the necessary instructions on
                how to manage your preferences regarding them.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="4. Technical Cookies" :uppercase="false" />
                Fondazione Cineteca Italiana uses, through its website,
                exclusively technical cookies. Technical cookies are used to
                browse or provide a service requested by the user. They are not
                used for other purposes and are normally installed by the
                website owner. Without the use of these cookies, some operations
                could not be completed or would be more complex and / or less
                secure. They can be divided into navigation cookies, which
                guarantee the normal navigation and use of the website;
                analytics cookies, similar to technical cookies when used
                directly by the site operator to collect information, in
                aggregate form, on the number of users and how they visit the
                site; Functionality cookies, which allow the user to navigate
                according to a series of selected criteria (eg, the language) in
                order to improve the service itself. All technical cookies do
                not require consent, so they are installed automatically as a
                result of access to the site.
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="5. Profiling Cookies" :uppercase="false" />
                Fondazione Cineteca Italiana DOES NOT use the profiling cookies
                through the Website. These cookies are used to track user
                browsing on the web and create profiles on their tastes, habits,
                choices, etc. in order to transmit advertising messages to its
                terminal in line with the preferences already shown during
                navigation. Remember that you can manage your cookie preferences
                even through the browser. If you do not know the type and
                version of browser you are using, click on "Help" in the browser
                window at the top, from which you can access all the necessary
                information.
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
    name: "Cookies",
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
