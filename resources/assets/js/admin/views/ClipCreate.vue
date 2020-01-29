<template>
<div
    class="a-clip-panel"
    sticky-container
>
    <topbar
        :cursor="cursor"
        :title="panelTitle"
    />
    <container
        :contains="true"
        :has-animations="true"
    >
        <carica-clip
            :initials="altInitials"
            @update="updateField"
            @saved="updateClip($event, 1)"
        />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <sottotitoli :clip="clip" />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <traduzioni-clip
            :initials="altInitials"
            :title="title"
            :clip="clip"
            @saved="updateClip($event, 2)"
        />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <informazioni
            :options="options"
            :clip="clip"
            :initials="initials"
            @update="updateField"
            @saved="updateClip($event, 3)"
        />
    </container>
    <container
        :contains="true"
        :has-animations="true"
    >
        <approfondimenti
            :clip="clip"
            :initials="initials"
            @update="updateField"
            @saved="updateClip($event, 4)"
        />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <traduzioni-approfondimenti
            :clip="clip"
            :initials="initials"
            :current="current"
            @update="updateField"
            @saved="updateClip($event, 5)"
        />
    </container>
    <container
        :contains="true"
        :has-animations="true"
    >
        <paratexts
            :clip="this.clip"
            :options="options"
            :initials="initials"
            @update="updateField"
            @completed="paratextCompleted"
            @uncomplete="paratextUncomplete"
            @translate="translate"
        />
    </container>
    <container
        :contains="true"
        :has-animations="true"
    >
        <block-panel
            ref="eserciziPanel"
            title="Esercizi"
            :has-animations="true"
        >
            <esercizi
                ref="selector"
                :clip.sync="this.clip"
                :options="options.exercises"
                :exercises.sync="exercises"
                :initials="initials"
            />
        </block-panel>
    </container>
    <librerie-esercizi
        v-for="exercise in exercises"
        :key="exercise.uuid"
        :exercise="exercise"
        :clip="clip"
        :initials="altInitials"
        @update="updateExerc"
        @destroy="destroyMedia"
    />
    <traduzioni-paratext
        ref="translate"
        :clip="clip"
        @saved="updateClip"
    />
</div>
</template>

<script>
import {
    Container,
    BlockPanel,
}
from '../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../ui'

import TraduzioniParatext from '../components/clips/paratesti/TraduzioniParatext.vue'

import EserciziMethods from './mixins/EserciziMethods'

import Approfondimenti from '../components/clips/Approfondimenti.vue'
import CaricaClip from '../components/clips/CaricaClip.vue'
import Esercizi from '../components/clips/Esercizi.vue'
import Informazioni from '../components/clips/Informazioni.vue'
import LibrerieEsercizi from '../components/clips/LibrerieEsercizi.vue'
import Paratexts from '../components/clips/Paratexts.vue'
import Sottotitoli from '../components/clips/Sottotitoli.vue'
import Step from '../components/clips/Step.vue'
import TraduzioniApprofondimenti from '../components/clips/TraduzioniApprofondimenti.vue'
import TraduzioniClip from '../components/clips/TraduzioniClip.vue'
import Topbar from './propaganda/Topbar.vue'

export default {
    name: 'ClipCreate',
    components: {
        Approfondimenti,
        BlockPanel,
        CaricaClip,
        Container,
        Esercizi,
        Informazioni,
        LibrerieEsercizi,
        Paratexts,
        Sottotitoli,
        Step,
        Topbar,
        TraduzioniApprofondimenti,
        TraduzioniClip,
        UiButton,
        UiTitle,
        TraduzioniParatext,
    },
    mixins: [EserciziMethods],
    data: function () {
        return {
            step: 0,
            clip: null,
            sticky: false,
            panelTitle: 'Nuova Clip',
            title: null,
            video: null,
            period: null,
            directors: [],
            peoples: [],
            year: null,
            format: null,
            age: null,
            genre: null,
            nationality: null,
            topics: [],
            cursor: 0,
            abstract: null,
            tech_info: null,
            historical_context: null,
            foods: null,
            exercises: [],
            options: {
                periods: [],
                directors: [],
                genres: [],
                formats: [],
                ages: [],
                topics: [],
                peoples: [],
                hashtags: [],
                paratext_types: [],
                exercises: [],
            },
            keys: [
                'id',
                'clip',
                'title',
                'video',
                'period',
                'directors',
                'peoples',
                'year',
                'format',
                'age',
                'genre',
                'nationality',
                'topics',
                'cursor',
                'abstract',
                'tech_info',
                'historical_context',
                'foods',
                'exercises',
                'exercise_1',
                'exercise_2',
                'exercise_3',
            ],
            initials: {},
            altInitials: {},
            current: {},
        }
    },
    watch: {
        cursor: function (cursor) {
            // console.log('cambio cursore', cursor);
        },
        exercises: function (exercises) {
            this.$nextTick(() => {
                this.findLibrary(exercises)
            })
        }
    },
    methods: {
        translate: function (item) {
            this.$refs.translate.show(item)
        },
        updateClip: function (clip, step) {
            this.clip = clip
            this.step = step
            // console.log('set', clip);
        },
        getData: function (id = null) {
            let url = '/api/v2/admin/clips/get-initials'

            // open existing clip
            if (id != null) {
                url = '/api/v2/admin/clips/get-initials/' + id

                this.panelTitle = 'Modifica Clip'
            }
            // console.log('url', url);

            this.$http.get(url).then(response => {
                // console.log('setting', response);
                if (response.data.success) {
                    // set initials values
                    if (response.data.hasOwnProperty('initial')) {
                        this.cursor = 3

                        let initial = response.data.initial
                        let cache = Object.assign({}, this.initials)
                        this.altInitials = Object.assign({}, initial)
                        this.clip = initial
                        // console.log('initials', initial);
                        for (let key in initial) {
                            if (initial.hasOwnProperty(key)) {

                                // se il valore corrisponde ad uno di quelli richiesti lo aggiunge all'oggetto
                                let idx = this.keys.findIndex(value => value == key)
                                if (idx > -1) {
                                    this.initials[key] = initial[key]
                                }
                                // se si tratta di un oggetto o di un'array cerca a fondo
                                else if (typeof initial[key] == 'object') {
                                    let deepInitial = initial[key]

                                    if (deepInitial) {
                                        // se si tratta di un'array cerca di individuare delle corrispondenze
                                        if (deepInitial.length >= 0) {
                                            for (let i = 0; i < deepInitial.length; i++) {
                                                let current = deepInitial[i]
                                                for (let currentKey in current) {

                                                    if (current.hasOwnProperty(currentKey) && currentKey != 'id') {
                                                        let idx = this.keys.findIndex(value => value == currentKey)
                                                        if (idx > -1) {
                                                            this.initials[currentKey] = current[currentKey]
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        // si tratta di un singolo oggetto
                                        else {
                                            // console.log(deepInitial);
                                            let current = deepInitial
                                            for (let currentKey in current) {
                                                if (current.hasOwnProperty(currentKey) && currentKey != 'id') {
                                                    let idx = this.keys.findIndex(value => value == currentKey)
                                                    if (idx > -1) {
                                                        this.initials[currentKey] = current[currentKey]
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                // lo scarta
                                else {

                                }
                            }
                        }
                        this.initials = Object.assign({}, this.initials)

                        // if (this.clip.exercise_1 == 1) {
                        //     this.findLibrary(1)
                        // }
                        // if (this.clip.exercise_2 == 1) {
                        //     this.findLibrary(2)
                        // }
                        // if (this.clip.exercise_3 == 1) {
                        //     this.findLibrary(2)
                        // }
                    }


                    for (let key in this.options) {
                        if (this.options.hasOwnProperty(key) && response.data.hasOwnProperty(key)) {
                            this.options[key] = response.data[key]
                        }
                    }
                    this.period = this.options.periods[0].id
                }
            })
        },
        updateField: function (key, value) {
            if (this.hasOwnProperty(key)) {
                this[key] = value

                let current = Object.assign({}, this.current)
                current[key] = value

                this.current = current
            }
        },
        debug: function () {

        },
        saveClip: function () {
            console.log('deprecata');
        },
        paratextCompleted: function () {
            this.cursor = 3
        },
        paratextUncomplete: function () {
            this.cursor = 2
        },
        initSticky: function () {
            this.sticky = stickybits('#topbar', {
                stickyBitStickyOffset: 96,
            })

            window.addEventListener('resize', () => {
                this.sticky.update();
            });
            // when the url hash changes
            window.addEventListener('hashchange', () => {
                this.sticky.update();
            });
        },
        onStick: function (data) {
            console.log(data);
        },
        findLibrary: function (exercises) {
            let cached = Object.assign([], exercises)
            for (let i = 0; i < exercises.length; i++) {
                let exercise = exercises[i]
                let libraries = this.altInitials.libraries.filter(library => library.exercise_id == exercise.id)

                if (libraries) {
                    this.exercises[i].libraries = libraries
                }
            }

            // let libraries = this.clip.libraries.filter(library => library.exercise_id == exerciseId)

        }
    },
    filters: {
        stateSetter: function (value, cursor) {
            if (cursor > value) {
                return false
            }
            else {
                // console.log(value, cursor);
                return true
            }
        },
    },
    created: function () {
        if (this.$route.params && this.$route.params.hasOwnProperty('id')) {
            this.getData(this.$route.params.id)
        }
        else {
            this.getData()
        }
    },
    mounted: function () {
        // this.initSticky()

    },
}
</script>

<style lang="scss">
@import '~styles/shared';

label {
    font-size: $font-size-sm;
}

#topbar {
    z-index: 10;
}

.topbar {
    $color: $gray-100;
    &__title {
        // @include title-text-shadow(12px, 1px, 1px, 2px, 0.33, false);
        padding-left: $spacer * 2;
        color: darken($color, 50);
        letter-spacing: 12px;
    }
    &__steps {
        display: flex;
    }
}

.a-clip-panel {
    position: relative;
    width: 100%;

    &__topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__divider {
        margin-top: $spacer / 1.618;
        margin-bottom: $spacer * 1.618;
    }

    &__group {
        // margin-bottom: $spacer * 2 * 1.618;
    }
    &__row {
        align-items: center;
    }

    &__select {
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__per-page {
        margin-left: auto;
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__search {
        max-width: 200px;
    }
}

.clips-table {
    &__preview {
        width: $spacer * 3;
    }
}
</style>
