<template>
<container
    ref="container"
    class="create-user"
>
    <div class="form">
        <div class="form-group row">
            <label
                for="name"
                class="col-md-2"
            >
                Nome
            </label>
            <input
                type="text"
                name="name"
                class="form-control col-md-9"
                v-model="form.name"
            />
        </div>
        <div class="form-group row">
            <label
                for="surname"
                class="col-md-2"
            >
                Cognome
            </label>
            <input
                type="text"
                name="surname"
                class="form-control col-md-9"
                v-model="form.surname"
            />
        </div>
        <div class="form-group row">
            <label
                for="email"
                class="col-md-2"
            >
                Email
            </label>
            <input
                type="email"
                name="email"
                class="form-control col-md-9"
                v-model="form.email"
            />
        </div>
        <div class="form-group row">
            <label
                for="password"
                class="col-md-2"
            >
                Password
            </label>
            <input
                type="text"
                name="password"
                class="form-control col-md-9"
                v-model="form.password"
            />
        </div>
        <div class="form-group row">
            <label
                for="role_id"
                class="col-md-2"
            >
                Tipo
            </label>
            <select
                class="form-control col-md-9"
                name="role_id"
                v-model="form.role_id"
            >
                <option value="1">Insegnante</option>
                <option value="2">Student</option>
                <option value="3">Guest</option>
            </select>
        </div>
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

export default {
    name: 'CreateUser',
    components: {
        Container,
        UiButton,
    },
    props: {
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
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
        }
    },
    methods: {
        init: function () {
            let container = this.$refs.container.$el
            let clientRect = container.getBoundingClientRect()
            let height = clientRect.height

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
        }
    },
    created: function () {
        if (this.initial) {
            this.form = this.initial
        }
    },
    mounted: function () {
        this.init()
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

.create-user {
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
