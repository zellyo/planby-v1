<script setup>
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";

defineProps({
    project: Object,
    product: Object,
});
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-2xl font-bold mb-6">{{ product.name }}</h1>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <img
                            v-if="product.image"
                            :src="`/storage/${product.image}`"
                            class="mb-4 max-w-full h-64 object-contain"
                        />
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-gray-600 font-medium"
                                    >Description:</label
                                >
                                <p class="mt-1">{{ product.description }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 font-medium"
                                    >Quantity:</label
                                >
                                <p class="mt-1">{{ product.quantity }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 font-medium"
                                    >Cost:</label
                                >
                                <p class="mt-1">${{ product.cost }}</p>
                            </div>
                            <div>
                                <label class="text-gray-600 font-medium"
                                    >Selling Price:</label
                                >
                                <p class="mt-1">${{ product.selling_price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainSideBar>
</template>
