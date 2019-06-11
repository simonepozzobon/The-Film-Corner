const SharedData = {
    app: null,
    assets: {
        hasSubLibraries: false,
        items: [],
        type: 'images'
    },
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
    getData: function(token = null) {
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

        if (token) {
            url = '/api/v2/load-assets/' + slug + '/' + token
            console.log(url);
        }

        this.$http.get(url).then(response => {
            console.log('caricata')
            // console.dir(response.data);
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
        if (Boolean(this.session.is_empty)) {
            this.$http.delete('/api/v2/session/' + this.session.token + '/true')
        }
        this.$nextTick(() => {
            this.$root.session = null
        })
    },
    debug: function(slug, token) {
        console.log('debug');
        let url = '/api/v2/get-app/' + slug
        this.$http.get(url)
            .then(response => {
                if (response.data.success && response.data.sessions.length > 0) {
                    let session = response.data.sessions.find(session => session.token === token)
                    if (session) {
                        session.content = JSON.parse(session.content)
                        this.session = session
                        this.$nextTick(() => {
                            this.init()
                        })
                    }
                }
            })
    }
}

export {
    SharedData,
    SharedMethods,
    SharedWatch,
}
