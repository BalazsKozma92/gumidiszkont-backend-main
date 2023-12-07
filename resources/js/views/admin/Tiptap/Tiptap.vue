<template>
    <div class="news flex gap-2 flex-wrap mb-5" v-if="editor">
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
        h1
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
        h2
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
        h3
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
        h4
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 5 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }">
        h5
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }">
        h6
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
        bullet list
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
        ordered list
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }">
        paragraph
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
        bold
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
        italic
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
        strike
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleHighlight().run()" :class="{ 'is-active': editor.isActive('highlight') }">
        highlight
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }">
        blockquote
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }">
        left
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }">
        center
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setTextAlign('right').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }">
        right
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setHardBreak().run()">
        hard break
        </button>
        <button class="px-1 bg-gray-100" @click="editor.chain().focus().setHorizontalRule().run()">
        horizontal rule
        </button>
    </div>
    <editor-content class="editor-content" :editor="editor" />
    {{ modelValue }}
</template>
    
<script setup>
import { watch } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import Highlight from '@tiptap/extension-highlight'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    }
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        TextAlign.configure({
          types: ['heading', 'paragraph'],
        }),
        Highlight,
    ],
    onUpdate: () => {
        emit('update:modelValue', editor.value.getHTML());
    },
});

watch(
    () => props.modelValue,
    value => {
        const isSame = editor.value.getHTML() === value

        if (isSame) {
            return;
        }

        editor.value.commands.setContent(value, false);
    }
)
</script>

<style scoped>

</style>