<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Főképek</h1>
    <button type="button" @click="showAddCarouselImageModal()"
      class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Új főkép hozzáadása
    </button>
  </div>
  <CarouselImageList>
  </CarouselImageList>

  <CarouselImageModal
    v-if="showCarouselImageModal"
    @close="closeModal"
    :customClass="'w-[850px] max-h-[85vh]'"
  >
  </CarouselImageModal>
</template>
  
<script setup>
import { ref } from "vue";
import CarouselImageModal from "./CarouselImageModal.vue";
import CarouselImageList from "./CarouselImageList.vue";

const showCarouselImageModal = ref(false);

function closeModal() {
  showCarouselImageModal.value = false;
}

function showAddCarouselImageModal() {
  showCarouselImageModal.value = true
}
</script>

<style scoped></style>