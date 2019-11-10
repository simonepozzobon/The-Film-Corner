<template>
<app-template :app="app">
    <template slot="left">
        <ui-app-preview
            ref="preview"
            title="Character"
        />
    </template>
    <template
        slot="right"
        v-if="this.assets"
    >
        <ui-app-library
            :hasSubLibraries="assets.hasSubLibraries"
            :type="assets.type"
            :items="assets.library"
            @selected="selected"
        />
    </template>
    <template>
        <ui-app-layers
            ref="layers"
            :layers="objs"
            @select-layer="selectLayer"
            @delete-layer="deleteLayer"
        />
        <ui-app-note
            class="mt-4"
            @changed="setNotes"
            :initial="notes"
        />
    </template>
</app-template>
</template>

<script>
import {
    fabric
}
from 'fabric'
import AppTemplate from './AppTemplate.vue'
import SizeUtility from '../../Sizes'
import {
    UiAppLayers,
    UiAppLibrary,
    UiAppNote,
    UiAppPreview,
}
from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
}
from './Shared'
import _ from 'lodash'

import {
    TweenMax,
    ScrollToPlugin
}
from 'gsap/all'

const plugins = [
    ScrollToPlugin
]

import TranslationFilter from '../../TranslationFilter'

export default {
    name: 'FrameComposer',
    mixins: [TranslationFilter],
    components: {
        AppTemplate,
        UiAppLayers,
        UiAppLibrary,
        UiAppNote,
        UiAppPreview,
    },
    data: function () {
        return {
            ...SharedData,
            canvas: null,
            landscape: null,
            objs: [],
            canvasWidth: 1000,
            canvasHeight: 562,
        }
    },
    watch: {
        'size': function (size) {
            if (this.canvas) {
                this.resizeCanvas(size.wClean)
            }
        },
        ...SharedWatch,
    },
    methods: {
        init: function () {
            let size = this.getCanvasSize(true)
            let preview = this.$refs.preview
            let container = preview.$el
            let canvas = preview.$refs.canvas
            // aggiunge delle proprietà custom all'oggetto di fabricJS
            fabric.Object.prototype.toObject = (function (toObject) {
                return function (propertiesToInclude) {
                    propertiesToInclude = (propertiesToInclude || []).concat(['originalObj', 'libraryIdx', 'uuid', 'idx']);
                    return toObject.apply(this, [
                        propertiesToInclude
                    ]);
                };
            })(fabric.Object.prototype.toObject)

            this.canvas = new fabric.Canvas(canvas, {
                backgroundColor: '#f3f3f3',
                centeredScaling: true,
            })

            this.canvas.setWidth(this.canvasWidth)
            this.canvas.setHeight(this.canvasHeight)
            this.landscape = new fabric.Group()
            this.landscape.set({
                selectable: false
            })

            this.canvas.add(this.landscape)

            if (this.$root.session.content.canvas) {
                this.addListeners(true)
                this.selectionListeners()
                this.$nextTick(this.loadFromJSON)
            }
            else {
                this.addListeners()
                this.selectionListeners()
            }

        },
        loadFromJSON: function () {
            let content = this.$root.session.content
            let canvasParsed = JSON.parse(content.canvas)
            let objects = canvasParsed.objects

            this.$root.isOpen = true
            this.$root.objectsToLoad = objects.length

            this.notes = content.notes
            for (let i = 0; i < objects.length; i++) {
                let objs = objects[i]
                if (objs.type == 'group') {
                    // è uno sfondo
                    for (let j = 0; j < objs.objects.length; j++) {
                        let obj = objs.objects[j]
                        this.addToCanvas(obj.idx, obj.libraryIdx, true)
                    }
                }
                else {
                    // è un'immagine
                    let obj = objs
                    console.log(obj);
                    this.addToCanvas(obj.idx, obj.libraryIdx, true, obj)
                }
            }
        },
        getCanvasSize: function (hasReturn) {
            let el = this.$refs.preview.$el
            let title = this.$refs.preview.$refs.title.$refs.title
            let elSize = SizeUtility.get(el)
            let titleSize = SizeUtility.get(title)
            elSize.hClean = elSize.hClean - titleSize.hClean - titleSize.marginY
            this.size = elSize
            if (hasReturn) {
                return this.size
            }
        },
        resizeCanvas: function (width) {
            let scaleFactor = width / this.canvasWidth
            this.canvas.setWidth(this.canvasWidth * scaleFactor)
            this.canvas.setHeight(this.canvasHeight * scaleFactor)
            // set zoom for resizing
            this.canvas.setZoom(scaleFactor)
            this.canvas.calcOffset()
            this.canvas.renderAll()
        },
        addListeners: function (fromOpen = false) {
            this.addListener(this.landscape, fromOpen)
            this.addListener(this.canvas, fromOpen)
        },
        addListener: function (obj, fromOpen = false) {
            let events = ['object:added', 'object:removed',
                'object:modified', 'object:rotating', 'object:scaling',
                'object:moving'
            ]
            for (let j = 0; j < events.length; j++) {
                obj.on(events[j], () => {
                    this.$nextTick(() => {
                        this.saveCanvas(events[j], fromOpen)
                    })
                })
            }
        },
        selectionListeners: function () {
            let events = ['selection:created', 'selection:updated']
            for (let j = 0; j < events.length; j++) {
                this.canvas.on(events[j], (el) => {
                    this.toggleActiveLayer(el, true)
                })
            }
            this.canvas.on('selection:cleared', (el) => {
                this.toggleActiveLayer(el, false)
            })
        },
        toggleActiveLayer: function (el, hasToActive = true) {
            let layers = this.$refs.layers.$refs.layer
            let objs = hasToActive ? el.selected : el.deselected
            for (let i = 0; i < objs.length; i++) {
                let obj = objs[i].toJSON()
                let layer = layers.filter(layer => layer.uuid == obj.uuid)[0]
                let layerInverse = layers.filter(layer => layer.uuid != obj.uuid)
                if (hasToActive) {
                    layer.setActive()
                    layerInverse.forEach(asset => {
                        asset.unsetActive()
                    })
                }
                else {
                    layer.unsetActive()
                }
            }
        },
        saveCanvas: function (event = false, fromOpen = false) {
            // console.log('salva', event, fromOpen);
            if (event === 'object:added' && fromOpen === true) {
                this.$root.objectsLoaded++
            }

            let content = this.$root.session.content
            let newContent = {
                canvas: '',
                rendered: null,
                notes: this.notes
            }

            // Save canvas to JSON for future edit
            let json_canvas = JSON.stringify(this.canvas.toDatalessJSON())

            for (let key in content) {
                if (content.hasOwnProperty(key) && key == 'canvas') {
                    newContent.canvas = json_canvas
                }
                else if (content.hasOwnProperty(key) && key == 'rendered') {
                    newContent.rendered = this.canvas.toDataURL('png')
                }
            }

            // console.log(newContent);

            this.$root.session = {
                ...this.$root.session,
                content: newContent,
            }
        },
        setValue: function (value) {},
        // addToCanvas: function(item, libraryIdx, isID = false, isImage = false) {
        addToCanvas: function (index, libraryID, fromOpen = false, savedObj = null) {
            let library = this.assets.library.filter(library => library.id ==
                libraryID)[0]
            let asset = library.medias.filter(asset => asset.id == index)[0]
            let url = '/storage/' + asset.src
            // console.log(url);
            // crea l'istanza di FabricJs
            let image = new fabric.Image.fromURL(url, (obj, opts) => {
                // new Object
                let uuid = this.uniqid()

                if (fromOpen && savedObj) {
                    console.log('from open', fromOpen);
                    obj.set({
                        selectable: true,
                        centeredScaling: true,
                        originX: 'center',
                        ...savedObj,
                    })

                    obj.setCoords()
                    this.objs.push(obj)
                    // console.log('aggiungi listener', fromOpen);
                    this.addListener(obj, fromOpen)
                    this.canvas.add(obj)
                    this.canvas.renderAll()
                }
                else {
                    obj.set({
                        selectable: true,
                        centeredScaling: true,
                        originX: 'center',
                        originalObj: asset,
                        libraryIdx: libraryID,
                        uuid: uuid,
                        idx: index,
                    })

                    // se si tratta di un elemento e non di uno sfondo
                    if (libraryID != 1) {
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
                                if (scaleFactor > 1) {
                                    scaleFactor = height / objHeight
                                }
                                else {
                                    scaleFactor = (height * scaleFactor) /
                                        objHeight
                                }
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
                        // console.log('aggiungi listener', fromOpen);
                        this.addListener(obj, fromOpen)
                        this.canvas.add(obj)
                        // force center
                        obj.viewportCenter()
                        this.canvas.calcOffset()
                        this.canvas.renderAll()
                    }
                    else {
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
                        // se il canvas non riempi la schermata in orizzontale ricalcola le dimensioni
                        width = this.landscape.getScaledWidth()
                        if (width < this.canvasWidth) {
                            scaleFactor = (this.canvasWidth *
                                scaleFactor) / width
                            this.landscape.set({
                                scaleX: scaleFactor,
                                scaleY: scaleFactor,
                            })
                        }
                        // centra lo sfondo
                        this.landscape.set({
                            left: 0,
                        })
                        this.landscape.viewportCenter()
                        this.landscape.setCoords()
                        this.canvas.calcOffset()
                        this.canvas.renderAll()
                    }
                }


            })
            this.canvas.calcOffset()
            this.canvas.renderAll()
            this.saveCanvas(false, fromOpen)
        },
        selected: function (index, libraryID) {
            this.addToCanvas(index, libraryID)
        },
        selectLayer: function (idx) {
            this.canvas.setActiveObject(this.objs[idx])
            this.canvas.renderAll()
        },
        deleteLayer: function (idx) {
            this.canvas.discardActiveObject()
            this.canvas.remove(this.objs[idx])
            this.isActive = null
            this.canvas.renderAll()
            this.objs.splice(idx, 1)
        },
        setNotes: function (notes) {
            this.notes = notes
            this.saveCanvas()
        }
    },
    created: function () {
        this.uniqid = SharedMethods.uniqid.bind(this)
        this.getData = SharedMethods.getData.bind(this)
        this.$root.isApp = true
        // this.$root.session =
        this.getData()
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
