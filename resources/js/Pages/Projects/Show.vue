<script setup>
import MainSideBar from "@/Layouts/MainSideBar.vue";

defineProps({
    project: Object,
});
</script>

<template>
    <MainSideBar>
        <div class="p-6">
            <h1 class="text-2xl font-bold">{{ project.name }}</h1>
            <p class="mt-2 text-gray-600">{{ project.description }}</p>
        </div>
    </MainSideBar>
</template>
