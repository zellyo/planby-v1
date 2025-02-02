<!-- resources/js/Pages/Projects/Show.vue -->
<script setup>
import MainSideBar from '@/Layouts/MainSideBar.vue';
import SubSidebar from '@/Layouts/SubSidebar.vue';

defineProps({
  project: Object,
});
</script>

<template>
  <MainSideBar>
    <div class="flex flex-1">
      <!-- Project SubSidebar -->
      <SubSidebar :project="project" />

      <!-- Main Content Area -->
      <div class="flex-1 p-8 bg-gray-50">
        <h1 class="text-2xl font-bold mb-4">{{ project.name }}</h1>
        <p class="text-gray-600">{{ project.description }}</p>
      </div>
    </div>
  </MainSideBar>
</template>