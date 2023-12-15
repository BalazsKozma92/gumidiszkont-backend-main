<template>
  <Modal @close="$emit('close')" :customClass="'h-[85vh]'">
    <div>
      <div class="text-2xl font-bold">
        Új kupon
      </div>

      <div class="relative mt-6 mb-2">
        <label for="discount" class="text-xs text-black text-opacity-70">
          Kupon neve
        </label>
        <input v-model="name" type="text"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="discount" placeholder="Kupon darabszám" />
      </div>

      <div class="relative mt-6 mb-2">
        <label for="discount" class="text-xs text-black text-opacity-70">
          Kupon mennyiség felhasználónként
        </label>
        <input v-model="count" type="number"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="discount" placeholder="Kupon darabszám" />
      </div>

      <div class="relative mb-2">
        <label for="discount" class="text-xs text-black text-opacity-70">
          Kedvezmény értéke
        </label>
        <input v-model="value" type="number"
          class="peer block min-h-[auto] w-full rounded border-1 border-black border-opacity-40 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
          id="discount" placeholder="Érték" />
      </div>

      <div class="relative mb-6">
        <label for="type" class="text-xs text-black text-opacity-70">
          Kedvezmény típusa
        </label>
        <select v-model="type" id="countries"
          class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option v-for="(type, key) in [{label: 'Százalék', value: 'percentage'}, {label: 'Pontos érték', value: 'exact'}]" :value="type.value">{{ type.label }}</option>
        </select>
      </div>

      <div class="relative mb-6">
        <label for="event_end" class="text-xs text-black text-opacity-70">
          Lejárati dátum
        </label>
        <VueDatePicker
          v-model="expiration_date"
          :month-change-on-scroll="false"
          :enable-time-picker="false"
          :format="'yyyy/MM/dd'"
          teleport-center
          auto-apply
        >
        </VueDatePicker>
      </div>

      <div class="mb-6 flex min-h-[1.5rem] items-center ">
        <input type="checkbox" v-model="generateForAll" id="published" />
        <label class="inline-block pl-2 hover:cursor-pointer" for="published">
          Generálás az összes felhasználó számára
        </label>
      </div>

      <div class="relative mb-6">
        <label for="type" class="text-xs text-black text-opacity-70">
          QR kód generálása a felhasználó részére:
        </label>
        <select v-model="userToGenerateFor" id="countries"
          class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option 
            v-for="(user, key) in users"
            :value="user.id"
          >
            {{ user.name }}
          </option>
        </select>
      </div>
      <button @click="onSubmit" class="shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Generálás
      </button>
    </div>
  </Modal>
</template>
  
<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import store from "../../../store/index.js";
import Modal from '../../../components/core/Modal.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const users = computed(() => store.state.users);
const count = ref(0)
const value = ref(0)
const type = ref('')
const name = ref('')
const expiration_date = ref('')
const generateForAll = ref(true)
const userToGenerateFor = ref(null)

const emit = defineEmits(['close'])

watch(() => value.value, (newValue) => {  
  if (type.value === 'percentage' && newValue > 100) {
    value.value = 100;
  }
});

watch(() => type.value, (newValue) => {  
  if (newValue === 'percentage' && value.value > 100) {
    value.value = 100;
  }
});

watch(() => userToGenerateFor.value, (newValue) => {  
  if (newValue !== null) {
    generateForAll.value = false
  }
});

function onSubmit() {
  expiration_date.value = new Date(expiration_date.value).toISOString().split('T')[0]

  store.dispatch('createCoupons', {
    count: count.value,
    type: type.value,
    value: value.value,
    name: name.value,
    expiration_date: expiration_date.value,
    all_users: generateForAll.value,
    user_id: userToGenerateFor.value
  })
    .then(response => {
      if (response.status === 201) {
        store.dispatch('getCoupons')
        emit('close');
      }
    })
    .catch(err => {
    })
}

function getUsers() {
  store.dispatch('getUsers');
}

onMounted(() => {
  getUsers();
})
</script>

<style scoped></style>
