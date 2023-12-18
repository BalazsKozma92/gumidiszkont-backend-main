<template>
    <div
        class="animate-fade-in-down"
    >
        <div
            v-if="!carouselImages || Object.keys(carouselImages).length === 0"     
            class="text-xl mt-8 font-thin"  
        >
            Még nem töltöttél fel képet
        </div>
        <div
            v-else
            class="flex flex-wrap gap-8"
        >
            <div
                v-for="(details, key) in carouselImages"
                :key="key"
                class="bg-gray-50 p-4 w-[350px] h-[450px] shadow-lg flex flex-col justify-between"
            >
                <div
                    class="shadow-lg rounded-md p-2"
                >
                    <div
                        class="font-bold text-lg mb-4 cut-text"
                    >
                        {{ details.title }}
                    </div>
                    <img
                        v-if="details.image_url"
                        class="w-full object-contain mt-8 h-[200px]"
                        :src="'https://admin.autoszervizmiskolc.hu/' + details.image_url" alt=""
                    >
                </div>
                <div>
                    <div
                        class="mt-4 flex gap-3"
                    >
                        <span
                            class="font-bold"
                        >
                            Közzétéve:
                        </span>
                        <CheckCircleIcon
                            v-if="details.published"
                            class="text-green-400"
                            :class="'h-6 w-6'"
                            aria-hidden="true"
                        />
                        <MinusCircleIcon
                            v-else
                            class="text-red-400"
                            :class="'h-6 w-6'"
                            aria-hidden="true"
                        />
                    </div>
                    <div
                        class="flex justify-between gap-4 mt-4"
                    >
                        <!-- <router-link :to="{path: '/admin/carousel-images/' + details.id}" class="w-1/2">
                        </router-link> -->
                        <button @click="showEditModalFn(details)" class="shadow-lg bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Szerkesztés
                        </button>    
                        <button @click="showDeleteModalFn(details)" class="shadow-lg bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-1/2">
                            Törlés
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <DeleteModal
        v-if="showDeleteModal"
        :carouselImage="selectedCarouselImage"
        @close="closeModal"
    >
    </DeleteModal>
    <CarouselImageModal
        v-if="showEditModal"
        :carouselImage="selectedCarouselImage"
        :customClass="'w-[850px] max-h-[85vh]'"
        @close="closeModal"
    >
    </CarouselImageModal>
</template>
    
<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../../store/index.js";
import { CheckCircleIcon, MinusCircleIcon } from "@heroicons/vue/solid";
import DeleteModal from './DeleteModal.vue'
import CarouselImageModal from './CarouselImageModal.vue'

const carouselImages = computed(() => store.state.carouselImages);

const selectedCarouselImage = ref(null);

const showDeleteModal = ref(false);
const showEditModal = ref(false);

function getCarouselImages(url = null) {
    store.dispatch('getCarouselImages');
}

function showDeleteModalFn(carouselImage) {
    selectedCarouselImage.value = carouselImage;
    showDeleteModal.value = true;
}

function showEditModalFn(carouselImage) {
    selectedCarouselImage.value = carouselImage;
    showEditModal.value = true;
}

function closeModal() {
    showDeleteModal.value = false;
    showEditModal.value = false;
}

onMounted(() => {
    if (!carouselImages.value) {
        getCarouselImages();
    }
})
</script>
    
<style scoped>
.cut-text { 
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>