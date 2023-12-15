<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Főoldal</h1>
  </div>

  <div
    class="animate-fade-in-down mx-48"
  >
    <div
      class="flex flex-wrap gap-8 text-center justify-center items-center mt-12"
    >
      <router-link :to="{ name: 'admin.news' }">
        <div class="
          flex
          flex-col
          gap-4
          border
          border-indigo-700
          border-opacity-50
          rounded-xl
          p-4
          transition-colors
          text-indigo-700
          text-opacity-60
          hover:text-[#ff2e2e]
          hover:border-[#ff2e2e]
          duration-200
          items-center
          justify-center"
        >
          <span class="mr-2">
            <SpeakerphoneIcon class="w-28"/>
          </span>
          <span class="uppercase tracking-widest">
            Hírek
          </span>
        </div>
      </router-link>

      <router-link :to="{ name: 'admin.carouselImages' }">
        <div class="
          flex
          flex-col
          gap-4
          border
          border-indigo-700
          border-opacity-50
          rounded-xl
          p-4
          transition-colors
          text-indigo-700
          text-opacity-60
          hover:text-[#ff2e2e]
          hover:border-[#ff2e2e]
          duration-200
          items-center
          justify-center"
        >
          <span class="mr-2">
            <PhotographIcon class="w-28"/>
          </span>
          <span class="uppercase tracking-widest">
            Főoldali képek
          </span>
        </div>
      </router-link>

      <router-link :to="{ name: 'admin.coupons' }">
        <div class="
          flex
          flex-col
          gap-4
          border
          border-indigo-700
          border-opacity-50
          rounded-xl
          p-4
          transition-colors
          text-indigo-700
          text-opacity-60
          hover:text-[#ff2e2e]
          hover:border-[#ff2e2e]
          duration-200
          items-center
          justify-center"
        >
          <span class="mr-2">
            <TagIcon class="w-28"/>
          </span>
          <span class="uppercase tracking-widest">
            Kuponok
          </span>
        </div>
      </router-link>
    </div>
  </div>
</template>
  
<script setup>
import { HomeIcon, SpeakerphoneIcon, PhotographIcon, TagIcon } from '@heroicons/vue/outline'
</script>
  
<style scoped></style>