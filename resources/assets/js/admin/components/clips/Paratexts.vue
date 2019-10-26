<template>
<div class="a-clip-panel__group panel-group">
    <ui-title
        title="Paratesti"
        tag="h2"
        font-size="h2"
        class="panel-group__title"
        :has-shadows="true"
        :shadows-type="2"
    />
    <div
        class="mb-5 para-container panel-group__container"
        ref="paraContainer"
    >
        <paratext
            v-for="paratext in paratexts"
            :key="paratext.id"
            :paratext="paratext"
            :clip-id="clip ? clip.id : 1"
            @completed="setCompleted"
            @uncomplete="setUncomplete"
        />
    </div>

    <ui-title
        tag="h6"
        font-size="h6"
        title="Aggiungi nuova categoria di paratesti"
    />
    <hr class="a-clip-panel__divider">
    <div class="a-clip-panel__row form-group row">
        <label
            for="format"
            class="col-md-1"
        >
            Tipologia
        </label>
        <div class="col-md-3">
            <select-2-input
                ref="paratextType"
                :multiple="false"
                :options="this.options.paratext_types"
                @update="updateParatextType"
                @ready="debug"
            />
        </div>
        <div class="col-md-3">
            <ui-button
                :title="btnText"
                color="yellow"
                :has-margin="false"
                @click="addParatextType"
            />
        </div>
    </div>


    <hr class="a-clip-panel__divider">

    <!-- <div>
        <paratext
            v-for="content in paratexts"
            :key="content.id"
            :para="content"
        />
    </div> -->



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
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            paratext_id: null,
            paratext_selected: null,
            createPara: false,
            btnText: 'aggiungi',
            type: null,
            has_image: true,
            paratexts: [],
        }
    },
    methods: {
        showForm: function () {
            if (this.createPara) {
                this.btnText = 'aggiungi'
                this.store()
            }
            else {
                this.btnText = 'Salva'
                this.createPara = true
            }
        },
        debug: function () {
            let component = this.$refs.paratextType
            let select = component.$refs.select

            let id = 2
            $(select).val(id)
            component.value = this.options.paratext_types.find(single => single.id == id)
            this.$nextTick(() => {
                $(select).trigger('change')
                component.$emit('update', component.value)

                this.$nextTick(() => {
                    this.addParatextType()
                })
            })
        },
        store: function () {
            console.log('deprecata');
            // let data = new FormData()
            // data.append('type', this.type);
            // data.append('has_image', this.has_image)
            //
            // this.$http.post('/api/v2/admin/clips/create-paratexts', data).then(response => {
            //     console.log('ciao', response.data.para);
            //     this.paratexts.push(response.data.para)
            //     this.createPara = false
            // })
        },
        updateParatextType: function (value) {
            if (value) {
                this.paratext_id = value.id
                this.paratext_selected = this.options.paratext_types.find(single => single.id == value.id)
            }
        },
        addParatextType: function () {
            if (this.paratext_selected) {
                this.paratexts.push(this.paratext_selected)
            }
        },
        setCompleted: function () {
            this.$emit('completed')
        },
        setUncomplete: function () {
            this.$emit('uncomplete')
        },
    },
    mounted: function () {
        // this.debug()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-container {
    // width: 100%;
    // position: relative;
    transition: $transition-base-lg !important;
    // height: 0;
    overflow: hidden;
}

.panel-group {

    &__title {
        // color: rgba($color, .7);
        // -webkit-text-fill-color: rgba($color, .7);
        // -webkit-text-stroke: 2px $darken;
        // letter-spacing: 8px;
        color: $darken;
        padding: ($spacer * 2) ($spacer * 2) ($spacer * 1.618) 0;
        letter-spacing: 12px;
    }
}

.noHeight {
    height: 0;
    transition: $transition-base-lg !important;
}
</style>
