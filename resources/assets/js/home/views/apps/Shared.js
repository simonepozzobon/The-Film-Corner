const SharedData = {
    app: null,
    assets: null,
    session: null,
    notes: null,
    size: { w: 0, h: 0 },
}

const SharedMethods = {
    uinqid: function() {
        let ts=String(new Date().getTime()), i = 0, out = ''
        for(i=0;i<ts.length;i+=2) {
            out+=Number(ts.substr(i, 2)).toString(36)
        }
        return ('d'+out)
    },
    getData: function() {
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
        console.log(this.session);
    },
}

export {
    SharedData,
    SharedMethods,
}
