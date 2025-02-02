<script setup>
import MainSideBar from "@/Layouts/MainSideBar.vue";
import SubSidebar from "@/Layouts/SubSidebar.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    project: Object,
    orders: Array,
});
</script>

<template>
    <MainSideBar>
        <div class="flex flex-1">
            <SubSidebar :project="project" />
            <div class="flex-1 p-8 bg-gray-50">
                <!-- Added Create New Order Button -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Completed Orders</h1>
                    <Link
                        :href="
                            route('projects.orders.create', {
                                project: project.id,
                            })
                        "
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    >
                        Create New Order
                    </Link>
                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Order #
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Customer
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Total
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="order in orders" :key="order.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ order.order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium">
                                        {{ order.customer_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ order.customer_email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${{ order.total_price.toFixed(2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{
                                        new Date(
                                            order.created_at
                                        ).toLocaleDateString()
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Link
                                        :href="
                                            route('projects.orders.show', {
                                                project: project.id,
                                                order: order.id,
                                            })
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        View Details
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </MainSideBar>
</template>
