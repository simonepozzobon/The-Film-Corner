const LibraryUpload = {
    methods: {
        uploadFile: function () {
            let data = new FormData()
            data.append('clip_id', this.clip.id)
            data.append('exercise_id', this.exercise.id)
            data.append('file', this.file)
            data.append('title', this.title)


            this.$http.post('/api/v2/admin/clips/libraries/upload', data).then(response => {
                console.log(response);
            })
        },
    }
}

export default LibraryUpload
