const striptags = require('striptags')

const TranslationFilter = {
    filters: {
        translate: function (obj, key, locale) {
            let toClean = false

            if (key == 'title' || key == 'name') {
                toClean = true
            }


            if (obj.hasOwnProperty('translations')) {
                let translations = obj.translations
                let translation = translations.find(item => item.locale == locale)

                if (translation) {
                    if (toClean == true) {
                        return striptags(translation[key])
                    }
                    else {
                        return translation[key]
                    }
                }
                else {
                    if (toClean == true) {
                        return striptags(obj[key])
                    }
                    else {
                        return obj[key]
                    }
                }
            }
            else {
                if (toClean == true) {
                    return striptags(obj[key])
                }
                else {
                    return obj[key]
                }
            }
        }
    }
}

export default TranslationFilter
