import { Extension } from '@tiptap/core'

export const CharacterCount = Extension.create({
    name: 'characterCount',

    addStorage() {
        return {
            characters: 0,
            words: 0,
        }
    },

    onUpdate() {
        const text = this.editor.state.doc.textContent
        this.storage.characters = text.length
        this.storage.words = text.split(/\s+/).filter(word => word.length > 0).length
    },

    onCreate() {
        this.onUpdate()
    },
})
