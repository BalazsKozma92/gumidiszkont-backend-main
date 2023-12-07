<template>
  <Modal @close="$emit('close')" :customClass="'h-[85vh]'">
    <div>
      <div class="text-2xl font-bold">
        {{ coupon.id === null ? 'Új kupon' : 'Kupon szerkesztése' }}
      </div>
      <div class="relative mb-6 mt-6">
        <label for="code" class="text-xs text-black text-opacity-70">
          Kód
        </label>
        <input v-model="coupon.code" type="text"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="code" placeholder="Név" />
      </div>

      <div class="relative mb-6">
        <label for="type" class="text-xs text-black text-opacity-70">
          Típus
        </label>
        <select v-model="coupon.type" id="countries"
          class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option v-for="(type, key) in [{label: 'Százalék', value: 'percentage'}, {label: 'Pontos érték', value: 'exact'}]" :value="type.value">{{ type.label }}</option>
        </select>
      </div>

      <div class="relative mb-6">
        <label for="discount" class="text-xs text-black text-opacity-70">
          Kedvezmény
        </label>
        <input v-model="coupon.discount" type="number"
          @keyup="testfunc"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="discount" placeholder="Ár" />
      </div>

      <div class="relative mb-2">
        <label for="event_start" class="text-xs text-black text-opacity-70">
          Kezdete
        </label>
        <VueDatePicker
          v-model="coupon.event_start"
          :month-change-on-scroll="false"
          :enable-time-picker="false"
          :format="'yyyy/MM/dd'"
          teleport-center
          auto-apply
        >
        </VueDatePicker>
      </div>

      <div class="relative mb-6">
        <label for="event_end" class="text-xs text-black text-opacity-70">
          Vége
        </label>
        <VueDatePicker
          v-model="coupon.event_end"
          :month-change-on-scroll="false"
          :enable-time-picker="false"
          :format="'yyyy/MM/dd'"
          teleport-center
          auto-apply
        >
        </VueDatePicker>
      </div>

      <div class="mb-6 flex min-h-[1.5rem] items-center ">
        <input type="checkbox" v-model="coupon.active" id="active" />
        <label class="inline-block pl-2 hover:cursor-pointer" for="published">
          Aktív
        </label>
      </div>

      <button @click="onSubmit" class="shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Mentés
      </button>
    </div>
  </Modal>
</template>
  
<script setup>
import { ref, watch } from 'vue'
import store from "../../../store/index.js";
import Modal from '../../../components/core/Modal.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  coupon: {
    type: Object,
  }
})

const coupon = ref({
  id: props.coupon ? props.coupon.id : null,
  code: props.coupon ? props.coupon.code ? props.coupon.code : null : null,
  type: props.coupon ? props.coupon.type ? props.coupon.type : null : null,
  discount: props.coupon ? props.coupon.discount ? props.coupon.discount : null : null,
  active: props.coupon ? props.coupon.active : false,
  event_start: props.coupon ? props.coupon.event_start : null,
  event_end: props.coupon ? props.coupon.event_end : null,
})
const couponToSend = ref({})

const emit = defineEmits(['close'])

watch(() => coupon.value.discount, (newValue) => {  
  if (coupon.value.type === 'percentage' && newValue > 100) {
    coupon.value.discount = 100;
  }
});

watch(() => coupon.value.type, (newValue) => {  
  if (newValue === 'percentage' && coupon.value.discount > 100) {
    coupon.value.discount = 100;
  }
});

function onSubmit() {
  couponToSend.value = coupon.value

  couponToSend.value.event_start = new Date(couponToSend.value.event_start).toISOString().split('T')[0];
  couponToSend.value.event_end = new Date(couponToSend.value.event_end).toISOString().split('T')[0]

  if (couponToSend.value.id) {
    store.dispatch('updateCoupon', couponToSend.value)
      .then(response => {
        if (response.status === 200) {
          store.dispatch('getCoupons')
          emit('close');
        }
      })
  } else {
    store.dispatch('createCoupon', couponToSend.value)
      .then(response => {
        if (response.status === 201) {
          store.dispatch('getCoupons')
          emit('close');
        }
      })
      .catch(err => {
      })
  }
}
</script>

<style scoped></style>