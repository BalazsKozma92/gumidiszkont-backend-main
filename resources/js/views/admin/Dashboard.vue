<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Főoldal</h1>
  </div>

  <div
    class="animate-fade-in-down mx-48"
  >
    <div
      class="grid grid-cols-2 justify-items-center text-center"
    >
      <router-link :to="{ name: 'admin.news' }">
        <div
          class="font-thin text-[48px]"
        >
          {{ news ? Object.keys(news).length : '0' }}
        </div>  
        <div
          class="font-thin text-[20px] uppercase"
        >
          hír
        </div>
      </router-link>
      <router-link :to="{ name: 'admin.coupons' }">
        <div
          class="font-thin text-[48px]"
        >
          {{ coupons ? Object.keys(coupons).length : '0' }}
        </div>  
        <div
          class="font-thin text-[20px] uppercase"
        >
          kupon
        </div>
      </router-link>
    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted, computed } from "vue";
import store from "../../store/index.js";

// const news = computed(() => store.state.news);
// const coupons = computed(() => store.state.coupons);
const news = ref(null)
const coupons = ref(null)

function getNews() {
  store.dispatch('getNews');
}

function getProductGroups() {
  store.dispatch('getProductGroups');
}

function getProducts() {
  store.dispatch('getProducts');
}

function getRecipes() {
  store.dispatch('getRecipes');
}

function getCoupons() {
  store.dispatch('getCoupons');
}

onMounted(() => {
  // if (!news.value) {
  //   getNews()
  // }
  // if (!productGroups.value) {
  //   getProductGroups()
  // }
  // if (!products.value) {
  //   getProducts()
  // }
  // if (!recipes.value) {
  //   getRecipes()
  // }
  // if (!coupons.value) {
  //   getCoupons()
  // }
})
</script>
  
<style scoped></style>