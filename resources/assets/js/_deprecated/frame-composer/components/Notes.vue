<template>
    <div class="row mt">
        <div class="col">
            <div class="box green">
                <div class="box-header">
                {{ notes }}
                </div>
                <div class="box-body">
                    <textarea id="notes" name="notes" rows="8" class="form-control" :placeholder="character_builder_desc"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Notes',
    props: {
        notes: {
            type: String,
            default: '',
        },
        character_builder_desc: {
            type: String,
            default: '',
        }
    }
}
</script>

<style lang="css">
</style>
