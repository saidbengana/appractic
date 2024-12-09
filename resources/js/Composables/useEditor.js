export default function useEditor() {
    const insertEmoji = ({editorId, emoji}) => {
        dispatchEvent('editor:insert-content', {
            editorId,
            content: emoji
        });
    };

    const insertContent = ({editorId, content}) => {
        dispatchEvent('editor:insert-content', {
            editorId,
            content
        });
    };

    const focusEditor = ({editorId}) => {
        dispatchEvent('editor:focus', {
            editorId
        });
    };

    const dispatchEvent = (name, detail) => {
        document.dispatchEvent(new CustomEvent(name, {detail}));
    };

    return {
        insertEmoji,
        insertContent,
        focusEditor
    };
}
