<script setup>
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    project: Object,
    order: Object,
});

const subtotal = computed(() => {
    return (
        props.order?.products?.reduce((acc, item) => {
            return (
                acc + (item.product?.selling_price || 0) * (item.quantity || 0)
            );
        }, 0) || 0
    );
});

const totalPrice = computed(() => {
    return Number(props.order?.total_price) || 0;
});

const shipping = computed(() => {
    return totalPrice.value - subtotal.value;
});
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <div class="max-w-4xl mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold">Order Details</h1>
                        <Link
                            :href="
                                route('projects.orders.index', {
                                    project: project.id,
                                })
                            "
                            class="text-blue-600 hover:text-blue-800"
                        >
                            ← Back to Orders
                        </Link>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <h2 class="text-lg font-semibold mb-2">
                                    Order Information
                                </h2>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Order Number:
                                        </dt>
                                        <dd class="font-medium">
                                            {{ order.order_number }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Order Date:
                                        </dt>
                                        <dd>
                                            {{
                                                new Date(
                                                    order.created_at
                                                ).toLocaleDateString()
                                            }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Total Price:
                                        </dt>
                                        <dd class="text-green-600 font-bold">
                                            ${{ order.total_price.toFixed(2) }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold mb-2">
                                    Customer Details
                                </h2>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Name:
                                        </dt>
                                        <dd>{{ order.customer_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Phone:
                                        </dt>
                                        <dd>{{ order.customer_phone }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-600">
                                            Email:
                                        </dt>
                                        <dd>{{ order.customer_email }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h2 class="text-lg font-semibold mb-4">
                                Order Items
                            </h2>
                            <div class="space-y-4">
                                <div
                                    v-for="(item, index) in order.products"
                                    :key="index"
                                    class="flex items-center justify-between bg-gray-50 p-4 rounded-lg"
                                >
                                    <div class="flex items-center space-x-4">
                                        <img
                                            v-if="item.product.image"
                                            :src="`/storage/${item.product.image}`"
                                            class="h-16 w-16 object-cover rounded"
                                        />
                                        <div>
                                            <h3 class="font-medium">
                                                {{ item.product.name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                Quantity: {{ item.quantity }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">
                                            ${{
                                                (
                                                    item.product.selling_price *
                                                    item.quantity
                                                ).toFixed(2)
                                            }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            ${{
                                                item.product.selling_price.toFixed(
                                                    2
                                                )
                                            }}
                                            each
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium"
                                    >${{ subtotal.toFixed(2) }}</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping:</span>
                                <span class="font-medium"
                                    >${{ shipping.toFixed(2) }}</span
                                >
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="font-semibold">Total:</span>
                                <span class="font-bold text-green-600"
                                    >${{ totalPrice.toFixed(2) }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainSideBar>
</template>
