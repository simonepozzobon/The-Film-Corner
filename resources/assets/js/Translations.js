class Translations {
    constructor(contents = [], locale = 'en') {
        console.log('traduzioni inizializate')
        this.translations = contents
        this.locale = locale
        this.localized = {}
    }

    get translations() {
        return this._translations
    }

    get locale() {
        return this._locale
    }

    get localized() {
        return this._localized
    }

    set translations(translations) {
        this.localized = translations[this.locale]
        this._translations = translations

        // imposta anche le traduzioni già localizzate
    }

    set locale(locale) {
        this._locale = locale
    }

    set localized(localized) {
        this._localized = localized
    }

    getContent(defaultValue, key, section) {
        let content = this.localized[section].find(content => content[key] == defaultValue)
        if (content) {
            return content[key]
        } else {
            console.error('non c\'è una traduzione')
            return defaultValue
        }
    }
}


// const Translations = {
//     get: (globalData, itemToTranslate, valueToTranslate, ref) => {
//         let translations = globalData[itemToTranslate]
//         let idx = translations.findIndex(translation => translation[ref] == valueToTranslate)
//         if (idx > -1) {
//             return translations[idx]
//         }
//         else {
//             return {}
//         }
//     }
// }

export default Translations
