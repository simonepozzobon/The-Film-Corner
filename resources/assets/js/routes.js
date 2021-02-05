import MainContainer from "./containers/MainContainer.vue";
import ConferenceContainer from "./views/conference/ConferenceContainer.vue";
import AppsContainer from "./views/apps/AppsContainer.vue";
import NetworkContainer from "./views/network/NetworkContainer.vue";

// Public
import Home from "./views/home/Home.vue";
import HomePanel from "./views/home/HomePanel.vue";
import LoginPanel from "./views/home/LoginPanel.vue";
import About from "./views/About.vue";
import Schools from "./views/Schools.vue";
import Filmography from "./views/Filmography.vue";
import News from "./views/News.vue";
import Cookies from "./views/Cookies.vue";
import Privacy from "./views/Privacy.vue";

// Conference
import ConferenceHome from "./views/conference/ConferenceHome.vue";
import ConferenceAbout from "./views/conference/ConferenceAbout.vue";
import ScheduleDraft from "./views/conference/ScheduleDraft.vue";
import Accomodation from "./views/conference/Accomodation.vue";
import Downloads from "./views/conference/Downloads.vue";
import Contact from "./views/conference/Contact.vue";

// Applicazioni
import AppsHome from "./views/apps/AppsHome.vue";
import StudioSingle from "./views/apps/StudioSingle.vue";
import CatSingle from "./views/apps/CatSingle.vue";
import AppSingle from "./views/apps/AppSingle.vue";

// Applicazioni Singole
import FrameComposer from "./views/apps/FrameComposer.vue";
import FrameCrop from "./views/apps/FrameCrop.vue";
import TypesOfImages from "./views/apps/TypesOfImages.vue";
import ParallelAction from "./views/apps/ParallelAction.vue";
import Offscreen from "./views/apps/Offscreen.vue";
import WhatsGoingOn from "./views/apps/WhatsGoingOn.vue";
import Soundscapes from "./views/apps/Soundscapes.vue";
import ActiveOffscreen from "./views/apps/ActiveOffscreen.vue";
import ActiveParallelAction from "./views/apps/ActiveParallelAction.vue";
import SoundStudio from "./views/apps/SoundStudio.vue";
import CharacterBuilder from "./views/apps/CharacterBuilder.vue";
import LumiereMinute from "./views/apps/LumiereMinute.vue";
import MakeYourOwnFilm from "./views/apps/MakeYourOwnFilm.vue";
import Storytelling from "./views/apps/Storytelling.vue";

// Propagandapp
import PropagandaContainer from "./views/apps/propagandapp/PropagandaContainer.vue";
import PropagandaExercise from "./views/apps/propagandapp/PropagandaExercise.vue";
import PropagandaIntro from "./views/apps/propagandapp/PropagandaIntro.vue";
import PropagandaHome from "./views/apps/propagandapp/PropagandaHome.vue";
import PropagandaSearch from "./views/apps/propagandapp/PropagandaSearch.vue";
import PropagandaSingle from "./views/apps/propagandapp/PropagandaSingle.vue";

import PropagandaCheckSound from "./views/apps/propagandapp/exercises/PropagandaCheckSound.vue";
import PropagandaCompareClips from "./views/apps/propagandapp/exercises/PropagandaCompareClips.vue";
import PropagandaFrameCrop from "./views/apps/propagandapp/exercises/PropagandaFrameCrop.vue";

import ChallengesAffiches from "./views/apps/propagandapp/challenges/ChallengesAffiches.vue";
import ChallengesFilm from "./views/apps/propagandapp/challenges/ChallengesFilm.vue";
import ChallengesFilmApp from "./views/apps/propagandapp/challenges/ChallengesFilmApp.vue";
import ChallengesHome from "./views/apps/propagandapp/challenges/ChallengesHome.vue";
import ChallengesInterviews from "./views/apps/propagandapp/challenges/ChallengesInterviews.vue";
import ChallengesInterviewsDb from "./views/apps/propagandapp/challenges/ChallengesInterviewsDb.vue";
import ChallengesRolePlaying from "./views/apps/propagandapp/challenges/ChallengesRolePlaying.vue";

// Network
import NetworkHome from "./views/network/NetworkHome.vue";
import NetworkSingle from "./views/network/NetworkSingle.vue";

// Profile
import ProfileContainer from "./views/profile/ProfileContainer.vue";
import ProfileTeacher from "./views/profile/ProfileTeacher.vue";

const routes = [
    {
        path: "/",
        component: MainContainer,
        children: [
            {
                path: "",
                component: Home,
                children: [
                    {
                        path: "",
                        name: "home",
                        component: HomePanel
                    },
                    {
                        path: "login",
                        name: "login",
                        component: LoginPanel
                    }
                ]
            },
            {
                path: "the-project",
                name: "project",
                component: About
            },
            {
                path: "schools",
                name: "schools",
                component: Schools
            },
            {
                path: "filmography",
                name: "filmography",
                component: Filmography
            },
            {
                path: "cookies",
                name: "cookies",
                component: Cookies
            },
            {
                path: "privacy",
                name: "privacy",
                component: Privacy
            },
            {
                path: "conference",
                component: ConferenceContainer,
                children: [
                    {
                        path: "",
                        name: "conference",
                        component: ConferenceHome
                    },
                    {
                        path: "about",
                        name: "conf-about",
                        component: ConferenceAbout
                    },
                    {
                        path: "schedule-draft",
                        name: "conf-schedule-draft",
                        component: ScheduleDraft
                    },
                    {
                        path: "accomodation",
                        name: "conf-accomodation",
                        component: Accomodation
                    },
                    {
                        path: "downloads",
                        name: "conf-downloads",
                        component: Downloads
                    },
                    {
                        path: "contact",
                        name: "conf-contact",
                        component: Contact
                    }
                ]
            },
            {
                path: "apps",
                component: AppsContainer,
                children: [
                    {
                        path: "",
                        name: "apps-home",
                        component: AppsHome,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "studio/:pavilion",
                        name: "pavilion-home",
                        component: StudioSingle,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "path/:cat",
                        name: "cat-home",
                        component: CatSingle,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "dashboard/:app",
                        name: "app-home",
                        component: AppSingle,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "frame-composer",
                        name: "frame-composer",
                        component: FrameComposer,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "frame-crop",
                        name: "frame-crop",
                        component: FrameCrop,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "types-of-images",
                        name: "types-of-images",
                        component: TypesOfImages,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "parallel-action",
                        name: "parallel-action",
                        component: ParallelAction,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "offscreen",
                        name: "offscreen",
                        component: Offscreen,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "whats-going-on",
                        name: "whats-going-on",
                        component: WhatsGoingOn,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "soundscapes",
                        name: "soundscapes",
                        component: Soundscapes,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "active-offscreen",
                        name: "active-offscreen",
                        component: ActiveOffscreen,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "active-parallel-action",
                        name: "active-parallel-action",
                        component: ActiveParallelAction,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "sound-studio",
                        name: "sound-studio",
                        component: SoundStudio,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "character-builder",
                        name: "character-builder",
                        component: CharacterBuilder,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "lumiere-minute",
                        name: "lumiere-minute",
                        component: LumiereMinute,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "make-your-own-film",
                        name: "make-your-own-film",
                        component: MakeYourOwnFilm,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "storytelling",
                        name: "storytelling",
                        component: Storytelling,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "propagandapp",
                        component: PropagandaContainer,
                        children: [
                            {
                                path: "",
                                name: "propaganda-intro",
                                component: PropagandaIntro,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "intro",
                                name: "propaganda-home",
                                component: PropagandaHome,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "search",
                                name: "propaganda-search",
                                component: PropagandaSearch,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "single/:id",
                                name: "propaganda-single",
                                component: PropagandaSingle,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "single/:id/exercise-:exerciseId",
                                component: PropagandaContainer,
                                children: [
                                    {
                                        path: "",
                                        name: "propaganda-exercise",
                                        component: PropagandaExercise,
                                        meta: { requiresAuth: true }
                                    },
                                    {
                                        path: "compare-clips",
                                        name: "propaganda-compare-clips",
                                        component: PropagandaCompareClips,
                                        meta: { requiresAuth: true }
                                    },
                                    {
                                        path: "frame-crop",
                                        name: "propaganda-frame-crop",
                                        component: PropagandaFrameCrop,
                                        meta: { requiresAuth: true }
                                    },
                                    {
                                        path: "check-sound",
                                        name: "propaganda-check-sound",
                                        component: PropagandaCheckSound,
                                        meta: { requiresAuth: true }
                                    }
                                ]
                            },
                            {
                                path: "challenges",
                                name: "propaganda-challenges",
                                component: ChallengesHome,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/propaganda-film",
                                name: "propaganda-film",
                                component: ChallengesFilm,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/propaganda-film/app",
                                name: "propaganda-film-app",
                                component: ChallengesFilmApp,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/role-playing",
                                name: "propaganda-role-playing",
                                component: ChallengesRolePlaying,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/your-interview",
                                name: "propaganda-interview",
                                component: ChallengesInterviews,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/your-interview-db",
                                name: "propaganda-interviews-db",
                                component: ChallengesInterviewsDb,
                                meta: { requiresAuth: true }
                            },
                            {
                                path: "challenges/your-affiches",
                                name: "propaganda-your-affiches",
                                component: ChallengesAffiches,
                                meta: { requiresAuth: true }
                            }
                        ]
                    }
                ]
            },
            {
                path: "network",
                component: NetworkContainer,
                children: [
                    {
                        path: "",
                        name: "network-home",
                        component: NetworkHome,
                        meta: { requiresAuth: true }
                    },
                    {
                        path: "single/:id",
                        name: "network-single",
                        component: NetworkSingle,
                        meta: { requiresAuth: true }
                    }
                ]
            },
            {
                path: "profile",
                component: ProfileContainer,
                children: [
                    {
                        path: "",
                        name: "teacher-profile",
                        component: ProfileTeacher,
                        meta: { requiresAuth: true }
                    }
                ]
            },
            {
                path: "news/:slug",
                name: "news-single",
                component: News
            }
        ]
    }
];

export default routes;
