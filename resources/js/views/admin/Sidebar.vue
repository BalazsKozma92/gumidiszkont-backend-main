<template>
  <div class="min-w-[160px] w-[160px]  transition-all bg-indigo-600 text-white py-4 px-2">

    <router-link :to="{ name: 'admin.dashboard' }"
      class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <HomeIcon class="w-6" />
      </span>
      <span class="text-xs">
        Főoldal
      </span>
    </router-link>

    <router-link :to="{ name: 'admin.news' }" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <SpeakerphoneIcon class="w-6" />
      </span>
      <span class="text-xs">
        Hírek
      </span>
    </router-link>

    <router-link :to="{ name: 'admin.carouselImages' }" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <PhotographIcon class="w-6" />
      </span>
      <span class="text-xs">
        Főoldali képek
      </span>
    </router-link>

    <router-link :to="{ name: 'admin.coupons' }" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <TagIcon class="w-6" />
      </span>
      <span class="text-xs">
        Kuponok
      </span>
    </router-link>

  </div>
</template>
  
<script setup>
import { HomeIcon, SpeakerphoneIcon, PhotographIcon, TagIcon } from '@heroicons/vue/outline'
</script>
  
<style scoped></style>