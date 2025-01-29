<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Planby</h1>
                <nav class="mt-6 space-y-2">
                    <Link
                        :href="route('dashboard')"
                        class="block py-2.5 px-4 hover:bg-gray-700 rounded"
                    >
                        Dashboard
                    </Link>
                    <Link
                        :href="route('projects.index')"
                        class="block py-2.5 px-4 hover:bg-gray-700 rounded"
                    >
                        Projects
                    </Link>
                    <!-- Add other links similarly -->
                    <Link
                        :href="route('profile.edit')"
                        class="block py-2.5 px-4 hover:bg-gray-700 rounded"
                        role="menuitem"
                        >Profile</Link
                    >
                    <!-- Add some margin-top -->
                    <Link
                        :href="route('logout')"
                        method="post"
                        class="block py-2.5 px-4 hover:bg-gray-700 rounded"
                        role="menuitem"
                    >
                        Sign Out
                    </Link>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <slot />
        </div>
    </div>
</template>
