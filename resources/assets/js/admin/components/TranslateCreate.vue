<template>
<container
    ref="container"
    class="translate-create"
>
    <div class="form">
        <translate-create-language
            v-for="language in languages"
            :key="language.id"
            :title="language.language"
            @load="loaded"
        />
        <div class="action-row">
            <ui-button
                class="action-row__button"
                :has-container="false"
                :has-margin="false"
                color="lightest-gray"
                title="Salva"
                @click="save"
            />
            <ui-button
                class="action-row__button"
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
    UiButton
}
from '../../ui'
import TranslateCreateLanguage from './TranslateCreateLanguage.vue'

export default {
    name: 'CreateUser',
    components: {
        Container,
        TranslateCreateLanguage,
        UiButton,
    },
    props: {
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
        languages: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {
            counter: 0,
            master: null,
            isOpen: false,
            form: {
                name: null,
                surname: null,
                email: null,
                password: null,
                role_id: null,
            }
        }
    },
    watch: {
        initial: function (obj) {
            this.form = obj
        },
        languages: function (languages) {
            // this.init()
        }
    },
    methods: {
        init: function () {
            console.log('init');
            let container = this.$refs.container.$el
            let clientRect = container.getBoundingClientRect()
            let height = clientRect.height
            console.log(height);

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
            let data = this.formatData(this.form)

            this.$http.post('/api/v2/admin/users/save', data).then(response => {
                if (response.data.success) {
                    this.$emit('saved', response.data.user)
                    this.hide()
                }
            })
        },
        formatData: function (object) {
            let data = new FormData()

            for (let key in object) {
                if (object.hasOwnProperty(key)) {
                    data.append(key, object[key])
                }
            }

            return data
        },
        undo: function () {
            this.hide()
            this.form = {
                name: null,
                surname: null,
                email: null,
                password: null,
                role_id: null,
            }
        },
        loaded: function () {
            this.counter++
            if (this.languages.length == this.counter) {
                this.init()
            }
        }
    },
    created: function () {
        if (this.initial) {
            this.form = this.initial
        }
    },
    mounted: function () {},
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
