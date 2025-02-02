<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";

const props = defineProps({
    project: Object,
    products: Array,
});

const selectedProducts = ref([]);
const currentProduct = ref(null);
const quantity = ref(1);

const form = useForm({
    order_number: `ORD-${Date.now()}`,
    customer_name: "",
    customer_phone: "",
    customer_email: "",
    products: [],
    shipping_amount: 0,
    total_price: 0,
});

const totalPrice = computed(() => {
    const subtotal = selectedProducts.value.reduce((sum, item) => {
        return sum + item.product.selling_price * item.quantity;
    }, 0);

    return subtotal + Number(form.shipping_amount);
});

const updatePrices = () => {
    const subtotal = selectedProducts.value.reduce((sum, item) => {
        return sum + item.product.selling_price * item.quantity;
    }, 0);

    form.total_price = subtotal + Number(form.shipping_amount);
};

const addProduct = () => {
    if (!currentProduct.value || quantity.value < 1) return;

    selectedProducts.value.push({
        product: currentProduct.value,
        quantity: quantity.value,
    });

    form.products = selectedProducts.value.map((item) => ({
        id: item.product.id,
        quantity: item.quantity,
    }));

    form.total_price = totalPrice.value;
    currentProduct.value = null;
    quantity.value = 1;
    updatePrices();
};

const removeProduct = (index) => {
    selectedProducts.value.splice(index, 1);
    form.products = selectedProducts.value.map((item) => ({
        id: item.product.id,
        quantity: item.quantity,
    }));
    form.total_price = totalPrice.value;
    updatePrices();
};

const submit = () => {
    form.post(route("projects.orders.store", { project: props.project.id }), {
        preserveScroll: true,
        onError: (errors) => {
            console.error("Order creation failed:", errors);
        },
        onSuccess: () => {
            form.reset();
            selectedProducts.value = [];
        },
    });
};
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-2xl font-bold mb-8">Create New Order</h1>

                    <!-- Customer Details -->
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Order Number</label
                                >
                                <input
                                    v-model="form.order_number"
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Customer Name *</label
                                >
                                <input
                                    v-model="form.customer_name"
                                    required
                                    type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm"
                                />
                                <p
                                    v-if="form.errors.customer_name"
                                    class="text-red-500 text-sm mt-1"
                                >
                                    {{ form.errors.customer_name }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Customer Phone *</label
                                >
                                <input
                                    v-model="form.customer_phone"
                                    required
                                    type="tel"
                                    class="w-full rounded-md border-gray-300 shadow-sm"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Customer Email</label
                                >
                                <input
                                    v-model="form.customer_email"
                                    type="email"
                                    class="w-full rounded-md border-gray-300 shadow-sm"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Shipping Amount
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                    >
                                        <span class="text-gray-500 sm:text-sm"
                                            >$</span
                                        >
                                    </div>
                                    <input
                                        v-model="form.shipping_amount"
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        class="block w-full pl-7 pr-12 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        @input="updatePrices"
                                    />
                                </div>
                                <p
                                    v-if="form.errors.shipping_amount"
                                    class="text-red-500 text-sm mt-1"
                                >
                                    {{ form.errors.shipping_amount }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Selection -->
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <div class="flex gap-4 mb-4">
                            <select
                                v-model="currentProduct"
                                class="flex-1 rounded-md border-gray-300 shadow-sm"
                            >
                                <option :value="null">Select Product</option>
                                <option
                                    v-for="product in products"
                                    :key="product.id"
                                    :value="product"
                                >
                                    {{ product.name }} (${{
                                        product.selling_price
                                    }})
                                </option>
                            </select>
                            <input
                                v-model.number="quantity"
                                type="number"
                                min="1"
                                class="w-24 rounded-md border-gray-300 shadow-sm"
                            />
                            <button
                                @click="addProduct"
                                type="button"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                            >
                                Add Product
                            </button>
                        </div>

                        <!-- Selected Products -->
                        <div
                            v-if="selectedProducts.length > 0"
                            class="border-t pt-4"
                        >
                            <div
                                v-for="(item, index) in selectedProducts"
                                :key="index"
                                class="flex items-center justify-between mb-2"
                            >
                                <div class="flex items-center gap-4">
                                    <img
                                        v-if="item.product.image"
                                        :src="`/storage/${item.product.image}`"
                                        class="h-12 w-12 object-cover rounded"
                                    />
                                    <div>
                                        <div class="font-medium">
                                            {{ item.product.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ item.quantity }} x ${{
                                                item.product.selling_price
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="font-medium">
                                        ${{
                                            (
                                                item.quantity *
                                                item.product.selling_price
                                            ).toFixed(2)
                                        }}
                                    </div>
                                    <button
                                        @click="removeProduct(index)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">Subtotal:</div>
                                <div>
                                    ${{
                                        (
                                            totalPrice - form.shipping_amount
                                        ).toFixed(2)
                                    }}
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-gray-600">Shipping:</div>
                                <div>
                                    ${{
                                        Number(form.shipping_amount).toFixed(2)
                                    }}
                                </div>
                            </div>
                            <div
                                class="flex justify-between items-center border-t pt-4"
                            >
                                <div class="text-lg font-bold">
                                    Total Price:
                                </div>
                                <div class="text-2xl font-bold">
                                    ${{ totalPrice.toFixed(2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        @click="submit"
                        :disabled="form.processing"
                        class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600"
                    >
                        Create Order
                    </button>
                </div>
            </div>
        </div>
    </MainSideBar>
</template>
