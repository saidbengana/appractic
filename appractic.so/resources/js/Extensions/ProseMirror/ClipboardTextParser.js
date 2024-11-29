import {Slice, Fragment, Node} from 'prosemirror-model';

const clipboardTextParser = (text, context, plain) => {
    const blocks = text.replace().split(/(?:\r\n?|\n)/);
    const nodes = [];

    blocks.forEach(line => {
        const nodeJson = {type: "div"};
        if (line.length > 0) {
            nodeJson.content = [{type: "text", text: line}]
        }
        const node = Node.fromJSON(context.doc.type.schema, nodeJson);
        nodes.push(node);
    });

    const fragment = Fragment.fromArray(nodes);
    return Slice.maxOpen(fragment);
};

export default clipboardTextParser;
