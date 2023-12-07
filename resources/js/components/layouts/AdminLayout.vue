<template>
  <div
    v-if="loading"
    class="fixed w-full min-h-full opacity-60 bg-white z-10 flex items-center justify-center"
  >
    <div
      class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
      role="status"
    >
      <span
        class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
      >
        Pillanat...
      </span>
    </div>
  </div>
  <div class="min-h-[100vh] bg-gray-200 flex">
    <Sidebar :class="{'-ml-[160px]': !sidebarOpened}"/>

    <div class="flex-1">
      <Navbar @toggle-sidebar="toggleSidebar"></Navbar>

      <main class="p-6">
        <router-view></router-view>
      </main>

    </div>
  </div>
</template>

<script setup>
import {ref, computed, onMounted, onUnmounted} from 'vue'
import Sidebar from "../../views/admin/Sidebar.vue";
import Navbar from "../../views/admin/Navbar.vue";
import store from "../../store/index.js";

const loading = computed(() => store.state.loading);

const {title} = defineProps({
  title: String
})

const sidebarOpened = ref(true);
const currentUser = computed(() => store.state.user.data);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}

function updateSidebarState() {
  sidebarOpened.value = window.outerWidth > 768;
}

onMounted(() => {
  updateSidebarState();
  window.addEventListener('resize', updateSidebarState)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateSidebarState)
})
</script>

<style scoped>
</style>