<template>
<div
    ref="container"
    class="f-preview"
>
    <div class="f-preview__icon f-preview__col">
        <file-icon class="f-preview__svg" />
    </div>
    <div class="f-preview__name f-preview__col">
        {{ fileName }}
    </div>
    <div class="f-preview__tools f-preview__col">
        <ui-button
            title="rimuovi"
            color="red"
            theme="outline"
            :has-container="false"
            :has-margin="false"
            align="center"
            @click="clearFile"
        />
    </div>
</div>
</template>

<script>
import {
    FileIcon,
}
from '../../../../icons'

import {
    UiButton,
}
from '../../../../ui'

import {
    gsap
}
from 'gsap/all'

import {
    DebouncedAnimation,
}
from '../mixins'

export default {
    name: 'FilePreview',
    components: {
        FileIcon,
        UiButton,
    },
    mixins: [DebouncedAnimation],
    props: {
        file: {
            default: null
        },
    },
    data: function () {
        return {
            master: null,
            isOpen: true,
        }
    },
    watch: {
        file: function (file) {
            if (this.file) {
                this.toggleState()
            }
            else {
                this.toggleState()

            }
        },
    },
    computed: {
        fileName: function () {
            if (this.file) {
                return this.file.name
            }
            return 'no-file'
        },
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .6, {
                height: 0
            }, {
                height: 'auto'
            }, 'start')

            this.master.progress(1).progress(0)

            this.toggleState()
        },
        toggleState: function () {
            if (this.master) {
                if (this.isOpen == true) {
                    // close
                    this.debouncedEvent('add-anim', this.master, false, this.uuid, () => {
                        this.isOpen = false
                    })
                }
                else {
                    // apri
                    this.debouncedEvent('add-anim', this.master, true, this.uuid, () => {
                        this.isOpen = true
                    })
                }
            }
        },
        clearFile: function () {
            this.file = null
            let container = this.$refs.drop
            let dropzone = container.$refs.drop
            dropzone.removeAllFiles()
        }
    },
    mounted: function () {
        this.initAnim()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
.f-preview {
    &__svg .ui-icon__path {
        fill: darken($gray-100, 50);
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
.f-preview {
    padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) 0;
    margin-top: $spacer * 1.618;
    display: flex;
    justify-content: center;
    width: 100%;

    &__col {
        overflow: hidden;

        & + & {
            margin-left: $spacer * 2;
        }
    }
}
</style>
