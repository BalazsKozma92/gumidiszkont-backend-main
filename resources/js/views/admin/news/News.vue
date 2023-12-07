<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Hírek</h1>
    <button type="button" @click="showAddNewNewsModal()"
      class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Új hír hozzáadása
    </button>
  </div>
  <NewsList>
  </NewsList>

  <NewsModal
    v-if="showNewsModal"
    @close="closeModal"
    :customClass="'w-[850px] max-h-[85vh]'"
  >
  </NewsModal>
</template>
  
<script setup>
import { ref } from "vue";
import NewsModal from "./NewsModal.vue";
import NewsList from "./NewsList.vue";

const showNewsModal = ref(false);

function closeModal() {
  showNewsModal.value = false;
}

function showAddNewNewsModal() {
  showNewsModal.value = true
}
</script>

<style scoped></style>