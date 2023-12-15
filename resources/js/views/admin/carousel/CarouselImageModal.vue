<template>
  <Modal @close="$emit('close')" :customClass="'h-[85vh]'">
    <div>
      <div class="text-2xl font-bold">
        {{ carouselImage.id === null ? 'Új kép' : 'Kép szerkesztése' }}
      </div>
      <div class="relative mb-6 mt-6">
        <label for="name" class="text-xs text-black text-opacity-70">
          Cím
        </label>
        <input v-model="carouselImage.title" type="text"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="name" placeholder="Név" />
      </div>

      <div class="mb-6">
        <label for="image" class="text-xs text-black text-opacity-70">
          Kép
        </label>

        <input type="file" class="block w-full text-transparent
          file:mr-4 file:py-2 file:px-4
          file:rounded-md file:border-0
          file:text-sm file:font-semibold file:cursor-pointer
          file:bg-blue-500 file:text-white
          hover:file:bg-blue-600" @input="uploadImage($event)" />
        <div class="relative w-full">
          <img v-if="newImage === false && carouselImage.image" class="w-full max-h-[250px] object-contain mt-8"
            :src="'http://localhost:8000/' + carouselImage.image" alt="">
          <img class="w-full max-h-[250px] object-contain mt-8 hidden" id="output">
        </div>
      </div>

      <div class="mb-6 flex min-h-[1.5rem] items-center ">
        <input type="checkbox" v-model="carouselImage.published" id="published" />
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
import { ref, computed } from 'vue'
import store from "../../../store/index.js";
import Modal from '../../../components/core/Modal.vue'

const props = defineProps({
  carouselImage: {
    type: Object,
  }
})

const carouselImage = ref({
  id: props.carouselImage ? props.carouselImage.id : null,
  title: props.carouselImage ? props.carouselImage.title ? props.carouselImage.title : null : null,
  image: props.carouselImage ? props.carouselImage.image_url ? props.carouselImage.image_url : null : null,
  published: props.carouselImage ? props.carouselImage.published : false,
})
const carouselImageToSend = ref({})

const emit = defineEmits(['close'])

const newImage = ref(false)

function onSubmit() {
  if (!newImage.value) {
    carouselImageToSend.value.id = carouselImage.value.id
    carouselImageToSend.value.title = carouselImage.value.title
    carouselImageToSend.value.published = carouselImage.value.published
  } else {
    carouselImageToSend.value = carouselImage.value
  }

  if (carouselImageToSend.value.id) {
    store.dispatch('updateCarouselImage', carouselImageToSend.value)
      .then(response => {
        if (response.status === 200) {
          store.dispatch('getCarouselImages')
          emit('close');
        }
      })
  } else {
    store.dispatch('createCarouselImage', carouselImageToSend.value)
      .then(response => {
        if (response.status === 200) {
          store.dispatch('getCarouselImages')
          emit('close');
        }
      })
      .catch(err => {
      })
  }
}

function uploadImage(event) {
  newImage.value = true;
  carouselImage.value.image = event.target.files[0];

  var output = document.getElementById('output');

  output.classList.remove('hidden');
  output.src = URL.createObjectURL(event.target.files[0]);
  output.onload = function () {
    URL.revokeObjectURL(output.src)
  }
}
</script>

<style scoped></style>