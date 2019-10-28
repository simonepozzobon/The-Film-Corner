<template>
<block-panel
    title="Paratesti"
    ref="panel"
    :needs-trigger="true"
>
    <div
        class="para-container panel-group__container"
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

    <div class="para-tools">
        <panel-title
            title="Nuovo Paratesto"
            size="h4"
            class="para-tools__title"
            letter-spacing="6px"
        />
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
                    :options="selectOptions"
                    @update="updateParatextType"
                    @ready="selectorReady"
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
    </div>
</block-panel>
</template>

<script>
import {
    BlockPanel,
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
    PanelTitle,
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
        BlockPanel,
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
        PanelTitle,
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
            selectOptions: [],
            initialized: false,
        }
    },
    watch: {
        'options.paratext_types': function (options) {
            console.log('esterno');
            if (this.initialized == false || this.selectOptions.length == 0) {
                this.initialized = true
                this.selectOptions = Object.assign([], options)
            }
        },
    },
    methods: {
        selectorReady: function () {
            this.$refs.panel.trigger()
        },
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
            // console.log(Object.assign({}, this.clip));
            // let component = this.$refs.paratextType
            // let select = component.$refs.select
            //
            // let id = 2
            // $(select).val(id)
            // component.value = this.options.paratext_types.find(single => single.id == id)
            // this.$nextTick(() => {
            //     $(select).trigger('change')
            //     component.$emit('update', component.value)
            //
            //     this.$nextTick(() => {
            //         this.addParatextType()
            //     })
            // })
        },
        store: function () {
            console.log('deprecata');
        },
        updateParatextType: function (value) {
            if (value) {
                this.paratext_id = value.id
                this.paratext_selected = this.options.paratext_types.find(single => single.id == value.id)
            }
        },
        addParatextType: function () {
            // console.log(this.paratext_selected);
            if (this.paratext_selected) {
                this.paratexts.push(this.paratext_selected)
                let newOpts = this.selectOptions.filter(option => option.id != this.paratext_selected.id)
                // console.log(newOpts);
                this.selectOptions = newOpts
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
        if (this.options && this.options.paratext_types && this.options.paratext_types.length > 0) {
            this.initialized = true
            console.log('mounbted');
            this.selectOptions = Object.assign([], this.options.paratext_types)
        }
        this.$nextTick(() => {
            this.debug()
        })
        // this.$nextTick(() => {
        //     this.$util.onResizeListener(this.$refs.paraContainer, (el) => {
        //         let panel = this.$refs.panel
        //         let container = panel.$refs.container
        //         let height = container.style.height
        //         if (height != 'auto' && height != '1px') {
        //             console.log(height);
        //             // container.style.height = ''
        //         }
        //     })
        // })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>

<style lang="scss">
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-tools {
    @include gradient-directional($color, lighten($color, 2), -11deg);
    @include border-radius($border-radius * 2);
    @include custom-box-shadow($darken, 2px, 0.02);
    width: 100%;
    padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);

    &__title {
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}
.para-container {
    // width: 100%;
    // position: relative;
    // transition: $transition-base-lg !important;
    // height: 0;
    // overflow: hidden;
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
