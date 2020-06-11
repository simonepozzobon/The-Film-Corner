<template>
    <nav
        class="app-nav navbar navbar-dark navbar-expand-lg fixed-top"
        ref="menu"
    >
        <ul class="navbar-nav app-nav__nav">
            <li class="app-nav__item nav-item">
                <a
                    href="#"
                    @click="$router.go(-1)"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("close") }}
                </a>
            </li>
            <li class="app-nav__item nav-item" v-if="isTeacherCheck">
                <a
                    href="#"
                    @click.stop.prevent="approveAndShare"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("approve_and_share") }}
                </a>
            </li>
            <li class="app-nav__item nav-item" v-else>
                <a
                    href="#"
                    @click.stop.prevent="addTitle"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("save_session") }}
                </a>
            </li>
            <li class="app-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="openSession"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("open_existing_session") }}
                </a>
            </li>
            <li class="app-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="resetSession"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("reset_session") }}
                </a>
            </li>
            <li class="app-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="printPage"
                    class="nav-link app-nav__link"
                >
                    {{ this.$root.getCmd("print") }}
                </a>
            </li>
        </ul>
        <b-modal ref="saveSession" :title="$root.getCmd('save_your_session')">
            <div class="form-group">
                <label for="title">{{ this.$root.getCmd("title") }}</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    v-model="title"
                />
            </div>
            <template slot="modal-footer">
                <ui-button
                    color="secondary"
                    :title="$root.getCmd('cancel')"
                    :has-margin="false"
                    @click="undoTitle"
                />
                <ui-button
                    color="primary"
                    :title="$root.getCmd('save')"
                    :has-margin="false"
                    @click="saveSession"
                />
            </template>
        </b-modal>
        <b-modal ref="reset" :title="$root.getCmd('reset_session')">
            <div>
                <p class="text-center">
                    {{ this.$root.getCmd("are_you_sure") }}
                </p>
            </div>
            <template slot="modal-footer">
                <ui-button
                    color="secondary"
                    :title="$root.getCmd('cancel')"
                    :has-margin="false"
                    @click="undoReset"
                />
                <ui-button
                    color="danger"
                    :title="$root.getCmd('reset')"
                    :has-margin="false"
                    @click="doReset"
                />
            </template>
        </b-modal>
        <b-modal ref="open" :title="$root.getCmd('leave_this_section')">
            <div>
                <p class="text-center">
                    {{ this.$root.getCmd("are_you_sure") }}
                </p>
            </div>
            <template slot="modal-footer">
                <ui-button
                    color="secondary"
                    :title="$root.getCmd('cancel')"
                    :has-margin="false"
                    @click="undoOpen"
                />
                <ui-button
                    color="danger"
                    :title="$root.getCmd('leave')"
                    :has-margin="false"
                    @click="doOpen"
                />
            </template>
        </b-modal>
    </nav>
</template>

<script>
import { UiButton } from "../ui";

import { gsap } from "gsap";

export default {
    name: "AppNav",
    components: {
        UiButton
    },
    data: function() {
        return {
            title: null
        };
    },
    computed: {
        isTeacherCheck: function() {
            if (this.$root.isTeacherCheck) {
                return true;
            }
            return false;
        }
    },
    methods: {
        goTo: function(event, name) {
            event.preventDefault();
            this.$router.push({
                name: name
            });
        },
        show: function() {
            let master = gsap.fromTo(
                this.$refs.menu,
                {
                    y: -150,
                    autoAlpha: 0
                },
                {
                    duration: 0.5,
                    y: 0,
                    autoAlpha: 1,
                    onComplete: () => {
                        master.kill();
                    }
                }
            );
        },
        hide: function() {
            let master = gsap.fromTo(
                this.$refs.menu,
                {
                    y: 0,
                    autoAlpha: 1
                },
                {
                    duration: 0.5,
                    y: -150,
                    autoAlpha: 0,
                    onComplete: () => {
                        master.kill();
                    }
                }
            );
        },
        undoTitle: function() {
            this.$refs.saveSession.hide();
        },
        addTitle: function() {
            this.$root.$emit("app-save-session");
            if (this.title == null && this.$root.session.title != "empty") {
                this.title = this.$root.session.title;
            }
            this.$refs.saveSession.show();
        },
        saveSession: function() {
            let session = this.$root.session;

            if (this.title) {
                session.title = this.title;
            }
            this.$root.fullMessage = this.$root.getCmd("saved");

            this.$http.post("/api/v2/session", session).then(response => {
                if (response.data.success) {
                    this.$root.fullMessage = this.$root.getCmd("saved");
                    this.undoTitle();
                    this.$root.showMessage();
                }
            });
        },
        undoReset: function() {
            this.$refs.reset.hide();
        },
        doReset: function() {
            this.$root.goTo(this.$root.session.app.slug, true);
        },
        resetSession: function() {
            this.$refs.reset.show();
        },
        undoOpen: function() {
            this.$refs.open.hide();
        },
        doOpen: function() {
            this.$root.goToWithParams("app-home", {
                app: this.$root.session.app.slug
            });
        },
        openSession: function() {
            this.$refs.open.show();
        },
        printPage: function() {
            window.print();
        },
        approveAndShare: function() {
            let session = this.$root.session;

            if (this.title) {
                session.title = this.title;
            }

            session.notification_id = this.$root.notificationId;

            this.$root.fullMessage = this.$root.getCmd("approved_and_shared");

            this.$http
                .post("/api/v2/session/share-to-network", session)
                .then(response => {
                    this.$root.showMessage().then(() => {
                        this.$root.goTo("apps-home");
                    });
                });
        }
    },
    mounted: function() {
        this.show();
    },
    beforeDestroy: function() {
        this.hide();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

.app-nav {
    top: 107px;
    height: 48px;
    z-index: $zindex-fixed - 2;
    background-color: $dark-gray;
    justify-content: center;

    &__nav {
        max-width: map-get($container-max-widths, xl);
        width: 100%;
        justify-content: space-around;
    }

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-bold;
        color: $white !important;
    }
}
</style>
