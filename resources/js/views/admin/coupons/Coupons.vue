<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Kuponok</h1>
    <button type="button" @click="showAddCouponModal()"
      class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Új kupon hozzáadása
    </button>
  </div>
  <CouponList>
  </CouponList>

  <CouponModal
    v-if="showCouponModal"
    @close="closeModal"
    :customClass="'w-[850px] max-h-[85vh]'"
  >
  </CouponModal>
</template>
  
<script setup>
import { ref } from "vue";
import CouponModal from "./CouponModal.vue";
import CouponList from "./CouponList.vue";

const showCouponModal = ref(false);

function closeModal() {
  showCouponModal.value = false;
}

function showAddCouponModal() {
  showCouponModal.value = true
}
</script>

<style scoped></style>