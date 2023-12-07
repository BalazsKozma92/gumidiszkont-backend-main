<template>
  <Modal @close="$emit('close')">
    <div>
      <div class="text-xl mb-6 mt-6 text-center">
        Biztosan törölni szeretnéd a következő hírt?
      </div>
      <div class="font-bold text-center text-lg bg-black bg-opacity-10 p-2 text-black text-opacity-75">
        {{ news.title }}
      </div>
      <div class="flex justify-end gap-5 mt-6">
        <button @click="deleteNews" type="button"
          class="shadow-lg inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
          Igen
        </button>
        <button @click="$emit('close')" type="button"
          class="shadow-lg inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
          Mégsem
        </button>
      </div>
    </div>
  </Modal>
</template>
  
<script setup>
import { ref } from 'vue'
import store from "../../../store/index.js";
import Modal from '../../../components/core/Modal.vue'

const props = defineProps({
  news: {
    type: Object,
  },
})

const news = ref({
  id: props.news ? props.news.id : null,
  title: props.news ? props.news.title : null,
  content: props.news ? props.news.image : null,
  published: props.news ? props.news.published : null,
})

const emit = defineEmits(['close'])

function deleteNews() {
  store.dispatch('deleteNews', news.value.id)
    .then(res => {
      store.dispatch('getNews');
      emit('close');
    })
}

</script>

<style scoped></style>