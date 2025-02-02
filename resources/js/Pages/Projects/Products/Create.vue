<script setup>
import { useForm } from "@inertiajs/vue3";
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";

const props = defineProps({
    project: Object,
});

const form = useForm({
    name: "",
    quantity: 0,
    cost: 0,
    selling_price: 0,
    description: "",
    image: null,
});

const submit = () => {
    form.post(route("projects.products.store", { project: props.project.id }), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <div class="max-w-2xl mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">
                            Create New Product
                        </h1>
                        <Link
                            :href="
                                route('projects.products.index', {
                                    project: project.id,
                                })
                            "
                            class="text-gray-600 hover:text-gray-800"
                        >
                            ← Back to Products
                        </Link>
                    </div>

                    <form
                        @submit.prevent="submit"
                        class="bg-white p-6 rounded-lg shadow-md"
                    >
                        <!-- Image Upload -->
                        <div class="mb-8">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Product Image
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                            >
                                <div class="space-y-1 text-center">
                                    <svg
                                        class="mx-auto h-12 w-12 text-gray-400"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 48 48"
                                    >
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                        >
                                            <span>Upload a file</span>
                                            <input
                                                type="file"
                                                @input="
                                                    form.image =
                                                        $event.target.files[0]
                                                "
                                                class="sr-only"
                                            />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG up to 2MB
                                    </p>
                                </div>
                            </div>
                            <p
                                v-if="form.errors.image"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.image }}
                            </p>
                        </div>

                        <!-- Product Details -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Name -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Product Name *
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Enter product name"
                                />
                                <p
                                    v-if="form.errors.name"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Quantity *
                                </label>
                                <input
                                    v-model="form.quantity"
                                    type="number"
                                    min="0"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="0"
                                />
                                <p
                                    v-if="form.errors.quantity"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.quantity }}
                                </p>
                            </div>

                            <!-- Cost -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Cost Price *
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                    >
                                        <span class="text-gray-500 sm:text-sm"
                                            >$</span
                                        >
                                    </div>
                                    <input
                                        v-model="form.cost"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        required
                                        class="block w-full pl-7 pr-12 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="0.00"
                                    />
                                </div>
                                <p
                                    v-if="form.errors.cost"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.cost }}
                                </p>
                            </div>

                            <!-- Selling Price -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Selling Price *
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                    >
                                        <span class="text-gray-500 sm:text-sm"
                                            >$</span
                                        >
                                    </div>
                                    <input
                                        v-model="form.selling_price"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        required
                                        class="block w-full pl-7 pr-12 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="0.00"
                                    />
                                </div>
                                <p
                                    v-if="form.errors.selling_price"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.selling_price }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Description
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Add product description..."
                                ></textarea>
                                <p
                                    v-if="form.errors.description"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 border-t pt-6">
                            <div class="flex justify-end gap-3">
                                <Link
                                    :href="
                                        route('projects.products.index', {
                                            project: project.id,
                                        })
                                    "
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                >
                                    <span v-if="!form.processing"
                                        >Create Product</span
                                    >
                                    <span v-else class="flex items-center">
                                        <svg
                                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                class="opacity-25"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                stroke-width="4"
                                            ></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                        Creating...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </MainSideBar>
</template>
