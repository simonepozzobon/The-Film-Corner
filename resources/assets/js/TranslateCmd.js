const striptags = require('striptags')

const TranslateCmd = {
    methods: {
        getCmd: function (key) {
            let result,
                obj = this.$root.generalTexts.find(item => item.field == key)

            if (obj) {
                let value = obj.translations.find(item => item.locale == this.$root.locale)
                if (value) {
                    result = value.description
                }
                else {
                    result = obj.description
                }
            }
            else {
                result = key
            }

            return striptags(result)
        }
    },
}

export default TranslateCmd
