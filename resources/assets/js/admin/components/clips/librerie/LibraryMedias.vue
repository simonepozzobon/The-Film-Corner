<template>
<div class="lib-media">
    <b-table
        :fields="fields"
        :items="medias"
        hover
        striped
        borderless
    >
        <template v-slot:cell(url)="data">
            <div v-if="data.item.media_type == 'image'">
                <img
                    :src="data.item.media"
                    class="para-img"
                    @click.stop.prevent="showPreview(data.item)"
                >
            </div>
            <div v-else-if="data.item.library_type_id == 3">
                <simple-video-player :src="data.item.url | filterUrl" />
            </div>
        </template>
        <template v-slot:cell(tools)="data">
            <ui-button
                color="orange"
                title="Aggiungi traduzioni"
                size="sm"
                theme="outline"
                :has-margin="false"
                :has-container="false"
                @click="translate(data.item)"
            />
            <ui-button
                color="red"
                title="Elimina"
                size="sm"
                theme="outline"
                :has-margin="false"
                :has-container="false"
                @click="destroy(data.item)"
            />
        </template>
    </b-table>
</div>
</template>

<script>
import {
    BlockContent,
    SimpleVideoPlayer,
}
from '../../../adminui'

import {
    UiButton,
}
from '../../../../ui'

export default {
    name: 'LibraryMedias',
    components: {
        BlockContent,
        UiButton,
        SimpleVideoPlayer,
    },
    props: {
        exercise: {
            type: Object,
            default: function () {
                return {}
            },
        },
        initials: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {

            medias: [],
        }
    },
    watch: {
        exercise: function () {
            this.setMedia()
        },
        initials: function (initials) {
            // console.log('initials', initials);
            this.setMedia(initials)
        }
    },
    computed: {
        fields: function () {
            if (this.exercise.library_type_id == 2) {
                return [{
                    key: 'id',
                    label: 'id',
                    sortable: true
                }, {
                    key: 'title',
                    label: 'Titolo',
                    sortable: true,
                }, {
                    key: 'tools',
                    label: 'Strumenti',
                    sortable: false,
                }]
            }
            return [{
                key: 'id',
                label: 'id',
                sortable: true
            }, {
                key: 'title',
                label: 'Titolo',
                sortable: true,
            }, {
                key: 'url',
                label: 'Anteprima',
                sortable: false,
            }, {
                key: 'tools',
                label: 'Strumenti',
                sortable: false,
            }]
        },
    },
    methods: {

        setMedia: function (libraries = null) {
            if (this.exercise.libraries.length > 0 && libraries == null) {
                this.medias = Object.assign([], this.exercise.libraries[0].medias)
            }
            else if (libraries != null && libraries.length > 0) {
                this.medias = Object.assign([], libraries[0].medias)

                // // DEBUG
                // setTimeout(() => {
                //     this.translate(this.medias[0])
                // }, 1000)
            }
        },
        destroy: function (item) {

            let url = `/api/v2/admin/clips/libraries/destroy/${item.id}`

            this.$http.delete(url).then(response => {
                // console.log(response);
                this.$emit('deleted', {
                    id: response.data.id,
                    clip: response.data.clip,
                })
            })
        },
        setInitials: function () {
            this.setMedia(this.initials)
        },
        translate: function (item) {
            this.$emit('translate', item)
        }
    },
    filters: {
        filterUrl: function (url) {
            url = url.replace('public/', '')
            return '/storage/' + url
        },
    },
    mounted: function () {
        this.setMedia()
        this.setInitials()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
