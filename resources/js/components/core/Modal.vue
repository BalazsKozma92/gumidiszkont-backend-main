<template>
  <div class="fixed h-full w-full top-0 left-0 z-20 bg-black bg-opacity-30" @click="closeModal">
  </div>
  <div class="modal-container fixed left-1/2 -translate-x-2/4 top-1/2 -translate-y-2/4 overflow-auto z-50 md:min-w-[500px]"
    :class="customClass">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"
      class="w-6 h-6 absolute right-2 top-2 cursor-pointer" @click="closeModal">
      <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
    <slot @close="closeModal"></slot>
  </div>
</template>
  
<script setup>
const props = defineProps({
  customClass: {
    type: String,
  },
})

const emit = defineEmits(['close'])

function closeModal() {
  emit('close');
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
</style>