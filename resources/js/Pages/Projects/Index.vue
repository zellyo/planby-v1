<script setup>
import { Link, router } from "@inertiajs/vue3"; // Added router import
import MainSideBar from "@/Layouts/MainSideBar.vue";

defineProps({
    projects: Array,
});

const deleteProject = (id) => {
    if (confirm("Are you sure you want to delete this project?")) {
        router.delete(route("projects.destroy", id));
    }
};
</script>

<template>
    <MainSideBar>
        <div class="p-8">
            <div class="mb-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">All Projects</h1>
                <Link
                    :href="route('projects.create')"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Create New Project
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Name
                            </th>
                            <!-- Added Description column -->
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Description
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Created At
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="project in projects" :key="project.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ project.name }}
                            </td>
                            <!-- Added Description data -->
                            <td class="px-6 py-4 max-w-xs truncate">
                                {{ project.description || "-" }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{
                                    new Date(
                                        project.created_at
                                    ).toLocaleDateString()
                                }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <Link
                                    :href="route('projects.edit', project.id)"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="deleteProject(project.id)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </MainSideBar>
</template>
