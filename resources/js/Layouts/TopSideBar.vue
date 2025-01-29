<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    projects: Array,
});

const onProjectSelect = (event) => {
    const projectId = event.target.value;
    if (projectId) {
        window.location.href = `/projects/${projectId}`;
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Top Bar -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold">Planby</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link
                            :href="route('projects.create')"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        >
                            Create Project
                        </Link>
                        <select
                            class="border border-gray-300 rounded px-4 py-2"
                            @change="onProjectSelect($event)"
                        >
                            <option value="">Select Project</option>
                            <option
                                v-for="project in projects"
                                :key="project.id"
                                :value="project.id"
                            >
                                {{ project.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-8">
            <slot />
        </div>
    </div>
</template>
