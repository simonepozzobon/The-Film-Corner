//https://github.com/scrumpy/tiptap/issues/104
// https://github.com/scrumpy/tiptap
import {Node} from 'tiptap'

export default class CustomContent extends Node {

    get name() {
        return 'heading'
    }

    get defaultOptions() {
        return {
            levels: [
                1,
                2,
                3,
                4,
                5,
                6
            ]
        }
    }

    get schema() {
        return {
            attrs: {
                level: {
                    default: null
                }
            },
            content: 'inline*',
            group: 'block',
            defining: true,
            draggable: false,
            parseDOM: this.options.levels.map(level => ({tag: `h${level}`, attrs: {
                    level
                }})),
            toDOM: node => {
                console.log(node);
                return ['ui-title', {
                    tag: `h${node.attrs.level}`,
                    fontSize: `h${node.attrs.level}`,
                    title: `${node.content.content[0].text}`,
                }]
            }
        }
    }
}
