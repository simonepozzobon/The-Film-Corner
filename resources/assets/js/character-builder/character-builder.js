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
            canvasHeight: 1000,
            selectable: false,
        }
    },
    watch: {
        previewWidth: function(width) {
            this.setCanvasSize(width)
        }
    },
    methods: {
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

            // creo i gruppi per le varie librerie
            for (var i = 0; i < this.libraries.length; i++) {
                let group = new fabric.Group()
                group.set({
                    selectable: this.selectable
                })
                this.canvas.add(group)
                this.groups.push(group)
            }
        },
        setCanvasSize: function(width) {
            if (this.canvas) {
                let scaleFactor = width / 1000
                this.canvas.setWidth(width)
                this.canvas.setHeight(width)

                // set zoom for resizing
                this.canvas.setZoom(scaleFactor)
                this.canvas.calcOffset()
                this.canvas.renderAll()
            }
        },
        addToCanvas: function(src, libraryIdx) {
            // trovo a quale libreria appartiene l'oggetto che sto aggiungendo
            let idx = this.libraries.findIndex(library => library.id == libraryIdx)

            let objs = this.groups[idx].getObjects()
            for (var i = 0; i < objs.length; i++) {
                this.canvas.remove(objs[i])
            }


            if (idx > -1) {
                // creo l'istanza dell'immagine
                let image = new fabric.Image.fromURL(src, (obj, opts) => {
                    // Aggiungo l'immagine al gruppo
                    obj.set({
                        selectable: this.selectable,
                        centeredScaling: true,
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
                        }
                    } else {
                        // calcolo l'altezza del singolo elemento considerando la scala
                        let height = this.canvasHeight / (this.groups.length - 1)
                        scaleFactor = scaleFactor / (this.groups.length - 1)

                        this.groups[idx].set({
                            centeredScaling: true,
                            scaleX: scaleFactor,
                            scaleY: scaleFactor,
                        })

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
