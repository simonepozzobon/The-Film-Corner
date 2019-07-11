<template lang="html">
    <ui-form-group
        :name="name"
        :title="title"
        :class="containerClass">

        <input
            ref="input"
            :type="inputType"
            name="name"
            v-model="value"
            class="form-control"
            :class="inputClass"
            :aria-describedby="helpName">

        <small
            :id="helpName"
            class="form-text text-muted">
            <slot></slot>
        </small>

        <div class="form-control-feedback" ref="message">
            {{ this.statusMessage }}
        </div>

    </ui-form-group>
</template>

<script>
import UiFormGroup from './UiFormGroup.vue'
export default {
    name: 'UiFormGroupText',
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
        inputType: {
            type: String,
            default: 'text',
        }
    },
    data: function() {
        return {
            value: null,
            status: null,
            isClearing: false,
            message: null,
        }
    },
    computed: {
        helpName: function() {
            return this.name + '_help'
        },
        containerClass: function() {
            if (this.status == true) {
                return 'has-success'
            } else if (this.status == false) {
                return 'has-danger'
            } else {
                return null
            }
        },
        inputClass: function() {
            if (this.status == true) {
                return 'form-control-success'
            } else if (this.status == false) {
                return 'form-control-danger'
            } else {
                return null
            }
        },
        statusMessage: function() {
            if (this.status) {
                return this.isGoodMsg
            } else if (this.status == false) {
                return this.isMandatoryMsg
            }
            return null
        }
    },
    watch: {
        value: function(value) {
            if (this.isClearing == false) {
                this.$emit('changed', value, this.name, this.idx)
            }
        }
    },
    methods: {
        globalCheck: function() {
            if (this.isMandatory) {
                if (this.value && this.value != '') {
                    return true
                }
                return false
            }
            return true
        },
        check: function() {
            if (this.isMandatory) {
                if (this.value && this.value != '') {
                    this.setValid()
                } else {
                    this.setInvalid()
                }
            } else {
                this.setValid()
            }
        },
        setValid: function() {
            let el = this.$refs.input
            this.status = true

            el.classList.remove('is-invalid')
            this.hideMessage()

            el.classList.add('is-valid')
            this.showMessage()
            // console.log('set valid');
        },
        setInvalid: function() {
            let el = this.$refs.input
            this.status = false

            el.classList.remove('is-valid')
            this.hideMessage()

            el.classList.add('is-invalid')
            this.showMessage()
            // console.error('set invalid');
        },
        clearFeedback: function() {
            let el = this.$refs.input
            this.status = null

            el.classList.remove('is-invalid')
            this.hideMessage()

            el.classList.remove('is-valid')
            this.hideMessage()
            // console.log('clearing feedback');
        },
        clear: function() {
            this.clearFeedback()

            // Prevent the watcher to trigger the event and check the field
            this.isClearing = true
            this.value = null
            this.$nextTick(() => {
                this.isClearing = false
            })
        },
        initAnim: function() {
            let message = this.$refs.message


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

        },
        showMessage: function() {
            this.message.timeScale(1).progress(0).play()
            // console.log('showMessage');
        },
        hideMessage: function() {
            this.message.timeScale(5).progress(1).reverse()
            // console.log('hideMessage');
        },
    },
    mounted: function() {
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

<style lang="css" scoped>
</style>
