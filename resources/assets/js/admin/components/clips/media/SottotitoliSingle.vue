<template>
<div class="caption-single w-100 my-2 d-flex">
    <div>{{ cap.src }}</div>
    <div>{{ cap.locale }}</div>
    <div class="caption-single__btn">
        <ui-button
            title="Elimina"
            color="red"
            theme="outline"
            :has-margin="false"
            :has-container="false"
            @click="destroy"
        />
    </div>
</div>
</template>

<script>
import {
    UiButton,
    UiTitle,
}
from '../../../../ui'

export default {
    name: 'SottotitoliSingle',
    components: {
        UiButton,
    },
    props: {
        cap: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    methods: {
        destroy: function () {
            let data = new FormData()
            data.append('id', this.cap.id)

            this.$http.post('/api/v2/admin/clips/libraries/captions/destroy', data).then(response => {
                this.$emit('deleted', {
                    id: response.data.id,
                    clip: response.data.clip,
                })
            })
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.caption-single {
    border-bottom: 1px solid $custom-control-label-disabled-color;
    padding-top: $spacer * 1.618;
    padding-bottom: $spacer * 1.618;
    justify-content: space-between;

}
</style>
