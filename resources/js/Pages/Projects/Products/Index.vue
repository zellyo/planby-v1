<script setup>
import { Link } from "@inertiajs/vue3";
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
//import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

defineProps({
    project: Object,
    products: Array,
});

const deleteProduct = (projectId, productId) => {
    if (confirm("Are you sure you want to delete this product?")) {
        router.delete(
            route("projects.products.destroy", {
                project: projectId,
                product: productId,
            })
        );
    }
};

const isDeleteModalOpen = ref(false);
const productToDelete = ref(null);
const deleteConfirmationText = ref("");

const openDeleteModal = (product) => {
    productToDelete.value = product;
    isDeleteModalOpen.value = true;
};

const confirmDelete = () => {
    if (deleteConfirmationText.value === "Delete") {
        router.delete(
            route("projects.products.destroy", {
                project: props.project.id,
                product: productToDelete.value.id,
            }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    isDeleteModalOpen.value = false;
                    deleteConfirmationText.value = "";
                },
            }
        );
    }
};
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">
                        {{ project.name }} Products
                    </h1>
                    <Link
                        :href="
                            route('projects.products.create', {
                                project: project.id,
                            })
                        "
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    >
                        Create New Product
                    </Link>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Image
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Quantity
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Price
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="product in products" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img
                                        v-if="product.image"
                                        :src="`/storage/${product.image}`"
                                        class="h-12 w-12 object-cover rounded"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ product.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${{ product.selling_price }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap space-x-2"
                                >
                                    <Link
                                        :href="
                                            route('projects.products.show', {
                                                project: project.id,
                                                product: product.id,
                                            })
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        View
                                    </Link>
                                    <button
                                        @click="openDeleteModal(product)"
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
        </div>
        <!-- Delete Confirmation Modal -->
        <TransitionRoot as="template" :show="isDeleteModalOpen">
            <Dialog
                as="div"
                class="relative z-10"
                @close="isDeleteModalOpen = false"
            >
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div
                        class="fixed inset-0 bg-black bg-opacity-25 transition-opacity"
                    />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div
                        class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                    >
                        <TransitionChild
                            as="template"
                            enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        >
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                            >
                                <div>
                                    <div
                                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100"
                                    >
                                        <ExclamationTriangleIcon
                                            class="h-6 w-6 text-red-600"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <DialogTitle
                                            as="h3"
                                            class="text-lg font-medium leading-6 text-gray-900"
                                        >
                                            Delete Product
                                        </DialogTitle>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete
                                                the product
                                                <span class="font-semibold">{{
                                                    productToDelete?.name
                                                }}</span
                                                >? This action cannot be undone.
                                            </p>
                                        </div>
                                        <div class="mt-4">
                                            <input
                                                v-model="deleteConfirmationText"
                                                type="text"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Type 'Delete' to confirm"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"
                                >
                                    <button
                                        type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:col-start-1 sm:text-sm"
                                        @click="isDeleteModalOpen = false"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="button"
                                        :disabled="
                                            deleteConfirmationText !== 'Delete'
                                        "
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed sm:col-start-2 sm:text-sm"
                                        @click="confirmDelete"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </MainSideBar>
</template>
