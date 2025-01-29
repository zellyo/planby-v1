<script setup>
import TopSideBar from "@/Layouts/TopSideBar.vue";
import MainSidebar from "@/Layouts/MainSidebar.vue";

defineProps({
    projects: Array,
});
</script>

<template>
    <MainSidebar>
        <TopSideBar :projects="projects">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Welcome to Planby</h1>
                <p class="mt-2">
                    Select a project or create a new one to get started.
                </p>
            </div>
        </TopSideBar>
    </MainSidebar>
</template>
