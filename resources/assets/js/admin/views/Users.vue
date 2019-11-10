<template>
<div class="admin-users">
    <container padding="sm">
        <div class="admin-users__topbar">
            <div class="admin-users__create">
                <ui-button
                    title="Aggiungi Utente"
                    color="lightest-gray"
                    :has-container="false"
                    :has-margin="false"
                    @click="showPanel"
                />
            </div>
            <div class="admin-users__per-page">
                <label for="perpage">
                    Per pagina
                </label>
                <select
                    name="perpage"
                    v-model="perPage"
                    class="form-control"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="admin-users__search">
                <input
                    type="text"
                    class="form-control"
                    placeholder="cerca"
                    v-model="filter"
                />
            </div>
        </div>
    </container>
    <create-user
        ref="panel"
        :initial="form"
        @saved="saved"
    />
    <container :has-margin="false">
        <b-table
            striped
            hover
            sortable
            :items="users"
            :fields="fields"
            :filter="filter"
            :current-page="currentPage"
            :per-page="perPage"
            @filtered="onFiltered"
        >
            <template v-slot:cell(role_id)="data">
                <span v-if="Number(data.item.role_id) === 1 ">Insegnante</span>
                <span v-else-if="Number(data.item.role_id) === 2">Studente</span>
                <span v-else-if="Number(data.item.role_id) === 3">Ospite</span>
            </template>

            <template v-slot:cell(tools)="data">
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    size="sm"
                    title="elimina"
                    color="danger"
                    @click="destroy(data.item)"
                />
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    size="sm"
                    title="modifica"
                    color="warning"
                    @click="edit(data.item)"
                />
            </template>
        </b-table>
        <div class="admin-users__center">
            <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                align="center"
                class="my-0"
            />
        </div>
    </container>
</div>
</template>

<script>
import {
    Container,
    DynamicForm,
}
from '../adminui'

import {
    UiButton
}
from '../../ui'

import CreateUser from '../components/CreateUser.vue'

export default {
    name: 'Users',
    components: {
        Container,
        CreateUser,
        DynamicForm,
        UiButton,
    },
    data: function () {
        return {
            users: [],
            form: null,
            filter: null,
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            fields: [{
                    key: 'id',
                    label: 'ID',
                    sortable: true,
                },
                {
                    key: 'role_id',
                    label: 'Tipo',
                    sortable: true,
                },
                {
                    key: 'name',
                    label: 'Nome',
                    sortable: true,
                },
                {
                    key: 'surname',
                    label: 'Cognome',
                    sortable: true,
                },
                {
                    key: 'email',
                    label: 'Email',
                    sortable: true,
                },
                {
                    key: 'tools',
                    label: '',
                    sortable: false,
                }
            ],
        }
    },
    watch: {
        users: function (users) {
            this.totalRows = users.length
        },
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/admin/users').then(response => {
                if (response.data.success) {
                    this.users = response.data.users
                }
            })
        },
        showPanel: function () {
            this.$refs.panel.show()
        },
        saved: function (item) {
            let idx = this.users.findIndex(user => user.id === item.id)
            if (idx > -1) {
                // modificato
                this.users.splice(idx, 1, item)
            }
            else {
                // creato
                this.users.push(item)
            }
        },
        destroy: function (item) {
            let url = '/api/v2/admin/users/' + item.id
            this.$http.delete(url).then(response => {
                if (response.data.success) {
                    this.users = this.users.filter(user => user.id != item.id)
                }
            })
        },
        edit: function (item) {
            this.form = {
                id: item.id,
                name: item.name,
                surname: item.surname,
                email: item.email,
                password: null,
                role_id: item.role_id
            }
            this.showPanel()
        },
        onFiltered: function (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        }
    },
    created: function () {
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-users {
    &__center {
        display: flex;
        justify-content: center;
    }

    &__per-page {
        margin-left: auto;
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__search {
        max-width: 200px;
    }
}
</style>
