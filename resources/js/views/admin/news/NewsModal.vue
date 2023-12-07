<template>
  <Modal @close="$emit('close')">
    <div>
      <div class="text-2xl font-bold">
        {{ news.id === null ? 'Új hír' : 'Hír szerkesztése' }}
      </div>
      <div class="relative mb-6 mt-6">
        <label for="name" class="text-xs text-black text-opacity-70">
          Cím
        </label>
        <input v-model="news.title" type="text"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="name" placeholder="Név" />
      </div>

      <div class="relative mb-6">
        <label for="description" class="text-md text-black text-opacity-70">
          Hír szövege
        </label>
        <div
          class="mt-2"
        >
          <tiptap v-model="news.content" />
        </div>
      </div>

      <div class="mb-6 flex min-h-[1.5rem] items-center ">
        <input type="checkbox" v-model="news.published" id="published" />
        <label class="inline-block pl-2 hover:cursor-pointer" for="published">
          Közzétéve
        </label>
      </div>

      <button @click="onSubmit" class="shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Mentés
      </button>
    </div>
  </Modal>
</template>
    
<script setup>
import { ref } from "vue";
import Tiptap from "../Tiptap/Tiptap.vue";
import Modal from '../../../components/core/Modal.vue'
import store from "../../../store/index.js";

const props = defineProps({
  news: {
    type: Object,
  }
})

const news = ref({
  id: props.news ? props.news.id ? props.news.id : null : null,
  title: props.news ? props.news.title : null,
  content: props.news ? props.news.content : null,
  published: props.news ? props.news.published : false,
})
const newsToSend = ref({})

const emit = defineEmits(['close'])

function onSubmit() {
  newsToSend.value.id = news.value.id
  newsToSend.value.title = news.value.title
  newsToSend.value.content = news.value.content
  newsToSend.value.published = news.value.published

  if (newsToSend.value.id) {
    store.dispatch('updateNews', newsToSend.value)
      .then(response => {
        if (response.status === 200) {
          store.dispatch('getNews')
          emit('close');
        }
      })
  } else {
    store.dispatch('createNews', newsToSend.value)
      .then(response => {
        if (response.status === 201) {
          store.dispatch('getNews')
          emit('close');
        }
      })
      .catch(err => {
      })
  }
}

</script>
  
<style scoped></style>