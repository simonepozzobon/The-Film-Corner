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

    }
}

export default Utility
