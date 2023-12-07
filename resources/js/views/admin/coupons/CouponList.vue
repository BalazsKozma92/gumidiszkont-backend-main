<template>
    <div
        class="animate-fade-in-down"
    >
        <div
            v-if="!coupons || Object.keys(coupons).length === 0"     
            class="text-xl mt-8 font-thin"  
        >
            Még nem hoztál létre kupont
        </div>
        <div
            v-else
            class="flex flex-col gap-4"
        >
            <div
                v-for="(details, key) in coupons"
                :key="key"
                class="bg-gray-50 p-4 shadow-lg"
            >
                <div
                    class="rounded-md p-2 flex gap-5 justify-between"
                >
                    <div
                        class="flex gap-5 items-center"
                    >
                        <div
                            class="text-lg"
                        >
                            {{ details.code }}
                        </div>/
                        <div
                            class="text-md"
                        >
                            {{ details.type === 'percentage' ? 'Százalékos' : 'Pontos érték' }}
                        </div>/
                        <div
                            class="text-md"
                        >
                            {{ details.type === 'percentage' ?
                                new Intl.NumberFormat('hu-HU', { style: 'percent', maximumFractionDigits: 0 }).format(details.discount / 100) :
                                new Intl.NumberFormat('hu-HU', { style: 'currency', currency: 'HUF', maximumFractionDigits: 0 }).format(details.discount) }}
                        </div>/
                        <div
                            class="flex gap-3 items-center"
                        >
                            <span>
                                Közzétéve:
                            </span>
                            <CheckCircleIcon
                                v-if="details.active"
                                class="text-green-400"
                                :class="'h-8 w-8'"
                                aria-hidden="true"
                            />
                            <MinusCircleIcon
                                v-else
                                class="text-red-400"
                                :class="'h-8 w-8'"
                                aria-hidden="true"
                            />
                        </div>/
                        <div
                            class="text-md"
                        >
                            {{ details.event_start }} - {{ details.event_end }}
                        </div>
                    </div>
                    <div
                        class="flex justify-center items-center gap-3 border-l-2 px-5"
                    >
                        <PencilIcon
                            class="text-blue-500 cursor-pointer h-8 w-8"
                            aria-hidden="true"
                            @click="showEditModalFn(details)"
                        />

                        <XIcon
                            class="text-red-500 cursor-pointer h-8 w-8"
                            aria-hidden="true"
                            @click="showDeleteModalFn(details)"
                        />
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
import { CheckCircleIcon, MinusCircleIcon, PencilIcon, XIcon } from "@heroicons/vue/solid";
import DeleteModal from './DeleteModal.vue'
import CouponModal from './CouponModal.vue'

const coupons = computed(() => store.state.coupons);

const selectedCoupon = ref(null);

const showDeleteModal = ref(false);
const showEditModal = ref(false);

function getCoupons(url = null) {
    store.dispatch('getCoupons');
}

function showDeleteModalFn(coupon) {
    selectedCoupon.value = coupon;
    showDeleteModal.value = true;
}

function showEditModalFn(coupon) {
    selectedCoupon.value = coupon;
    showEditModal.value = true;
}

function closeModal() {
    showDeleteModal.value = false;
    showEditModal.value = false;
}

onMounted(() => {
    // if (!coupons.value) {
    //     getCoupons();
    // }
})
</script>
    
<style scoped></style>