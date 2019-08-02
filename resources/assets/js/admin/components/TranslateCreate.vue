<template>
<container
    ref="container"
    class="translate-create"
>
    <div class="form">
        <translate-loop
            v-for="(option, i) in options"
            :key="i"
            :option="option"
            :languages="languages"
            :initial="initial"
        >
            <translate-create-language
                v-for="language in languages"
                :key="language.id"
                :language="language"
                :title="language.language"
                :initial="language.initial"
                :option="option"
                @load="loaded"
                @update="updateTranslation"
            />
        </translate-loop>
        <!-- <div
            v-for="(option, i) in this.options"
            :key="option.title"
        >
            <ui-title
                :title="option.label"
                :has-container="false"
            />

        </div> -->
        <div class="action-row">
            <ui-button
                class="action-row__button"
                :disable="isDisable"
                :has-spinner="isDisable"
                :has-container="false"
                :has-margin="false"
                color="lightest-gray"
                title="Salva"
                @click="save"
            />
            <ui-button
                class="action-row__button"
                :disable="isDisable"
                :has-container="false"
                :has-margin="false"
                color="warning"
                title="Annulla"
                @click="undo"
            />
        </div>
    </div>
</container>
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
import TranslateLoop from './TranslateLoop.vue'
import TranslateCreateLanguage from './TranslateCreateLanguage.vue'

export default {
    name: 'TranslateCreate',
    components: {
        Container,
        TranslateLoop,
        TranslateCreateLanguage,
        UiButton,
        UiTitle,
    },
    props: {
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
        current: {
            type: Object,
            default: function () {
                return {}
            },
        },
        options: {
            type: Array,
            default: function () {
                return []
            },
        },
        languages: {
            type: Array,
            default: function () {
                return []
            },
        },
        type: {
            type: String,
            default: null,
        },
        typeId: {
            type: Number,
            default: 0,
        },
    },
    data: function () {
        return {
            counter: 0,
            master: null,
            isOpen: false,
            form: {},
            isDisable: false,
        }
    },
    watch: {
        initial: function (obj) {
            // console.log(obj);
            // this.form = obj
        },
        languages: {
            handler: function (languages) {
                this.setFormData()
                // this.init()
                // console.log('changed', this.form);
            },
            deep: true,
        }
    },
    methods: {
        init: function () {
            // console.log('init');
            let container = this.$refs.container.$el
            let clientRect = container.getBoundingClientRect()
            let height = clientRect.height
            // console.log(height);

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .6, {
                height: 0,
            }, {
                height: height,
                ease: Power4.easeInOut,
            }, 0)

            this.master.fromTo(container, .6, {
                autoAlpha: 1,
            }, {
                autoAlpha: 1,
            }, .3)

            this.master.progress(1).progress(0)
        },
        show: function () {
            if (this.master) {
                this.master.play()
                this.isOpen = true
            }
        },
        hide: function () {
            if (this.master) {
                this.master.reverse()
                this.isOpen = false
            }
        },
        save: function () {
            this.isDisable = true

            let data = this.formatData(this.form)

            this.$http.post('/api/v2/admin/translate/save', data).then(response => {
                // console.log(response.data);
                this.isDisable = false
                this.form = null
                setTimeout(() => {
                    if (response.data.success) {
                        this.$emit('saved', response.data.translations)
                    }
                }, 500)
            }).catch(err => {
                this.isDisable = false
                this.form = null
            })
        },
        formatData: function (object) {
            let data = new FormData()
            // let keys =[]
            // console.log('object', object);
            let dataObject = {}

            for (let key in object) {
                if (object.hasOwnProperty(key)) {
                    // dataObject[key] = object[key]
                    for (let locale in object[key]) {
                        if (object[key].hasOwnProperty(locale)) {
                            let translation = {}
                            translation[key] = object[key][locale]
                            if (dataObject[locale]) {
                                dataObject[locale][key] = translation[key]
                            }
                            else {
                                dataObject[locale] = {}
                                dataObject[locale][key] = translation[key]
                            }

                            // console.log(key, locale, translation);
                        }
                    }
                }
            }

            data.append('type', this.type)
            if (this.current && this.current.hasOwnProperty('id')) {
                // console.log(this.current);
                console.log(dataObject, this.type, this.current.id);
                data.append('item_id', this.current.id)
            }
            // else {
            //     // this.$nextTick(() => {
            //     //     this.save()
            //     // })
            // }
            data.append('translations', JSON.stringify(dataObject))

            return data
        },
        undo: function () {
            this.hide()
            this.form = {}
        },
        loaded: function () {
            this.counter++
            if (this.languages.length == this.counter) {
                this.init()
            }
        },
        setFormData: function () {
            let data = {}

            for (let i = 0; i < this.options.length; i++) {
                let key = this.options[i].title
                data[key] = {}

                for (let j = 0; j < this.languages.length; j++) {
                    let value = ''
                    let locale = this.languages[j].short
                    if (this.languages[j].hasOwnProperty('initial')) {
                        value = this.languages[j].initial
                    }
                    data[key][locale] = value
                }
            }

            this.form = data
            // console.log('qui', data);
        },
        updateTranslation: function (value, locale, key) {
            if (this.form.hasOwnProperty(key) && this.form[key].hasOwnProperty(locale)) {
                this.form[key][locale] = value
            }
        },
        debug: function () {
            this.$nextTick(() => {
                setTimeout(() => {
                    this.save()
                }, 1000)
            })
        },
    },
    created: function () {
        this.setFormData()
        // if (this.initial) {
        //     this.form = this.initial
        //     console.log(this.form, this.initial);
        // }
    },
    mounted: function () {
        // this.debug()
    },
    beforeDestroy: function () {
        if (this.master) {
            this.master.kill()
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.translate-create {
    overflow: hidden;
}

.action-row {
    display: flex;
    justify-content: center;

    &__button {
        margin-left: $spacer / 2;
        margin-right: $spacer / 2;
    }
}
</style>
