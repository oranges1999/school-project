<template>
    <UserLayout>
        <template #Title>Orders</template>
        <template #Content>
            <div class="h-full w-full">
                <table class="w-full">
                    <thead class="border-b-2">
                        <th class="border-r-2">No.</th>
                        <th class="border-r-2">Product</th>
                        <th class="border-r-2">Total</th>
                        <th class="">Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="order, index in orders" :key="index">
                            <td class="border-r-2">{{ index + 1 }}</td>
                            <td class="border-r-2">
                                <p v-if="order.products.length > 1">
                                    {{ order.products.length }} products
                                </p>
                                <p v-else>
                                    {{ order.products[0].name }}
                                </p>
                            </td>
                            <td class="border-r-2">{{ order.total }}</td>
                            <td class="text-center">
                                <el-button type="primary" @click.prevent="showOrder(order.id)">Show</el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </UserLayout>
</template>

<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['orders'])
const showOrder = (id) => {
    router.visit(route('user.order.show',id))
}
</script>

<style scoped>

</style>