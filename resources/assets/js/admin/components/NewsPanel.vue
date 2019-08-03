<template>
<container
    ref="container"
    class="admin-panel"
>
    <div class="form">
        <text-input
            label="Titolo"
            name="title"
            placeholder="Inserisci un titolo..."
            :value.sync="form.title"
        />
        <text-input
            label="Slug"
            name="slug"
            placeholder="La parte finale dell'url..."
            :value.sync="form.slug"
        />
    </div>
</container>
</template>

<script>
import {
    Container,
    TextInput,
}
from '../adminui'

export default {
    name: 'NewsPanel',
    components: {
        Container,
        TextInput,
    },
    data: function () {
        return {
            form: {
                title: null,
            }
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
