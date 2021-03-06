const elementResizeEvent = require('element-resize-event')

const debounce = require('lodash.debounce')

const Utility = {
    hexToRgbA: function (hex) {
        let c
        let uppercase_hex = hex.toUpperCase().trim()
        if (/^#[0-9A-F]{3,6}$/.test(uppercase_hex)) {
            c = uppercase_hex.substring(1).split('')
            if (c.length == 3) {
                c = [c[0], c[0], c[1], c[1], c[2], c[2]]
            }
            c = '0x' + c.join('')
            let obj = {
                rgba: 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',1)',
                r: (c >> 16) & 255,
                g: (c >> 8) & 255,
                a: c & 255
            }
            return obj
        }
        throw new Error('Bad Hex')

    },
    isFunction: function (functionToCheck) {
        return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
    },
    uuid: function () {
        // https://gist.github.com/6174/6062387
        return [...Array(10)].map(i => (~~(Math.random() * 36)).toString(36)).join('')
    },
    clone: function (Obj) {
        let buf;
        if (Obj instanceof Array) {
            buf = []; // create an empty array
            let i = Obj.length;
            while (i--) {
                buf[i] = clone(Obj[i]); // recursively clone the elements
            }
            return buf;
        }
        else if (Obj instanceof Object) {
            buf = {}; // create an empty object
            for (let k in Obj) {
                buf[k] = clone(Obj[k]); // recursively clone the value
            }
            return buf;
        }
        else {
            return Obj;
        }
    },
    capitalize: function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    },
    createBlobFromData: function (dataUri = null) {
        if (dataUri) {
            // https://github.com/videojs/video.js/issues/4630
            let data = dataUri.split(',')[1]

            let mimeType = dataUri.split(';')[0].slice(5)

            let bytes = window.atob(data)
            let buf = new ArrayBuffer(bytes.length)
            let arr = new Uint8Array(buf)

            for (let i = 0; i < bytes.length; i++) {
                arr[i] = bytes.charCodeAt(i)
            }

            let blob = new Blob([arr], {
                type: mimeType
            });

            return blob
        }
        else {
            return false
        }
    },
    emitEvent: function (name, ...args) {

    },
    onResizeListener: function (el, callback = null) {
        elementResizeEvent(el, () => {
            if (this.isFunction(callback)) {
                this.debounceCallback(el, callback)
            }
            else {
                console.log('no callback');
                return {
                    el: el,
                    callback: null,
                }
            }
        })
    },
    debounceCallback: debounce((el, callback) => {
        callback(el)
    }, 500),
    isEqual: require('lodash.isequal'),
    debounce: debounce,
    random: function (min, max) {
        if (min >= 0 && max > 0) {
            return Math.random() * (max - min) + min
        }
        else {
            return Math.random()
        }
    },
    randomFromArr: function (length) {
        // https://stackoverflow.com/questions/4550505/getting-a-random-value-from-a-javascript-array
        return Math.floor(Math.random() * length)
    }
}

export default Utility
