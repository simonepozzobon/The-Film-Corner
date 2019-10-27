<template lang="html">
    <div>

        <ui-container
            ref="table"
            v-if="this.table.hasOwnProperty('heading') && this.table.rows.length > 0">
            <ui-table
                :table="this.table"
                @destroy="destroyRow"/>
        </ui-container>

        <ui-container
            ref="container"
            v-for="(item, i) in this.fields"
            :key="item.key">
            <ui-form-title
                :title="item.title"
                v-if="item.type == 'title'"/>

            <ui-form-group-text
                v-else-if="item.type == 'input'"
                ref="input"
                :idx="i"
                :name="item.name"
                :title="item.title"
                :input-type="item.input"
                :is-mandatory="item.isMandatory"
                :is-mandatory-msg="item.isMandatoryMsg"
                :is-good-msg="item.isGoodMsg"
                @changed="setValue">
                {{ item.help }}
            </ui-form-group-text>

            <ui-form-checkbox
                    v-else-if="item.type == 'checkbox'"
                    ref="checkbox"
                    :idx="i"
                    :title="item.title"
                    :name="item.name"
                    :help="item.help"
                    :url="item.url"
                    :url-text="item.urlText"
                    :is-mandatory="item.isMandatory"
                    :is-mandatory-msg="item.isMandatoryMsg"
                    :is-good-msg="item.isGoodMsg"
                    @changed="setCheckbox"
                    />

            <hr class="my-5" v-else>

        </ui-container>

        <div class="mt-5 alert alert-danger" style="display: none" role="alert" ref="alert">
            <h4><strong>Error!</strong></h4>
            <span v-html="this.errorMsg"></span>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" @click="upload">Add Another School</button>
        </div>
    </div>
</template>

<script>
import UiBlock from './UiBlock.vue'
import UiContainer from './UiContainer.vue'
import UiFormCheckbox from './UiFormCheckbox.vue'
import UiFormGroup from './UiFormGroup.vue'
import UiFormGroupText from './UiFormGroupText.vue'
import UiFormTitle from './UiFormTitle.vue'
import UiModal from './UiModal.vue'
import UiTable from './UiTable.vue'
import {
    TweenMax
}
from 'gsap/all'

export default {
    name: 'UiDynamicInput',
    components: {
        UiBlock,
        UiContainer,
        UiFormCheckbox,
        UiFormGroup,
        UiFormGroupText,
        UiFormTitle,
        UiModal,
        UiTable,
    },
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        name: {
            type: String,
            default: 'name',
            required: true
        },
        fields: {
            type: Array,
            default: function () {}
        },
        initialObj: {
            type: Object,
            default: function () {}
        },
        api: {
            type: String,
            default: 'nulllo',
        },
        globalError: {
            type: String,
            default: 'nulllo',
        },
        isMandatory: {
            type: Boolean,
            default: true,
        },
        isMandatoryMsg: {
            type: String,
            default: 'This field is mandatory.'
        },
        isGoodMsg: {
            type: String,
            default: 'Looks Good'
        },
    },
    data: function () {
        return {
            obj: {},
            hasError: null,
            missingFields: 0,
            errorMsg: null,
            table: {},
            value: [],
        }
    },
    watch: {
        hasError: function (status) {
            let el = this.$refs.alert
            let master = new TimelineMax({
                paused: true
            })

            if (status == true) {
                master.fromTo(el, .1, {
                    display: 'none',
                }, {
                    display: 'block'
                }, 0)

                master.fromTo(el, .6, {
                    autoAlpha: 0,
                }, {
                    autoAlpha: 1
                })
            }
            else {
                master.fromTo(el, .1, {
                    display: 'block'
                }, {
                    display: 'none',
                }, 0)

                master.fromTo(el, .1, {
                    autoAlpha: 1
                }, {
                    autoAlpha: 0,
                })
            }

            master.play()
        },
        value: function (value) {
            this.$emit('changed', value, this.name, this.idx)
        }
    },
    methods: {
        uuid: function () {
            // https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            )
        },
        globalCheck: function () {
            let check = this.checkFields()
            return check
        },
        checkFields: function () {
            let inputs = this.$refs.input
            let hasError = false
            let check = false

            // Se sono già state inserire delle righe le salva
            if (this.table.rows.length > 0) {
                check = true
                // verifica se almeno uno dei campi è stato compilato
                for (let i = 0; i < inputs.length; i++) {
                    let value = inputs[i].value

                    // verifico se il campo è compilato
                    if (value && value != '') {
                        check = this.upload(true)
                        break
                    }
                    else {
                        inputs[i].clear()
                        this.hasError = null
                        check = true
                    }
                }

            }
            else {
                // altrimenti guarda se c'è qualcosa nei campi
                check = false
                // verifica se almeno uno dei campi è stato compilato
                for (let i = 0; i < inputs.length; i++) {
                    let value = inputs[i].value

                    // verifico se il campo è compilato
                    hasError = false
                    if (value && value != '') {
                        check = this.upload(true)
                        break
                    }
                    else {
                        hasError = true
                        inputs[i].check()
                    }
                }
                if (hasError) {
                    this.errorMsg = this.globalError
                    this.hasError = true
                    check = false
                }
            }

            return check
        },
        destroyRow: function (row) {
            let idx = this.table.rows.findIndex(item => item[0] == row[0])
            if (idx > -1) {
                this.table.rows.splice(idx, 1)
            }
        },
        setValue: function (value, field, idx) {
            this.obj[field] = value // assegno il valore
            this.$refs.container[idx].emit('check', field)

            // prevent errors feedback when there is already a schooll
            if (this.table.rows.length > 0 && (value == '' || !value)) {
                let inputs = this.$refs.input
                let hasCompiled = false
                for (let i = 0; i < inputs.length; i++) {
                    let el = inputs[i].value
                    if (el && el != '') {
                        hasCompiled = true
                    }
                }
                if (!hasCompiled) {
                    let containers = this.$refs.container
                    for (let i = 0; i < containers.length; i++) {
                        containers[i].emit('clear-all')
                    }
                    this.hasError = false
                    this.hasError = null
                }
            }
        },
        show: function () {
            if (this.obj && this.fields) {
                this.$refs.modal.show()
            }
        },
        upload: function (hasReturn = false) {
            this.hasError = null
            this.errorMsg = 'Please check '
            this.missingFields = 0

            let inputs = this.$refs.input

            // iterate trough obj key to prepare the FormData
            for (let key in this.obj) {
                if (this.obj.hasOwnProperty(key)) {
                    // select the child component to check if is mandatory and ready to send
                    let idx = inputs.findIndex(item => item.name == key)

                    // if is consistent
                    if (idx > -1) {

                        // check it's value
                        let check = inputs[idx].globalCheck()

                        // if it's not valid
                        if (!check) {
                            inputs[idx].check()

                            // prepare the error message
                            this.errorMsg = this.errorMsg + '<b>' + inputs[idx].title + '</b>' + ', '
                            this.hasError = true
                            this.missingFields++
                        }
                    }
                }
            }

            if (hasReturn) {
                return this.sendRequest(hasReturn)
            }
            else {
                this.sendRequest()
            }

            // close the error message


        },
        sendRequest: function (hasReturn = false) {
            if (this.hasError == true) {
                if (this.missingFields > 1) {
                    this.errorMsg = this.errorMsg + ' these fields are mandatory!'
                }
                else {
                    this.errorMsg = this.errorMsg + 'this field is mandatory!'
                }
                if (hasReturn) {
                    return false
                }
            }
            else {
                let row = this.formatRow(this.obj)
                this.table.rows.push(row)
                this.clearForm()
                if (hasReturn) {
                    return true
                }
            }
        },
        formatRow: function () {
            let row = []
            let uuid = this.uuid()
            row.push(uuid)
            let inputs = this.$refs.input
            let dummy = {}

            for (let key in this.obj) {
                if (this.obj.hasOwnProperty(key)) {
                    // select the child component to check if is mandatory and ready to send
                    let idx = inputs.findIndex(item => item.name == key)

                    // if is consistent
                    if (idx > -1) {
                        row.push(inputs[idx].value)
                        dummy[key] = inputs[idx].value
                    }
                }
            }
            this.value.push(dummy)
            return row
        },
        setTable: function () {
            let heading = []
            let inputs = this.$refs.input
            // iterate trough obj key to prepare the FormData
            for (let key in this.obj) {
                if (this.obj.hasOwnProperty(key)) {
                    // select the child component to check if is mandatory and ready to send
                    let idx = inputs.findIndex(item => item.name == key)

                    // if is consistent
                    if (idx > -1) {
                        heading.push(inputs[idx].title)
                    }
                }
            }
            this.table = {
                heading: heading,
                rows: [],
            }
        },
        setData: function (data, field, value) {
            if (value) {
                data.append(field, value)
                return data
            }
            return data
        },
        clearForm: function () {
            let inputs = this.$refs.input
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].clear()
            }
        }
    },
    mounted: function () {
        this.obj = this.initialObj
        this.setTable()
    }
}
</script>
