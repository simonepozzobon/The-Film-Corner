<template>
<div class="a-clip-panel">
    <container
        padding="sm"
        :contains="true"
    >
        <div class="a-clip-panel__topbar topbar">
            <div class="topbar__head">
                <ui-title
                    title="Nuova Clip"
                    tag="h1"
                    font-size="h1"
                    class="topbar__title"
                />
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
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(0)"
    >
        <carica-clip @update="updateField" />
    </container>
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(0)"
    >
        <informazioni
            :options="options"
            @update="updateField"
        />
    </container>
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(1)"
    >
        <approfondimenti @update="updateField" />
    </container>
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(2)"
    >
        <paratexts
            :clip="this.clip"
            :options="options"
            @update="updateField"
            @completed="paratextCompleted"
            @uncomplete="paratextUncomplete"
        />
    </container>
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(3)"
    >
        <esercizi @update="updateField" />
    </container>
    <container
        :contains="true"
        :has-animations="true"
        :state="this.cursor | stateSetter(4)"
    >
        <librerie-esercizi @update="updateField" />
    </container>
    <container
        padding="sm"
        :contains="true"
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
import LibrerieEsercizi from '../components/clips/LibrerieEsercizi.vue'

export default {
    name: 'ClipCreate',
    components: {
        Approfondimenti,
        CaricaClip,
        Informazioni,
        LibrerieEsercizi,
        Paratexts,
        Esercizi,
        Step,
        Container,
        UiButton,
        UiTitle,
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
            cursor: 0,
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
            console.log('cambio cursore', cursor);
        },
    },
    methods: {
        getData: function () {
            // this.debug()
            this.$http.get('/api/v2/admin/clips/get-initials').then(response => {
                for (let key in this.options) {
                    if (this.options.hasOwnProperty(key) && response.data.hasOwnProperty(key)) {
                        this.options[key] = response.data[key]
                    }
                }
                this.period = this.options.periods[0].id

                console.log('completed');
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
        },
        paratextCompleted: function () {
            this.cursor = 3
        },
        paratextUncomplete: function () {
            this.cursor = 2
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
