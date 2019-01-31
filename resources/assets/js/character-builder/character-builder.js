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
            this.canvas.setWidth(1000)
            this.canvas.setHeight(1000)
        },
        setCanvasSize: function(width) {
            if (this.canvas) {
                let scaleFactor = width / 1000
                this.canvas.setWidth(width)
                this.canvas.setHeight(width)
                this.canvas.renderAll()
            }
        }
    },
    mounted: function() {
        this.getSize()
        this.init()

        window.addEventListener('resize', () => {
            this.getSize()
        })
    }
})
