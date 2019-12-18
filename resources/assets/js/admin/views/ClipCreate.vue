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
            @update="updateField"
            :initials="initials"
        />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <traduzioni-clip :initials="initials" />
    </container>

    <container
        :contains="true"
        :has-animations="true"
    >
        <informazioni
            :options="options"
            @update="updateField"
            :initials="initials"
        />
    </container>
    <container
        v-if="cursor >= 1"
        :contains="true"
        :has-animations="true"
    >
        <approfondimenti
            @update="updateField"
            :initials="initials"
        />
    </container>
    <container
        v-if="cursor >= 2"
        :contains="true"
        :has-animations="true"
    >
        <paratexts
            :clip="this.clip"
            :options="options"
            @update="updateField"
            @completed="paratextCompleted"
            @uncomplete="paratextUncomplete"
            :initials="initials"
        />
    </container>
    <container
        v-if="cursor >= 3"
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
        v-if="cursor >= 3"
        v-for="exercise in exercises"
        :key="exercise.uuid"
        :exercise="exercise"
        :clip="clip"
        :initials="initials"
        @update="updateExerc"
        @destroy="destroyMedia"
    />
    <container
        padding="sm"
        :contains="true"
        :has-animations="true"
    >
        <div class="a-clip-panel__topbar">
            <ui-button
                title="Salva Clip"
                color="green"
                :has-container="false"
                :has-margin="false"
                @click="saveClip"
            />
            <ui-button
                title="Annulla"
                color="red"
                :has-container="false"
                :has-margin="false"
            />
        </div>
    </container>
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

import EserciziMethods from './mixins/EserciziMethods'

import Step from '../components/clips/Step.vue'
import Approfondimenti from '../components/clips/Approfondimenti.vue'
import CaricaClip from '../components/clips/CaricaClip.vue'
import Informazioni from '../components/clips/Informazioni.vue'
import Paratexts from '../components/clips/Paratexts.vue'
import Esercizi from '../components/clips/Esercizi.vue'
import LibrerieEsercizi from '../components/clips/LibrerieEsercizi.vue'
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
        Step,
        Topbar,
        TraduzioniClip,
        UiButton,
        UiTitle,
    },
    mixins: [EserciziMethods],
    data: function () {
        return {
            sticky: false,
            panelTitle: 'Nuova Clip',
            clip: null,
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
        }
    },
    watch: {
        cursor: function (cursor) {
            // console.log('cambio cursore', cursor);
        },
        // exercises: function (exercises) {
        //     console.log('esercizi', exercises);
        // }
    },
    methods: {
        getData: function (id = null) {
            let url = '/api/v2/admin/clips/get-initials'

            // open existing clip
            if (id != null) {
                url = '/api/v2/admin/clips/get-initials/' + id

                this.panelTitle = 'Modifica Clip'
            }

            this.$http.get(url).then(response => {
                if (response.data.success) {
                    // set initials values
                    if (response.data.hasOwnProperty('initial')) {
                        this.cursor = 3

                        let initial = response.data.initial
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

                                    // se si tratta di un'array cerca di individuare delle corrispondenze
                                    if (deepInitial.length >= 0) {
                                        for (let i = 0; i < deepInitial.length; i++) {
                                            let current = deepInitial[i]
                                            for (let currentKey in current) {
                                                if (current.hasOwnProperty(currentKey)) {
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
                                            if (current.hasOwnProperty(currentKey)) {
                                                let idx = this.keys.findIndex(value => value == currentKey)
                                                if (idx > -1) {
                                                    this.initials[currentKey] = current[currentKey]
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
            }
        },
        debug: function () {

        },
        saveClip: function () {
            // this.debug()
            if (this.cursor == 0) {
                let data = new FormData()
                data.append('title', this.title)
                data.append('video', this.video)
                data.append('period', this.period)
                data.append('year', this.year)
                data.append('format', this.format)
                data.append('age', this.age)
                data.append('genre', this.genre)
                data.append('nationality', this.nationality)

                data.append('topics', JSON.stringify(this.topics))
                data.append('directors', JSON.stringify(this.directors))
                data.append('peoples', JSON.stringify(this.peoples))


                this.$http.post('/api/v2/admin/clips/create', data).then(response => {
                    console.log('clip', response.data.clip);
                    if (response.data.success == true) {
                        this.clip = response.data.clip
                        this.cursor = 1
                    }
                })
            }
            else if (this.cursor == 1) {
                let data = new FormData()
                data.append('clip_id', this.clip.id)
                data.append('abstract', this.abstract)
                data.append('tech_info', this.tech_info)
                data.append('historical_context', this.historical_context)
                data.append('food', this.foods)

                this.$http.post('/api/v2/admin/clips/create-detail', data).then(response => {
                    console.log('details', response.data.clip);
                    if (response.data.success == true) {
                        this.clip = response.data.clip
                        this.cursor = 2
                    }
                })
            }
            else if (this.cursor == 2) {
                // paratesti
            }
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
