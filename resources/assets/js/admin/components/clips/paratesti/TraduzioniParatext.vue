<template>
<div
    ref="modal"
    class="modal fade translate"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
    >
        <div class="modal-content translate__content">
            <div class="modal-body translate__body">
                <container
                    :contains="false"
                    :top-margin="false"
                    padding="no"
                    :has-animations="false"
                    :no-parent="true"
                >
                    <block-panel
                        ref="panel"
                        title="Traduci contenuto"
                        title-size="h4"
                        :has-animations="false"
                        :has-footer="true"
                    >
                        <text-editor
                            ref="it"
                            label="Italiano"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('it')"
                            @update="update('it', arguments)"
                        />

                        <text-editor
                            ref="en"
                            label="English"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('en')"
                            @update="update('it', arguments)"
                        />

                        <text-editor
                            ref="fr"
                            label="Francais"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('fr')"
                            @update="update('it', arguments)"
                        />

                        <text-editor
                            ref="sr"
                            label="Serbian"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('sr')"
                            @update="update('it', arguments)"
                        />
                        <text-editor
                            ref="ka"
                            label="Georgiano"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('ka')"
                            @update="update('it', arguments)"
                        />
                        <text-editor
                            ref="sl"
                            label="Slovenian"
                            :has-animation="true"
                            min-height="100px"
                            @ready="editorReady('sl')"
                            @update="update('it', arguments)"
                        />

                        <template v-slot:footer>
                            <ui-button
                                title="salva"
                                color="green"
                                theme="outline"
                                :has-margin="false"
                                :has-container="false"
                            />
                        </template>
                    </block-panel>
                </container>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- <b-modal
    ref="modal"
    title="Traduzioni"
    hide-footer
    hide-header
    size="xl"
    modal-class="translate"
    body-class="translate__body"
    content-class="translate__content"
>

</b-modal> -->
</template>

<script>
import {
    BlockPanel,
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    PanelTitle,
    Select2Input,
    UploadZone,
}
from '../../../adminui'



import {
    UiButton,
    UiTitle,
}
from '../../../../ui'
export default {
    name: 'TraduzioniParatext',
    components: {
        BlockPanel,
        Container,
        TextEditor,
        UiTitle,
        UploadZone,
        PanelTitle,
        UiButton,
    },
    data: function () {
        return {
            item: null,
            values: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null,
            },
        }
    },
    methods: {
        show: function (item) {
            this.setItem(item).then(() => {
                $(this.$refs.modal).modal('toggle')
            })
        },
        setItem: function (item) {
            return new Promise((resolve, reject) => {
                console.log(item);
                this.item = item
            });
        },
        update: function (key, values = arguments) {
            let value = values[1]
            this.values[key] = value
        },
        editorReady: function (key) {},
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.translate {
    z-index: 9999;

    &__content {
        background-color: transparent;
        box-shadow: none;
        border: none;
    }
}
</style>
