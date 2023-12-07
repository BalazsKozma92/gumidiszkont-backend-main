<template>
  <Modal @close="$emit('close')">
    <div>
      <div class="text-xl mb-6 mt-6 text-center">
        Biztosan törölni szeretnéd a kupont?
      </div>
      <div class="font-bold text-center text-lg bg-black bg-opacity-10 p-2 text-black text-opacity-75">
        {{ coupon.code }}
      </div>
      <div class="flex justify-end gap-5 mt-6">
        <button @click="deleteCoupon" type="button"
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
  coupon: {
    type: Object,
  },
})

const coupon = ref({
  id: props.coupon ? props.coupon.id : null,
  code: props.coupon ? props.coupon.code : null,
  type: props.coupon ? props.coupon.type : null,
  discount: props.coupon ? props.coupon.discount : null,
  active: props.coupon ? props.coupon.active : null,
  event_start: props.coupon ? props.coupon.event_start : null,
  event_end: props.coupon ? props.coupon.event_end : null,
})

const emit = defineEmits(['close'])

function deleteCoupon() {
  store.dispatch('deleteCoupon', coupon.value.id)
    .then(res => {
      store.dispatch('getCoupons');
      emit('close');
    })
}

</script>

<style scoped></style>