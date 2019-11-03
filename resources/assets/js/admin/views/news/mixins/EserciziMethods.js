const EserciziMethods = {
    methods: {
        updateExerc: function (data) {
            let idx = this.exercises.findIndex(exercise => exercise.id == data.exercise.id)
            if (idx > -1) {
                let item = Object.assign({}, this.exercises[idx])
                let libraries = Object.assign([], item.libraries)
                item['isNew'] = false

                let libraryIdx = libraries.findIndex(lib => lib.id == data.library.id)
                if (libraryIdx > -1) {
                    libraries[libraryIdx].medias.push(data.media)
                }
                else {
                    let newLib = data.library
                    newLib.medias = []
                    newLib.medias = [data.media]

                    libraries.push(newLib)
                }

                item['libraries'] = libraries
                this.exercises.splice(idx, 1, item)
            }
        },
        destroyMedia: function (item) {
            let url = '/api/v2/admin/clips/libraries/' + item.id
            this.$http.delete(url).then(response => {
                let exercise = this.exercises.find(exer => {
                    exer.libraries = exer.libraries.map(lib => {
                        let idx = lib.medias.findIndex(media => media.id == item.id)
                        if (idx > -1) {
                            lib.medias.splice(idx, 1)
                        }
                        return lib
                    })
                    return exer
                })
                let idx = this.exercises.indexOf(exercise)
                if (idx > -1) {
                    let newExercise = Object.assign({}, exercise)
                    this.exercises.splice(idx, 1, newExercise)
                }
            })

        },
    },
}

export default EserciziMethods
