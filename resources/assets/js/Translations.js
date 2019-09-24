class Translations {
    constructor(translations) {
        console.log('traduzioni inizializate');
        this.translations = translations
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
