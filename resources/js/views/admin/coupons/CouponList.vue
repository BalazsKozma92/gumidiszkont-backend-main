<template>
    <div
        class="animate-fade-in-down"
    >
        <div
            v-if="!coupons || coupons.length === 0"     
            class="text-xl mt-8 font-thin"  
        >
            Még nem hoztál létre kupont
        </div>
        <div
           
            class="flex flex-col gap-4"
        >
            <div class="flex gap-4 items-center mt-8">
                <div class="flex min-h-[1.5rem] items-center">
                    <input type="checkbox" class="cursor-pointer" @click="setAllForDeletion($event.target.checked)"/>
                    <label class="inline-block pl-2 hover:cursor-pointer" for="published">
                        Összes bejelölése
                    </label>
                </div>
                <button type="button" @click="deleteCoupons()"
                    class="uppercase tracking-wide py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kijelöltek törlése
                </button>
            </div>
            <div
                v-for="(coupon, key) in coupons"
                :key="key"
                class="bg-gray-50 p-4 shadow-lg"
            >
                <span class="font-bold text-lg uppercase text-black text-opacity-60">
                    {{ coupon[0].user.name }}
                </span>
                <span class="uppercase font-thin tracking-widest">
                    kuponjai
                </span>
                <div class="w-full h-[1px] bg-black bg-opacity-25">

                </div>
                <div
                    class="flex flex-col gap-4"
                >
                    <div
                        v-for="(singleCoupon, couponKey) in coupon"
                        :key="couponKey"
                        class="bg-gray-50 p-4 shadow-lg flex gap-12 items-center"
                    >
                        <div 
                            class=""
                            v-html="singleCoupon.qr_code"
                            alt="Coupon QR Code"
                        >
                        </div>
                        <div>
                            Neve: <span class="font-bold">{{ singleCoupon.name }}</span>
                        </div>
                        <div>
                            Értéke: <span class="font-bold">{{ singleCoupon.value }}{{ singleCoupon.type === 'percentage' ? '%' : ' Ft' }}</span>
                        </div>
                        <div
                            class="flex gap-2 items-center"
                        >
                            <div>
                                Felhasznált:    
                            </div>
                            <div v-if="singleCoupon.used_at" class="text-green-700 font-bold">
                                {{ singleCoupon.used_at }}
                            </div>
                            <div
                                v-else
                            >
                                <MinusCircleIcon class="w-8 text-red-700" />
                            </div>
                        </div>
                        <div>
                            Lejárati dátuma: 
                            <span :class="isExpired(singleCoupon.expiration_date) ? 'text-red-700 font-bold' : ''">
                                {{ singleCoupon.expiration_date }}
                            </span>
                        </div>
                        <div class="flex min-h-[1.5rem] items-center">
                            <input
                                type="checkbox"
                                :checked=deletableCoupons.includes(singleCoupon.id)
                                class="cursor-pointer"
                                @click="setDeletionArray(singleCoupon.id)"
                            />
                            <label class="inline-block pl-2 hover:cursor-pointer" for="published">
                                Törlés
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <DeleteModal
        v-if="showDeleteModal"
        :coupon="selectedCoupon"
        @close="closeModal"
    >
    </DeleteModal>
    <CouponModal
        v-if="showEditModal"
        :coupon="selectedCoupon"
        :customClass="'w-[850px] max-h-[85vh]'"
        @close="closeModal"
    >
    </CouponModal>
</template>
    
<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../../store/index.js";
import { MinusCircleIcon } from "@heroicons/vue/solid";
import DeleteModal from './DeleteModal.vue'
import CouponModal from './CouponModal.vue'

const coupons = computed(() => store.state.coupons);

const selectedCoupon = ref(null);

const showDeleteModal = ref(false);
const showEditModal = ref(false);
const deletableCoupons = ref([])

function getCoupons(url = null) {
    store.dispatch('getCoupons');
}

function deleteCoupons() {
    store.dispatch('deleteCoupons', deletableCoupons.value)
    .then(response => {
        store.dispatch('getCoupons');
        deletableCoupons.value = []
    })
}

function setDeletionArray(id) {
    if (deletableCoupons.value.includes(id)) {
        deletableCoupons.value.splice(deletableCoupons.value.indexOf(id), 1)
    } else {
        deletableCoupons.value.push(id)
    }
}

function setAllForDeletion(checked) {
    for (let i = 0; i < Object.keys(coupons.value).length; i++) {
        for (let j = 0; j < coupons.value[Object.keys(coupons.value)[i]].length; j++) {
            if (checked && !deletableCoupons.value.includes(coupons.value[Object.keys(coupons.value)[i]][j].id)) {
                deletableCoupons.value.push(coupons.value[Object.keys(coupons.value)[i]][j].id);
            } else if (!checked && deletableCoupons.value.includes(coupons.value[Object.keys(coupons.value)[i]][j].id)) {
                deletableCoupons.value.splice(deletableCoupons.value.indexOf(coupons.value[Object.keys(coupons.value)[i]][j].id), 1)
            }
        }
    }
}

function isExpired(expirationDate) {
      const currentDate = new Date();
      const couponExpirationDate = new Date(expirationDate);

      return currentDate > couponExpirationDate;
}

function closeModal() {
    showDeleteModal.value = false;
    showEditModal.value = false;
}

onMounted(() => {
    if (!coupons.value) {
        getCoupons();
    }
})
</script>
    
<style scoped></style>