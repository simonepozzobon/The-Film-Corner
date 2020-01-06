<template>
<div class="file-input">
    <div class="form-group">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input
                    ref="file"
                    type="file"
                    class="custom-file-input"
                    :accept="accept"
                    :id="name"
                    @change="previewFile"
                />

                <label
                    class="custom-file-label"
                    :for="name"
                    aria-describedby="inputGroupFileAddon02"
                >
                    {{ this.$root.getCmd('select_file') }}
                </label>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'FileInput',
    props: {
        label: {
            type: String,
            default: 'File',
        },
        name: {
            type: String,
            default: 'fileinput',
        },
        accept: {
            type: String,
            default: 'video/*',
        },
    },
    data: function () {
        return {
            file: null,
            src: null,
        }
    },
    methods: {
        previewFile: function () {
            this.file = this.$refs.file.files[0]
            this.$emit('update', this.file)
        },
        reset: function () {
            this.$refs.file.value = ''
            this.file = null
            this.src = null
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
