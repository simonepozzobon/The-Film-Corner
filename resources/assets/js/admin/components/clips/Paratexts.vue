<template>
<div class="a-clip-panel__group">
    <ui-title
        title="Paratesti"
        tag="span"
        font-size="h5"
        :has-padding="false"
        :has-margin="false"
        :has-container="false"
    />
    <hr class="a-clip-panel__divider">
    <div
        class="a-clip-panel__row form-group row"
        v-if="createPara"
    >
        <label class="col-md-2">
            Contiene Media?
        </label>
        <switch-input
            label="Compare The Clips"
            label-size="col-md-1"
            input-size="col-md-1"
            :has-row="false"
        />
        <label
            for="year"
            class="col-md-1"
        >
            Tipo di paratesto
        </label>
        <div class="col-md-3">
            <input
                type="text"
                name="year"
                class="form-control"
                v-model="type"
            />
        </div>

    </div>

    <ui-button
        :title="text"
        color="yellow"
        @click="showForm"
    />
    <hr class="a-clip-panel__divider">

    <div>
        <paratext
            v-for="content in paratexts"
            :key="content.id"
            :para="content"
        />
    </div>



</div>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'
import Paratext from './Paratext.vue'


export default {
    name: 'Paratesti',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
        Paratext,
    },
    props: {
        options: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            period: null,
            year: null,
            region: null,
            createPara: false,
            text: 'aggiungi',
            type: null,
            has_image: true,
            paratexts: [],
        }
    },
    methods: {
        showForm: function () {
            if (this.createPara) {
                this.text = 'aggiungi'
                this.store()
            }
            else {
                this.text = 'Salva'
                this.createPara = true
            }
        },
        debug: function () {
            this.has_image = true
            this.type = 'sdfskaljdflkjldfs'
            this.createPara = true
            this.showForm()
        },
        store: function () {
            let data = new FormData()
            data.append('type', this.type);
            data.append('has_image', this.has_image)

            this.$http.post('/api/v2/admin/clips/create-paratexts', data).then(response => {
                console.log('ciao', response.data.para);
                this.paratexts.push(response.data.para)
                this.createPara = false
            })
        },
    },
    mounted: function () {
        this.debug()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
