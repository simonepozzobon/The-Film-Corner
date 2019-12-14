const TranslationFilter = {
    translate: function (obj, key, locale) {
        if (obj.hasOwnProperty('translations')) {
            let translations = obj.translations
            let translation = translations.find(item => item.locale == locale)
            if (translation) {
                return translation[key]
            }
            else {
                return obj[key]
            }
        }
        else {
            return obj[key]
        }
    }
}

export default TranslationFilter
