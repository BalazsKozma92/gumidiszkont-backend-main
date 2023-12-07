<template>
    <div class="flex min-h-full flex-1 flex-col mt-16 px-6 py-12 md:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ props.title }}</h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>

  const props = defineProps({
    title: String,
  })

</script>

<style scoped>
</style>