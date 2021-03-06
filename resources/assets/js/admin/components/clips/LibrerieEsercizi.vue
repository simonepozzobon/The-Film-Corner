<template>
<container
    :contains="true"
    :has-animations="true"
>
    <block-panel
        :title="exercise.title"
        :has-animations="true"
        ref="panel"
    >
        <div v-if="hasLibrary == true">
            <block-content title="Contenuti">
                <library-medias
                    :exercise="exercise"
                    :initials="initials | filterInitials(exercise)"
                    @deleted="deleted"
                    @translate="translate"
                />
            </block-content>
        </div>

        <div v-if="hasLibrary == false">
            Questo esercizio non utilizza librerie
        </div>
        <div v-else-if="hasLibrary == true && libraryOptions">
            <block-content :title="uploadText">
                <text-input
                    label="Titolo"
                    name="it_title"
                    :initial="title"
                    @update="updateTitle"
                    v-if="libraryOptions.type != 'audio'"
                />
                <text-editor
                    ref="description"
                    label="Descrizione"
                    :has-animation="true"
                    min-height="100px"
                    @update="updateDescription('it', arguments)"
                    v-if="libraryOptions.type != 'audio'"
                />
                <div class="uploader">
                    <div class="title-section form-group row">
                        <label
                            for="title"
                            class="col-md-2"
                        >
                            Upload file
                        </label>
                        <div class="col-md-10">
                            <file-preview
                                v-if="hasFile"
                                :file="file"
                                class="uploader__preview f-preview"
                                @clear="clearFile"
                            />

                            <upload-zone
                                ref="drop"
                                class="uploader__drop"
                                url="/api/v2/admin/clips/libraries/upload"
                                :accept="libraryOptions.accept"
                                :multiple="false"
                                :auto-process-queue="false"
                                :use-styles="false"
                                @file-added="addFileToQueue"
                                @success="addMediaToLibrary"
                            />

                            <transition name="upload-section-transition">
                                <div
                                    class="uploader__btn"
                                    v-if="isReadyToUpload"
                                >
                                    <ui-button
                                        title="carica"
                                        color="dark"
                                        theme="outline"
                                        :has-container="false"
                                        :has-margin="false"
                                        align="center"
                                        @click="uploadFile"
                                    />
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </block-content>
        </div>
    </block-panel>
</container>
</template>

<script>
import {
    BlockContent,
    BlockPanel,
    Container,
    TextEditor,
    TextInput,
    UploadZone,
}
from '../../adminui'

import {
    UiButton,
}
from '../../../ui'

import FilePreview from './librerie/FilePreview.vue'
import LibraryMedias from './librerie/LibraryMedias.vue'

import {
    gsap
}
from 'gsap/all'

import {
    DebouncedAnimation,
    // LibraryUpload,
}
from './mixins'

export default {
    name: 'LibrerieEsercizi',
    components: {
        BlockContent,
        BlockPanel,
        Container,
        TextEditor,
        TextInput,
        UploadZone,
        UiButton,
        FilePreview,
        LibraryMedias,
    },
    props: {
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
        exercise: {
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
    },
    data: function () {
        return {
            title: null,
            description: null,
            file: null,
            showPreview: false,
            isOpen: false,
            master: null,
            containerState: false,
            dropAnim: null,
        }
    },
    watch: {
        file: function (file) {
            this.toggleAnim()
        },
        clip: {
            handler: function (clip) {
                console.log('clup changed');
            },
        },
        hasFile: function (value) {
            this.toggleDrop()
        }
    },
    computed: {
        hasLibrary: function () {
            if (this.exercise.hasOwnProperty('has_library') && this.exercise.has_library == 1) {
                return true
            }
            return false
        },
        libraryOptions: function () {
            let opts = {}

            if (this.hasLibrary == true) {
                switch (parseInt(this.exercise.library_type_id)) {
                case 1:
                    opts = {
                        type: 'image',

                    }
                    return opts
                case 2:
                    opts = {
                        type: 'audio',
                        accept: 'audio/mp3',
                    }
                    return opts
                case 3:
                    opts = {
                        type: 'video',
                        accept: 'video/mp4',
                    }
                    return opts

                default:
                    return false
                }
            }
            return false
        },
        uploadText: function () {
            if (this.libraryOptions && this.libraryOptions.type != 'audio') {
                return 'Aggiungi un video'
            }
            return 'Aggiungi un file audio'
        },
        isReadyToUpload: function () {
            if (this.libraryOptions && this.libraryOptions.type != 'audio') {
                if (this.title && this.title.length > 0 && this.file != null) {
                    return true
                }
                return false
            }
            else {
                if (this.file != null) {
                    return true
                }
                return false
            }
        },
        uuid: function () {
            return this.$util.uuid()
        },
        hasFile: function () {
            if (this.file) {
                return true
            }

            return false
        }
    },
    methods: {
        toggleDrop: function () {
            if (this.hasFile) {
                gsap.to(this.$refs.drop.$el, .2, {
                    height: 0,
                    autoAlpha: 0,
                    display: 'none'
                })
            }
            else {
                gsap.to(this.$refs.drop.$el, .2, {
                    height: 'auto',
                    autoAlpha: 1,
                    display: 'block'
                })
            }
        },
        initAnim: function () {
            if (this.$refs.drop) {
                let container = this.$refs.drop.$el
                this.master = gsap.timeline({
                    paused: true,
                    yoyo: true,
                })

                this.master.fromTo(container, .15, {
                    height: 0,
                }, {
                    height: 'auto',
                    immediateRender: false,
                    ease: 'power4.inOut',
                }, 'start')

                this.master.progress(1).progress(0)

                this.toggleAnim()
                this.setInitials()
            }
        },
        addMediaToLibrary: function (response) {

        },
        toggleState: function () {
            console.log('deprecata');
        },
        toggleAnim: function () {
            if (this.master) {
                if (this.isOpen == true) {
                    // close
                    this.isOpen = false
                    this.master.reverse()
                }
                else {
                    // apri
                    this.isOpen = true
                    this.master.play()
                }
            }
        },
        addFileToQueue: function (file) {
            this.file = file
        },
        clearFile: function (titleReset = false) {
            if (this.hasLibrary == true) {
                let container = this.$refs.drop
                let dropzone = container.$refs.drop
                dropzone.removeAllFiles()
                this.file = null
                if (titleReset == true) {
                    this.title = null
                    this.description = null
                    if (this.$refs.description) {
                        this.$refs.description.editor.setContent(null)
                    }
                }
            }
        },
        uploadFile: function () {
            let data = new FormData()
            data.append('clip_id', this.clip.id)
            data.append('exercise_id', this.exercise.id)
            data.append('media', this.file)
            data.append('title', this.title)
            data.append('description', this.description)
            data.append('library_type_id', this.exercise.library_type_id)

            if (this.exercise.hasOwnProperty('isNew') && this.exercise.isNew == true) {
                data.append('is_new', 1)
            }
            else {
                // data.append()
                data.append('is_new', 0)
                data.append('library_id', this.exercise.libraries[0].id)
            }


            this.$http.post('/api/v2/admin/clips/libraries/upload', data).then(response => {
                // console.log(response);
                this.$emit('update', response.data)
                this.clearFile(true)
            })
        },
        updateTitle: function (values = arguments) {
            if (values) {
                this.title = values
            }
            else {
                this.title = null
            }
        },
        updateDescription: function (key, values = arguments) {
            let value = values[1]
            this.description = value
        },
        deleted: function (data) {
            this.$emit('saved', data.clip)
        },
        setInitials: function () {

        },
        translate: function (item) {
            this.$emit('translate', item)
        }
    },
    filters: {
        filterInitials: function (initials, exercise) {
            // console.log('filters', initials, exercise);
            let libraries = initials.libraries.filter(library => library.exercise_id == exercise.id)
            return libraries
        }
    },
    mounted: function () {
        this.initAnim()
        // setTimeout(() => {
        //     this.$http.post('/api/v2/admin/clips/libraries/test', {}).then(response => {
        //         console.log(response.data);
        //         this.$emit('update', response.data)
        //         this.clearFile(true)
        //     })
        // }, 1000)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.title-section {
    margin-bottom: $spacer * 1.2;
}

.uploader {
    &__preview {
        margin-top: $spacer * 1.618;
        display: flex;
        justify-content: center;
        width: 100%;

    }

    &__drop {
        overflow: hidden;
    }

    &__btn {
        display: block;
        width: 100%;
        margin-top: $spacer * 1.618;
        text-align: center;
        overflow: hidden;
    }
}

.upload-section-transition-enter-active,
.upload-section-transition-leave-active {
    transition: all 0.2s ease-in-out;
}

.upload-section-transition-enter,
.upload-section-transition-leave-to {
    opacity: 0;
    height: 0;
}
</style>
