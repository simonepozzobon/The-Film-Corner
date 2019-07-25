const Utility = {
    hexToRgbA: function(hex) {
        let c
        let uppercase_hex = hex.toUpperCase().trim()
        if(/^#[0-9A-F]{3,6}$/.test(uppercase_hex)){
            c= uppercase_hex.substring(1).split('')
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]]
            }
            c= '0x'+c.join('')
            let obj = {
                rgba: 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',1)',
                r: (c>>16)&255,
                g: (c>>8)&255,
                a: c&255
            }
            return obj
        }
        throw new Error('Bad Hex')

    },
    uuid: function() {
        // https://gist.github.com/6174/6062387
        return [...Array(10)].map(i=>(~~(Math.random()*36)).toString(36)).join('')
    },
    clone: function(Obj) {
        let buf;
        if (Obj instanceof Array) {
            buf = []; // create an empty array
            let i = Obj.length;
            while (i --) {
                buf[i] = clone(Obj[i]); // recursively clone the elements
            }
            return buf;
        } else if (Obj instanceof Object) {
            buf = {}; // create an empty object
            for (let k in Obj) {
                buf[k] = clone(Obj[k]); // recursively clone the value
            }
            return buf;
        } else {
            return Obj;
        }
    },
    capitalize: function(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
    },
}

export default Utility
