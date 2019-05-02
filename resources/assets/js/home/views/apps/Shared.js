const SharedData = {
    app: null,
    assets: null,
    session: null,
    notes: null,
    size: { w: 0, h: 0 },
}

const SharedMethods = {
    uniqid: function() {
        let ts=String(new Date().getTime()), i = 0, out = ''
        for(i=0;i<ts.length;i+=2) {
            out+=Number(ts.substr(i, 2)).toString(36)
        }
        return ('d'+out)
    },
    getData: function() {

        // pulisce la sessione se non è stata salvata
        window.addEventListener('beforeunload', () => {
            this.deleteEmptySession()
        })

        let slug = this.$route.name
        this.$http.get('/api/v2/load-assets/' + slug).then(response => {
            console.dir(response.data);
            if (response.data.success) {
                this.app = response.data.app
                this.assets = response.data.assets
                this.session = response.data.session
                this.$nextTick(this.init)
            }
        })
    },
    deleteEmptySession: function() {
        // verificare se è vuota
        if (Boolean(this.session.is_empty)) {
            this.$http.delete('/api/v2/session/' + this.session.token)
        }
    },
}

export {
    SharedData,
    SharedMethods,
}
