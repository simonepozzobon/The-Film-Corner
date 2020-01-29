<template>
<div class="lib-media">
    <b-table
        :fields="fields"
        :items="medias"
        hover
        striped
        borderless
    >
        <template v-slot:cell(preview)="data">
            <div v-if="data.item.media_type == 'image'">
                <img
                    :src="data.item.media"
                    class="para-img"
                    @click.stop.prevent="showPreview(data.item)"
                >
            </div>
        </template>
        <template v-slot:cell(tools)="data">
            <ui-button
                color="orange"
                title="Aggiungi Traduzioni"
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
            fields: [{
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
            }],
            medias: [],
        }
    },
    watch: {
        exercise: function () {
            this.setMedia()
        },
        initials: function (initials) {
            console.log('initials', initials);
        }
    },
    methods: {
        setMedia: function (libraries = null) {
            if (this.exercise.libraries.length > 0 && libraries == null) {
                this.medias = Object.assign([], this.exercise.libraries[0].medias)
            }
            else if (libraries != null && libraries.length > 0) {
                console.log('medias', libraries);
                this.medias = Object.assign([], libraries[0].medias)


                console.log(this.medias);
            }
        },
        destroy: function (item) {
            this.$emit('destroy', item)
        },
        setInitials: function () {
            this.setMedia(this.initials)
        },
        translate: function (item) {
            console.log('translate');
            this.$emit('translate', item)
        }
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
