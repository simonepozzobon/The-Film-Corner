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
        }
    }
})
