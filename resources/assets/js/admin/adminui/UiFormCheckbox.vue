<template lang="html">
    <ui-form-group
        :name="name"
        :title="title"
        :class="containerClass">

        <label class="custom-control custom-checkbox">
            <input
                ref="input"
                type="checkbox"
                name="name"
                v-model="value"
                class="custom-control-input"
                :class="inputClass"
                :aria-describedby="helpName"/>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description" v-if="url">
                {{ help }}
                - (<a :href="url" target="_blank">{{ urlText }}</a>)
            </span>
            <span class="custom-control-description" v-else>{{ help }}</span>
        </label>

        <div class="form-control-feedback" ref="message" v-if="hasValidCheck">
            {{ this.statusMessage }}
        </div>

    </ui-form-group>
</template>

<script>
import UiFormGroup from './UiFormGroup.vue'
export default {
    name: 'UiFormCheckbox',
    components: {
        UiFormGroup,
    },
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        name: {
            type: String,
            default: 'name'
        },
        title: {
            type: String,
            default: 'titolo'
        },
        isMandatory: {
            type: Boolean,
            default: true
        },
        isMandatoryMsg: {
            type: String,
            default: 'This field is mandatory.'
        },
        isGoodMsg: {
            type: String,
            default: 'Looks Good'
        },
        help: {
            type: String,
            default: null
        },
        url: {
            type: String,
            default: null
        },
        urlText: {
            type: String,
            default: 'Link'
        },
        initial: {
            type: Boolean,
            default: null
        },
        hasValidCheck: {
            type: Boolean,
            default: true,
        }
    },
    data: function () {
        return {
            value: null,
            status: null,
            isClearing: false,
            message: null,
        }
    },
    computed: {
        helpName: function () {
            return this.name + '_help'
        },
        containerClass: function () {
            if (this.status == true) {
                return 'has-success'
            }
            else if (this.status == false) {
                return 'has-danger'
            }
            else {
                return null
            }
        },
        inputClass: function () {
            if (this.status == true) {
                return 'form-control-success'
            }
            else if (this.status == false) {
                return 'form-control-danger'
            }
            else {
                return null
            }
        },
        statusMessage: function () {
            if (this.status) {
                return this.isGoodMsg
            }
            else if (this.status == false) {
                return this.isMandatoryMsg
            }
            return null
        }
    },
    watch: {
        value: function (value) {
            if (this.isClearing == false) {
                if (this.value) {
                    this.$emit('changed', 1, this.name, this.idx)
                }
                else {
                    this.$emit('changed', 0, this.name, this.idx)
                }
            }
        }
    },
    methods: {
        globalCheck: function () {
            if (this.isMandatory) {
                if (this.value) {
                    return true
                }
                return false
            }
            return true
        },
        check: function () {
            if (this.isMandatory) {
                if (this.value && this.value != '') {
                    this.setValid()
                }
                else {
                    this.setInvalid()
                }
            }
            else {
                this.setValid()
            }
        },
        setValid: function () {
            let el = this.$refs.input

            if (this.hasValidCheck) {
                this.status = true

                el.classList.remove('is-invalid')
                this.hideMessage()

                el.classList.add('is-valid')
                this.showMessage()
            }

        },
        setInvalid: function () {
            let el = this.$refs.input
            if (this.hasValidCheck) {
                this.status = false

                el.classList.remove('is-valid')
                this.hideMessage()

                el.classList.add('is-invalid')
                this.showMessage()
            }
        },
        clearFeedback: function () {
            let el = this.$refs.input
            this.status = null

            el.classList.remove('is-invalid')
            this.hideMessage()

            el.classList.remove('is-valid')
            this.hideMessage()

        },
        clear: function () {
            this.clearFeedback()

            // Prevent the watcher to trigger the event and check the field
            this.isClearing = true
            this.value = null
            this.$nextTick(() => {
                this.isClearing = false
            })
        },
        initAnim: function () {
            let message = this.$refs.message
            if (message) {
                this.message = new TimelineMax({
                    paused: true,
                    reversed: true,
                })

                this.message.fromTo(message, .3, {
                    autoAlpha: 0,
                    display: 'none',
                }, {
                    autoAlpha: 1,
                    display: 'block',
                }, 0)

                this.message.progress(1).progress(0)
            }
        },
        showMessage: function () {
            if (this.message) {
                this.message.timeScale(1).progress(0).play()
            }
        },
        hideMessage: function () {
            if (this.message) {
                this.message.timeScale(5).progress(1).reverse()
            }
        }
    },
    mounted: function () {
        if (this.initial != null) {
            this.value = this.initial
        }

        this.initAnim()

        this.$parent.$on('check', field => {
            if (field == this.name) {
                this.check()
            }
        })

        this.$parent.$on('clear-all', () => {
            this.clear()
        })
    }

}
</script>

<style lang="css">
</style>
