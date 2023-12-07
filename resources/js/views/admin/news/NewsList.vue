<template>
    <div
        class="animate-fade-in-down"
    >
        <div
            v-if="!news || Object.keys(news).length === 0"     
            class="text-xl mt-8 font-thin"  
        >
            Még nem töltöttél fel receptet
        </div>
        <div
            v-else
            class="flex flex-wrap gap-9"
        >
            <div
                v-for="(details, key) in news"
                :key="key"
                class="bg-gray-50 p-4 w-[350px] h-[450px] shadow-lg"
            >
                <div
                    class="shadow-lg rounded-md p-2 h-[60%] overflow-hidden"
                >
                    <div
                        class="font-bold text-lg mb-4"
                    >
                        {{ details.title }}
                    </div>
                    <div
                        class="tiptap"
                    >
                        <span
                            v-html="details.content"
                        >
                        </span>
                    </div>
                </div>
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
                    class="mt-2 flex gap-3"
                >
                    <span
                        class="font-bold"
                    >
                        Készült:
                    </span>
                    {{ details.created_at }}
                </div>
                <div
                    class="mt-2 flex gap-3"
                >
                    <span
                        class="font-bold"
                    >
                        Módosult:
                    </span>
                    {{ details.updated_at }}
                </div>
                <div
                    class="flex justify-between gap-4 mt-4"
                >
                    <!-- <router-link :to="{path: '/admin/news/' + details.id}" class="w-1/2">
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
    <DeleteModal
        v-if="showDeleteModal"
        :news="selectedNews"
        @close="closeModal"
    >
    </DeleteModal>
    <NewsModal
        v-if="showEditModal"
        :news="selectedNews"
        :customClass="'w-[850px] max-h-[85vh]'"
        @close="closeModal"
    >
    </NewsModal>
</template>
    
<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../../store/index.js";
import { CheckCircleIcon, MinusCircleIcon } from "@heroicons/vue/solid";
import DeleteModal from './DeleteModal.vue'
import NewsModal from './NewsModal.vue'

const news = computed(() => store.state.news);

const selectedNews = ref(null);

const showDeleteModal = ref(false);
const showEditModal = ref(false);

function getNews(url = null) {
    store.dispatch('getNews');
}

function showDeleteModalFn(news) {
    selectedNews.value = news;
    showDeleteModal.value = true;
}

function showEditModalFn(news) {
    selectedNews.value = news;
    showEditModal.value = true;
}

function closeModal() {
    showDeleteModal.value = false;
    showEditModal.value = false;
}

onMounted(() => {
    // if (!news.value) {
    //     getNews();
    // }
})
</script>
    
<style scoped></style>