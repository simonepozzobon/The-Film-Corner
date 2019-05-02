<template lang="html">
    <app-template :app="app">
        <template slot="left">
            <ui-app-preview
                ref="preview"
                title="Character"/>
        </template>
        <template slot="right" v-if="this.assets">
            <ui-app-library
                :hasSubLibraries="assets.hasSubLibraries"
                :type="assets.type"
                :items="assets.library"
                @selected="selected"/>
        </template>
        <template>
            <ui-app-note
                class="mt-4"
                @changed="setNotes"/>
        </template>
    </app-template>
</template>

<script>
import {fabric} from 'fabric'
import AppTemplate from './AppTemplate.vue'
import SizeUtility from '../../Sizes'
import {
    UiAppLibrary,
    UiAppNote,
    UiAppPreview,
} from '../../uiapp'
import { SharedData, SharedMethods } from './Shared'

require('gsap/ScrollToPlugin')

export default {
    name: 'CharacterBuilder',
    components: {
        AppTemplate,
        UiAppLibrary,
        UiAppNote,
        UiAppPreview,
    },
    data: function() {
        return {
            ...SharedData,
            canvas: null,
            landscape: null,
            objs: [],
            canvasWidth: 1000,
            canvasHeight: 562,
            groups: [],
            landscapeLibraryId: 6,
        }
    },
    watch: {
        'size': function(size) {
            if (this.canvas) {
                this.resizeCanvas(size.wClean)
            }
        }
    },
    methods: {
        init: function() {
            let size = this.getCanvasSize(true)

            let preview = this.$refs.preview
            let container = preview.$el
            let canvas = preview.$refs.canvas

            // aggiunge delle proprietà custom all'oggetto di fabricJS
            fabric.Object.prototype.toObject = (function (toObject) {
                return function (propertiesToInclude) {
                    propertiesToInclude = (propertiesToInclude || []).concat(
                      ['originalObj','libraryIdx', 'uuid', 'idx']
                    );
                    return toObject.apply(this, [propertiesToInclude]);
                };
            })(fabric.Object.prototype.toObject)


            this.canvas = new fabric.Canvas(canvas, {
                backgroundColor: '#f3f3f3',
                centeredScaling: true,
            })


            this.canvas.setWidth(this.canvasWidth)
            this.canvas.setHeight(this.canvasHeight)

            // genero un gruppo per ogni lireria
            for (let i = 0; i < this.assets.library.length; i++) {
                let group = new fabric.Group()
                group.set({
                    selectable: false,
                })

                this.groups.push(group)
                this.canvas.add(this.groups[i])
            }

            this.addListeners()

            // carica uno sfondo random
            let landscapes = this.assets.library[0].medias
            let idx = Math.floor(Math.random() * landscapes.length)
            this.addToCanvas(landscapes[idx].id, this.landscapeLibraryId)
            // DEbug
            // this.$nextTick(() => {
            //     TweenLite.to(window, .2, {
            //         scrollTo: {
            //             y: '.ui-app-preview'
            //         }
            //     })
            //     this.addToCanvas(13, 2)
            // })
        },
        getCanvasSize: function(hasReturn) {
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
        resizeCanvas: function(width) {
            let scaleFactor = width / this.canvasWidth
            this.canvas.setWidth(this.canvasWidth * scaleFactor)
            this.canvas.setHeight(this.canvasHeight * scaleFactor)

            // set zoom for resizing
            this.canvas.setZoom(scaleFactor)
            this.canvas.calcOffset()
            this.canvas.renderAll()
        },
        addListeners: function() {
            for (var i = 0; i < this.groups.length; i++) {
                this.addListener(this.groups[i])
            }
        },
        addListener: function(obj) {
            let events = [ 'object:added', 'object:removed', 'object:modified' ]
            for (let j = 0; j < events.length; j++) {
                obj.on(events[j], () => {
                    // console.log('triggered ', events[j])
                    this.saveCanvas()
                })
            }
        },
        saveCanvas: function() {
            // Save canvas to JSON for future edit
            let json_data = JSON.stringify(this.canvas.toDatalessJSON())
            // localStorage.setItem('app-1-json', json_data)

            // Save image to local storage
            // localStorage.setItem('app-1-image', this.canvas.toDataURL('png'))
        },
        // addToCanvas: function(item, libraryIdx, isID = false, isImage = false) {
        addToCanvas: function(index, libraryID) {
            let library = this.assets.library.filter(library => library.id == libraryID)[0]
            let asset = library.medias.filter(asset => asset.id == index)[0]
            let url = '/storage/' + asset.src

            let idx = this.assets.library.findIndex(library => library.id == libraryID)
            if (idx > -1) {
                let objs = this.groups[idx].getObjects()
                for (let i = 0; i < objs.length; i++) {
                    this.groups[idx].removeWithUpdate(objs[i])
                }
            }


            // crea l'istanza di FabricJs
            let image = new fabric.Image.fromURL(url, (obj, opts) => {
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
                        let height = (this.canvasHeight / (this.groups.length - 1))
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
                this.saveCanvas()
            })
        },
        selected: function(index, libraryID) {
            this.addToCanvas(index, libraryID)
        },
        setNotes: function(notes) {
            this.notes = notes
        }
    },
    created: function() {
        this.uniqid = SharedMethods.uniqid.bind(this)
        this.getData = SharedMethods.getData.bind(this)

        this.$root.isApp = true
        this.getData()
    },
    mounted: function() {
    },
    beforeDestroy: function() {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
