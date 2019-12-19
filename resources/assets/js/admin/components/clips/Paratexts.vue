<template>
<block-panel
    title="Paratesti"
    ref="panel"
    :needs-flex="true"
    :initial-state="state"
>
    <div
        class="para-container"
        ref="paraContainer"
    >
        <paratext
            v-for="paratext in paratexts"
            :key="paratext.id"
            :paratext="paratext"
            :clip-id="clip ? clip.id : 1"
            @completed="setCompleted"
            @uncomplete="setUncomplete"
            @translate="translate"
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
        state: {
            type: Boolean,
            default: false,
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
            initialState: true,
        }
    },
    watch: {
        'options.paratext_types': function (options) {
            if (this.initialized == false || this.selectOptions.length == 0) {
                this.initialized = true
                this.$nextTick(() => {
                    this.selectOptions = Object.assign([], options)
                })
            }
        },
        // state: function (value) {
        //     console.log(value);
        //     this.selectorReady()
        // },
        state: function (v) {
            console.log('state changed para', v);
            this.$nextTick(() => {
                this.$refs.panel.isOpen = false
                this.$refs.panel.togglePanel()
            })
        },
        clip: function () {
            this.$nextTick(() => {
                this.setClip()
            })
        },
    },
    methods: {
        translate: function (item) {
            this.$emit('translate', item)
        },
        setClip: function () {
            if (this.clip && this.clip.hasOwnProperty('paratexts') && this.clip.paratexts.length > 0) {
                let paratexts = this.clip.paratexts
                let cache = []
                for (let i = 0; i < paratexts.length; i++) {
                    let paratext = paratexts[i]
                    let typeId = paratext.paratext_type_id

                    let group = this.selectOptions.find(opt => opt.id == typeId)

                    if (group) {
                        let idx = cache.findIndex(obj => obj.id == group.id)

                        if (idx < 0) {
                            // console.log(paratext, typeId);
                            group = {
                                ...group,
                                contents: [paratext],
                            }
                            cache.push(group)
                        }
                        else {
                            cache[idx].contents.push(paratext)
                            // console.log('ce ', cache[idx]);
                        }
                    }
                }

                for (let i = 0; i < cache.length; i++) {
                    let current = cache[i]
                    this.paratext_selected = current

                    this.addParatextType()
                }
                // console.log('cache ', cache);

            }
        },
        selectorReady: function () {
            if (this.state == true) {
                console.log('res');
                this.$refs.panel.trigger()
                this.setClip()
            }
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
        },
        updateParatextType: function (value) {
            if (value) {
                this.paratext_id = value.id
                this.paratext_selected = this.options.paratext_types.find(single => single.id == value.id)
                console.log(value);
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
            console.log('completed');
            this.$emit('completed')
        },
        setUncomplete: function () {
            this.$emit('uncomplete')
        },
    },
    mounted: function () {
        if (this.options && this.options.paratext_types && this.options.paratext_types.length > 0) {
            this.initialized = true
            this.selectOptions = Object.assign([], this.options.paratext_types)
        }

        this.setClip()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-tools {
    &__title {
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}
</style>

<style lang="scss">
@import '~styles/shared';
</style>

<style lang="scss" scoped>
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
}
</style>
