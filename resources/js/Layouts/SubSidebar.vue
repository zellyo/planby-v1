<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="w-48 bg-gray-700 text-white">
        <div class="p-4">
            <nav class="mt-6 space-y-2">
                <Link
                    :href="route('projects.show', { project: project.id })"
                    class="block py-2 px-4 hover:bg-gray-600 rounded"
                >
                    Overview
                </Link>
                <Link
                    :href="
                        route('projects.products.index', {
                            project: project.id,
                        })
                    "
                    class="block py-2 px-4 hover:bg-gray-600 rounded"
                >
                    Products
                </Link>
            </nav>
        </div>
    </div>
</template>
