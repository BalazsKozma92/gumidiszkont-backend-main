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
            <div
                v-for="(coupon, key) in coupons"
                :key="key"
                class="bg-gray-50 p-4 shadow-lg"
            >
                <div
                    v-for="(singleCoupon, couponKey) in coupon"
                    :key="couponKey"
                    class="bg-gray-50 p-4 shadow-lg flex flex-col gap-4"
                >
                    <div 
                        class=""
                        v-html="singleCoupon.qr_code"
                        alt="Coupon QR Code"
                    >
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