<template lang="html">
    <ui-row :no-gutters="true">
        <ui-block :size="12">
            <div class="ui-app-note">
                <ui-title :title="title" :has-padding="false"/>
                <div class="ui-app-note__field">
                    <textarea
                        name="name"
                        rows="8"
                        cols="80"
                        class="form-control ui-app-note__text"
                        v-model="notes">
                    </textarea>
                </div>
            </div>
        </ui-block>
    </ui-row>
</template>

<script>
import { UiBlock, UiTitle, UiRow } from '../ui'
export default {
    name: 'UiAppNote',
    components: {
        UiBlock,
        UiTitle,
        UiRow,
    },
    props: {
        title: {
            type: String,
            default: 'Notes',
        },
    },
    data: function() {
        return {
            notes: null
        }
    },
    watch: {
        'notes': function(notes) {
            this.$emit('changed', notes)
        }
    },

}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-note {
    width: 100%;
    height: 100%;
    background-color: $green;
    @include border-radius($custom-border-radius);
    @include app-block-padding;

    &__text {
        @include border-radius(10px);
    }
}
</style>
