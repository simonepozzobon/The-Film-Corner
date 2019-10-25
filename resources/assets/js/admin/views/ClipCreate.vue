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
                    :completed="false"
                />
                <step
                    :number="2"
                    :completed="false"
                />
                <step
                    :number="3"
                    :completed="false"
                />
                <step
                    :number="4"
                    :completed="false"
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
    <container>
        <approfondimenti @update="updateField" />
    </container>
    <container>
        <paratexts @update="updateField" />
    </container>
    <container>
        <esercizi @update="updateField" />
    </container>
    <container padding="sm">
        <div class="a-clip-panel__topbar">
            <ui-button
                title="Salva Clip"
                color="green"
                :has-container="false"
                :has-margin="false"
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
            title: null,
            video: null,
            period: null,
            directors: [],
            peoples: [],
            year: null,
            format: null,
            age: null,
            genre: null,
            region: null,
            topics: [],

            options: {
                periods: [],
                directors: [],
                genres: [],
                formats: [],
                ages: [],
                topics: [],
                peoples: [],
                hashtags: [],
            },
        }
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
        saveClip: function () {
            let data = new FormData()
            data.append('title', this.title)
            data.append('video', this.video)
            data.append('period', this.period)
            data.append('year', this.year)
            data.append('format', this.format)
            data.append('age', this.age)
            data.append('genre', this.genre)
            data.append('region', this.region)

            data.append('topics', JSON.stringify(this.topics))
            data.append('directors', JSON.stringify(this.directors))
            data.append('peoples', JSON.stringify(this.peoples))


            this.$http.post('/api/v2/admin/clips/create', data).then(response => {
                console.log(response.data);
            })
        }
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
