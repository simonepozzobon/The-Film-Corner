import Vue from 'vue'
import {fabric} from 'fabric'
import FrameComposer from './components/FrameComposer.vue'

fabric.Object.prototype.toObject = (function (toObject) {
    return function (propertiesToInclude) {
        propertiesToInclude = (propertiesToInclude || []).concat(
          ['originalObj','libraryIdx']
        );
        return toObject.apply(this, [propertiesToInclude]);
    };
})(fabric.Object.prototype.toObject);


const character = new Vue({
    el: '#frame-composer',
    components: {
        FrameComposer,
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
            selectable: true,
            session: null,
            initialized: false,
            gutter: 20,
            objs: [],
            landscape: null
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
                let objs = this.session.objects[i]
                if (objs.objects) {
                    // è uno sfondo
                    for (let j = 0; j < objs.objects.length; j++) {
                        let obj = objs.objects[j]
                        this.addToCanvas(obj.originalObj, obj.libraryIdx, true)
                    }
                } else {
                    // è un'immagine
                    let obj = objs
                    this.addToCanvas(obj, obj.libraryIdx, true, true)
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
                backgroundColor: '#f3f3f3',
                centeredScaling: true,
            })
            this.canvas.setWidth(this.canvasWidth)
            this.canvas.setHeight(this.canvasHeight)
            this.$emit('trigger-resize')

            this.landscape = new fabric.Group()
            this.landscape.set({
                selectable: false
            })
            this.canvas.add(this.landscape)

            this.addListeners()

            if (this.session) {
                this.loadFromJSON()
            }
        },
        addListeners: function() {
            this.addListener(this.landscape)
            this.addListener(this.canvas)
        },
        addListener: function(obj) {
            let events = [ 'object:added', 'object:removed', 'object:modified', 'object:rotating', 'object:scaling', 'object:moving' ]
            for (let j = 0; j < events.length; j++) {
                obj.on(events[j], () => {
                    // console.log('triggered ', events[j])
                    this.saveCanvas()
                })
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
        addToCanvas: function(item, libraryIdx, isID = false, isImage = false) {
            // cerca l'indice di appartenenza alla libreria -> se è uno sfondo
            let idx = 0
            if (!isID) {
                idx = this.libraries.findIndex(library => library.id == libraryIdx)
            } else {
                idx = libraryIdx
            }

            // formatta l'url
            let url = ''
            if (isImage) {
                url = item.src
            } else {
                url = '/storage/' + item.src
            }

            // crea l'istanza di FabricJs
            let image = new fabric.Image.fromURL(url, (obj, opts) => {
                if (isImage) {
                    // Object from session JSON
                    obj.set(item)
                    this.objs.push(obj)
                    this.addListener(obj)
                    this.canvas.add(obj)
                } else {
                    // new Object
                    obj.set({
                        selectable: this.selectable,
                        centeredScaling: true,
                        originX: 'center',
                        originalObj: item,
                        libraryIdx: idx
                    })

                    // se non si tratta di uno sfondo
                    if (idx > 0) {

                        obj.set({
                            originY: 'center',
                        })

                        let width = this.canvas.getWidth()
                        let height = this.canvas.getHeight()
                        let objWidth = obj.getScaledWidth()
                        let objHeight = obj.getScaledHeight()
                        let scaleFactor = this.canvasWidth / objWidth

                        if (objWidth > width || objHeight > height) {
                            if (objWidth > width) {
                                if (scaleFactor < 1) {
                                    obj.set({
                                        scaleX: scaleFactor,
                                        scaleY: scaleFactor,
                                    })
                                }
                            }

                            objHeight = obj.getScaledHeight()
                            if (objHeight > height) {
                                scaleFactor = (height * scaleFactor) / objHeight
                                if (scaleFactor < 1) {
                                    obj.set({
                                        scaleX: scaleFactor,
                                        scaleY: scaleFactor,
                                    })
                                }
                            }
                        }

                        obj.setCoords()
                        this.objs.push(obj)
                        this.addListener(obj)
                        this.canvas.add(obj)

                        // force center
                        obj.viewportCenter()
                    } else if (idx == 0) {
                        let items = this.landscape.getObjects()
                        for (let i = 0; i < items.length; i++) {
                            this.landscape.removeWithUpdate(items[i])
                        }

                        this.landscape.addWithUpdate(obj)
                        let width = this.landscape.getScaledWidth()
                        let scaleFactor = this.canvasWidth / width
                        if (width > this.canvasWidth) {
                            this.landscape.set({
                                scaleX: scaleFactor,
                                scaleY: scaleFactor,
                            })
                        }

                        // se il canvas non viene riempito anche in altezza ridimensiona lo sfondo
                        // per coprire tutto lo spazio
                        let height = this.landscape.getScaledHeight()

                        if (height < this.canvasHeight) {
                            scaleFactor = this.canvasHeight / height

                            this.landscape.set({
                                scaleX: scaleFactor,
                                scaleY: scaleFactor,
                            })
                        }

                        // centra lo sfondo
                        this.landscape.centerH()
                        this.landscape.set({
                            left: 0,
                        })
                        this.landscape.setCoords()
                    }
                }
            })
            this.canvas.calcOffset()
            this.canvas.renderAll()
            this.saveCanvas()
        },
        saveCanvas: function() {
            // Save canvas to JSON for future edit
            let json_data = JSON.stringify(this.canvas.toDatalessJSON())
            localStorage.setItem('app-1-json', json_data)
            // this.debugSave(json_data)

            // Save image to local storage
            localStorage.setItem('app-1-image', this.canvas.toDataURL('png'))
        },
        debugSave: function(data) {
            data = JSON.parse(data)
            for (let i = 0; i < data.objects.length; i++) {
                let objs = data.objects[i]
                console.log(objs)
            }
        }
    },
    mounted: function() {
        this.getSize()
        this.init()

        window.addEventListener('resize', () => {
            this.getSize()
        })

        this.$on('add-to-canvas', (obj, libraryIdx) => {
            this.addToCanvas(obj, libraryIdx)
        })
    }
})
