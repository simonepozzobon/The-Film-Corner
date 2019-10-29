<template>
<div class="admin-home">
    <container>
        <block-panel title="test">
            <div
                class="para-single"
                ref="container"
            >
                <div
                    class="para-single__content"
                    ref="element"
                >
                    <panel-title
                        title="Paintings"
                        size="h4"
                        class="para-single__sub-title"
                        letter-spacing="6px"
                    />
                    <upload-zone
                        :accept="mime"
                        url="/api/v2/admin/clips/paratexts/upload"
                        :params.sync="requestParams"
                    />
                </div>
            </div>
        </block-panel>
    </container>
</div>
</template>

<script>
import {
    BlockPanel,
    Container,
    PanelTitle,
    UploadZone,
}
from '../adminui'

export default {
    name: 'Testing',
    components: {
        BlockPanel,
        Container,
        PanelTitle,
        UploadZone,
    },
    data: function () {
        return {
            mime: 'image/*',
            requestParams: {
                clip_id: 1,
                paratext_type_id: 1,
                content: '',
            }
        }
    },
    mounted: function () {
        console.log('home');
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
.para-single {
    &__sub-title {
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-single {
    margin-bottom: $spacer * 2.5;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    &__content {
        @include custom-box-shadow($darken, 2px, 0.02);
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
    }
}
</style>
