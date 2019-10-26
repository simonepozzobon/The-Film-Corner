<template>
<div class="a-clip-panel">
    <container padding="sm">
        <div class="a-clip-panel__topbar topbar">
            <div class="topbar__title">
                <ui-title title="Nuova Clip" />
            </div>
            <div class="topbar__steps">
                <step
                    :number="1"
                    :completed="this.cursor | completed(0)"
                />
                <step
                    :number="2"
                    :completed="this.cursor | completed(1)"
                />
                <step
                    :number="3"
                    :completed="this.cursor | completed(2)"
                />
                <step
                    :number="4"
                    :completed="this.cursor | completed(3)"
                />
            </div>
        </div>
    </container>
    <container>
        <div class="form">
            <carica-clip @update="updateField" />
        </div>
    </container>
    <container>
        <informazioni
            :options="options"
            @update="updateField"
        />
    </container>
    <container
        :has-animations="true"
        :state="this.cursor | stateSetter(1)"
    >
        <approfondimenti @update="updateField" />
    </container>
    <container
        :has-animations="true"
        :state="this.cursor | stateSetter(2)"
    >
        <paratexts
            :clip="this.clip"
            :options="options"
            @update="updateField"
        />
    </container>
    <container
        :has-animations="true"
        :state="this.cursor | stateSetter(3)"
    >
        <esercizi @update="updateField" />
    </container>
    <container padding="sm">
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
}
from '../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../ui'

import Step from '../components/clips/Step.vue'
import Approfondimenti from '../components/clips/Approfondimenti.vue'
import CaricaClip from '../components/clips/CaricaClip.vue'
import Informazioni from '../components/clips/Informazioni.vue'
import Paratexts from '../components/clips/Paratexts.vue'
import Esercizi from '../components/clips/Esercizi.vue'

export default {
    name: 'ClipCreate',
    components: {
        Container,
        UiButton,
        UiTitle,
        Approfondimenti,
        CaricaClip,
        Informazioni,
        Paratexts,
        Esercizi,
        Step,
    },
    data: function () {
        return {
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
            cursor: 2,
            abstract: null,
            tech_info: null,
            historical_context: null,
            food: null,
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
            },
        }
    },
    watch: {
        cursor: function (cursor) {
            console.log(cursor);
        },
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/admin/clips/get-initials').then(response => {
                for (let key in this.options) {
                    if (this.options.hasOwnProperty(key) && response.data.hasOwnProperty(key)) {
                        this.options[key] = response.data[key]
                    }
                }
                this.period = this.options.periods[0].id
            })
        },
        updateField: function (key, value) {
            if (this.hasOwnProperty(key)) {
                this[key] = value
            }
        },
        debug: function () {
            this.title = 'tiyueoiruioreuy'
            this.period = 'gianni'
            this.year = 'fkdjkgfdlj'
            this.format = 'fkdjkgfdlj'
            this.age = 'fkdjkgfdlj'
            this.genre = 'fkdjkgfdlj'
            this.nationality = 'fkdjkgfdlj'
            this.abstract = 'abstract'
            this.tech_info = 'tech_info'
            this.historical_context = 'historical_context'
            this.food = 'food'
        },
        saveClip: function () {
            this.debug()
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
                    console.log(response.data);
                    this.clip = response.data.clip
                    this.cursor = 1
                })
            }
            else if (this.cursor == 1) {
                let data = new FormData()
                data.append('clip_id', this.clip.id)
                data.append('abstract', this.abstract)
                data.append('tech_info', this.tech_info)
                data.append('historical_context', this.historical_context)
                data.append('food', this.food)

                this.$http.post('/api/v2/admin/clips/create-detail', data).then(response => {
                    console.log(response.data);
                    this.clip = response.data.clip
                    this.cursor = 2
                })
            }
            else if (this.cursor == 2) {
                let data = new FormData()


                this.$http.post('/api/v2/admin/clips/create-paratexts', data).then(response => {
                    console.log(response.data);
                    this.clip = response.data.clip
                    this.cursor = 2
                })
            }
        }
    },
    filters: {
        stateSetter: function (value, cursor) {
            if (cursor > value) {
                return false
            }
            else {
                return true
            }
        },
        completed: function (value, cursor) {
            if (cursor >= value) {
                return false
            }
            else {
                return true
            }

        },
    },
    created: function () {
        this.getData()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

label {
    font-size: $font-size-sm;
}

.topbar {
    &__steps {
        display: flex;
    }
}

.a-clip-panel {
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
