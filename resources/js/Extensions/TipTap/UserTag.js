import { Extension } from '@tiptap/core'
import { Plugin } from '@tiptap/pm/state'
import { Decoration, DecorationSet } from '@tiptap/pm/view'

const UserTag = Extension.create({
    name: 'usertag',

    addProseMirrorPlugins() {
        return [
            new Plugin({
                state: {
                    init(_, { doc }) {
                        return findUserTag(doc)
                    },
                    apply(transaction, oldState) {
                        return transaction.docChanged ? findUserTag(transaction.doc) : oldState
                    },
                },
                props: {
                    decorations(state) {
                        return this.getState(state)
                    },
                },
            }),
        ]
    },
})

const findUserTag = (doc) => {
    const hash = /@(\w+)\b/gi;
    const decorations = [];

    doc.descendants((node, position) => {
        if (!node.text) {
            return
        }

        Array.from(node.text.matchAll(hash)).forEach(match => {
            const hashtag = match[0]
            const index = match.index || 0
            const from = position + index
            const to = from + hashtag.length
            const decoration = Decoration.inline(from, to, {
                class: 'text-blue-500'
            })

            decorations.push(decoration)
        })
    })

    return DecorationSet.create(doc, decorations)
}

export default UserTag;
