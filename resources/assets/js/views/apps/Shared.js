const SharedData = {
    app: null,
    assets: null,
    session: null,
    notes: null,
    size: { w: 0, h: 0 },
    color: 'green',
}

const SharedWatch = {
    'app': function(app) {
        this.color = app.category.section.color_class
    },
    'session': function(session) {
        this.$root.session = session
    }
}

const SharedMethods = {
    uniqid: function() {
        let ts=String(new Date().getTime()), i = 0, out = ''
        for(i=0;i<ts.length;i+=2) {
            out+=Number(ts.substr(i, 2)).toString(36)
        }
        return ('d'+out)
    },
    uniqidSimple: function() {
        return '_' + Math.random().toString(36).substr(2, 9)
    },
    getData: function() {
        // pulisce la sessione se non è stata salvata
        window.addEventListener('beforeunload', () => {
            try {
                this.deleteEmptySession()
            } catch (e) {

            } finally {

            }
        })

        let slug = this.$route.name
        let url = '/api/v2/load-assets/' + slug

        if (this.$root.session) {
            url = '/api/v2/load-assets/' + slug + '/' + this.$root.session.token
        }

        this.$http.get(url).then(response => {
            console.dir(response.data);
            if (response.data.success) {
                this.app = response.data.app
                this.assets = response.data.assets
                let session = response.data.session
                session.content = JSON.parse(session.content)

                this.session = session

                this.$nextTick(this.init)
            }
        })

    },
    deleteEmptySession: function() {
        // verificare se è vuota
        this.$root.session = null
        if (Boolean(this.session.is_empty)) {
            this.$http.delete('/api/v2/session/' + this.session.token + '/true')
        }
    },
}

export {
    SharedData,
    SharedMethods,
    SharedWatch,
}
