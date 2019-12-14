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

export default {
    name: 'FilePreview',
    components: {
        FileIcon,
        UiButton,
    },
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
            this.toggleAnim()
        },
    },
    computed: {
        fileName: function () {
            if (this.file) {
                return this.file.name
            }
            return 'no-file'
        },
        uuid: function () {
            return this.$util.uuid()
        },
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.fromTo(container, .15, {
                height: '1px',
            }, {
                height: 'auto',
                immediateRender: false,
                ease: 'power4.inOut',
            }, 'start')

            this.master.fromTo(container, .15, {
                marginTop: '0',
            }, {
                marginTop: '1.618rem',
                immediateRender: false,
                ease: 'power4.inOut',
            }, 'start+=0.1')

            this.master.progress(1).progress(0)

            this.toggleAnim()
        },
        toggleState: function () {
            console.log('deprecata');
        },
        toggleAnim: function () {
            if (this.master) {
                if (this.file) {
                    // apri
                    this.master.play()
                }
                else {
                    // close
                    this.master.reverse()
                }
            }
        },
        clearFile: function () {
            this.$emit('clear')
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
