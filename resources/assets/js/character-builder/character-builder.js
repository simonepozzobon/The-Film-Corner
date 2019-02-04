import Vue from 'vue'
import {fabric} from 'fabric'
import CharacterBuilder from './components/CharacterBuilder.vue'

const character = new Vue({
    el: '#character-builder',
    components: {
        CharacterBuilder,
    },
    data: function() {
        return {
            canvas: null,
            images: [],
            window: { w: 0, h: 0 },
            previewWidth: 0,
            previewHeight: 0,
            libraries: null,
            groups: [],
            canvasWidth: 1000,
            canvasHeight: 562,
            selectable: false,
            session: null,
            initialized: false,
        }
    },
    watch: {
        previewWidth: function(width) {
            this.setCanvasSize(width)
        },
    },
    methods: {
        randomColor: function() {
            let letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        loadFromJSON: function() {
            for (let i = 0; i < this.session.objects.length; i++) {
                let objs = this.session.objects[i].objects
                for (let j = 0; j < objs.length; j++) {
                    this.addToCanvas(objs[j].src, i)
                }
            }
            this.initialized = true
        },
        getSize: function() {
            this.window = {
                h: window.innerHeight,
                w: window.innerWidth,
            }
        },
        init: function() {
            this.canvas = new fabric.Canvas('image-editor', {
                backgroundColor: '#f3f3f3'
            })
            this.canvas.setWidth(this.canvasWidth)
            this.canvas.setHeight(this.canvasHeight)
            this.$emit('trigger-resize')

            // creo i gruppi per le varie librerie
            for (let i = 0; i < this.libraries.length; i++) {
                let group = new fabric.Group()
                group.set({
                    selectable: this.selectable,
                })
                this.canvas.add(group)
                this.groups.push(group)
            }

            if (this.session) {
                this.loadFromJSON()
            }
        },
        setCanvasSize: function(width) {
            if (this.canvas) {
                let scaleFactor = width / this.canvasWidth
                this.canvas.setWidth(this.canvasWidth * scaleFactor)
                this.canvas.setHeight(this.canvasHeight * scaleFactor)

                // set zoom for resizing
                this.canvas.setZoom(scaleFactor)
                this.canvas.calcOffset()
                this.canvas.renderAll()
            }
        },
        addToCanvas: function(src, libraryIdx) {
            // trovo a quale libreria appartiene l'oggetto che sto aggiungendo
            let idx = this.libraries.findIndex(library => library.id == libraryIdx)
            if (this.session && !this.initialized) {
                idx = libraryIdx
            }
            if (idx > -1) {
                // rimuove gli oggetti già inseriti nel gruppo
                let objs = this.groups[idx].getObjects()
                for (let i = 0; i < objs.length; i++) {
                    this.groups[idx].remove(objs[i])
                }

                // creo l'istanza dell'immagine
                let image = new fabric.Image.fromURL(src, (obj, opts) => {
                    // Aggiungo l'immagine al gruppo
                    obj.set({
                        selectable: this.selectable,
                        centeredScaling: true,
                        originX: 'center',
                    })
                    this.groups[idx].addWithUpdate(obj)

                    // calcolo il fattore di scala
                    let width = this.groups[idx].getScaledWidth()
                    let scaleFactor = this.canvasWidth / width

                    // se è la prima libreria (landscape)
                    if (idx == 0)  {
                        // scalo il gruppo per farlo stare interno al canvas
                        if (width > this.canvasWidth) {
                            this.groups[idx].set({
                                scaleX: scaleFactor,
                                scaleY: scaleFactor,
                            })

                            width = this.groups[idx].getScaledWidth()
                            let canvasW = this.canvas.getWidth()
                        }

                        // se il canvas non viene riempito anche in altezza ridimensiona lo sfondo
                        // per coprire tutto lo spazio
                        let height = this.groups[idx].getScaledHeight()
                        if (height < this.canvasHeight) {
                            scaleFactor = this.canvasHeight / height

                            this.groups[idx].set({
                                scaleX: scaleFactor,
                                scaleY: scaleFactor,
                            })
                        }

                        // centra lo sfondo
                        this.groups[idx].centerH()
                        this.groups[idx].set({
                            left: 0,
                        })
                        this.groups[idx].setCoords()

                        // this.groups[idx].centerH()
                    } else {
                        // calcolo l'altezza del singolo elemento considerando la scala
                        let height = this.canvasHeight / (this.groups.length - 1)
                        scaleFactor = scaleFactor / (this.groups.length - 1)


                        this.groups[idx].set({
                            centeredScaling: true,
                            scaleX: scaleFactor,
                            scaleY: scaleFactor,
                        })

                        let objHeight = obj.getScaledHeight() * scaleFactor

                        if (height < objHeight) {
                            let objScale = height / objHeight
                            obj.set({
                                scaleX: objScale,
                                scaleY: objScale,
                            })
                        }


                        // calcolo la sua posizione sempre in base alla scala
                        let width = this.groups[idx].getScaledWidth()
                        let top = (height * idx) - height
                        let left = (this.canvasWidth / 2) - (width / 2)

                        this.groups[idx].set({
                            top: top,
                            left: left,
                        })
                        this.groups[idx].setCoords()
                    }

                    this.canvas.calcOffset()
                    this.canvas.renderAll()
                })
            }
            this.canvas.calcOffset()
            this.canvas.renderAll()

            this.$nextTick(() => {
                this.saveCanvas()
            })
        },
        saveCanvas: function() {
            console.log('salva canvas')
            // Save canvas to JSON for future edit
            let json_data = JSON.stringify(this.canvas.toDatalessJSON())
            localStorage.setItem('app-13-json', json_data)

            // Save image to local storage
            localStorage.setItem('app-13-image', this.canvas.toDataURL('png'))
        }
    },
    mounted: function() {
        this.getSize()
        this.init()

        window.addEventListener('resize', () => {
            this.getSize()
        })

        this.$on('add-to-canvas', (src, libraryIdx) => {
            this.addToCanvas(src, libraryIdx)
        })
    }
})
