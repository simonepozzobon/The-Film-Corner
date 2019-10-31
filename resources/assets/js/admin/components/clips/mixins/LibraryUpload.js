const LibraryUpload = {
    methods: {
        uploadFile: function () {
            let data = new FormData()
            data.append('clip_id', this.clip.id)
            data.append('exercise_id', this.exercise.id)
            data.append('media', this.file)
            data.append('title', this.title)
            data.append('is_new', this.exercise.hasOwnProperty('isNew') && this.exercise.isNew == true ? true : false)
            data.append('library_type_id', this.exercise.library_type_id)


            this.$http.post('/api/v2/admin/clips/libraries/upload', data).then(response => {
                this.clearFile(true)
            })
        },
    }
}

export default LibraryUpload
