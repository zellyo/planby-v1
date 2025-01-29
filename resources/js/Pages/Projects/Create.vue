<script setup>
import { useForm } from "@inertiajs/vue3";

import MainSideBar from "@/Layouts/MainSideBar.vue";

const form = useForm({
    name: "",
    description: "",
});

const submit = () => {
    form.post(route("projects.store"));
};
</script>
<template>
    <MainSideBar>
        <div class="min-h-screen bg-gray-100">
            <!-- Top Bar -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-bold">Planby</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Create New Project</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Project Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Description</label>
                    <textarea
                        v-model="form.description"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="4"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Create Project
                </button>
            </form>
        </div>
        </div>

    </MainSideBar>
</template>
