<template>
    <AdminLayout>
        <template #Content>
            <div class="w-full p-[20px]">
                <div class="p-[5px] bg-[#F0EFEF]">
                    <p class="font-bold">Receiver information</p>
                    <div class="grid grid-cols-3">
                        <div>Name: {{ order.name }}</div>
                        <div>Phone number: {{ order.phone_number }}</div>
                        <div>Address: {{ order.address }}</div>
                        <div>Date: {{ new Date(order.created_at).toDateString() }}</div>
                        <div>Shipper: {{ order.admin_id }}</div>
                        <div>Status: {{ order.status }}</div>
                    </div>
                </div>
                <table class="w-full border-2">
                    <thead class="border-b-2">
                        <th class="border-r-2">No.</th>
                        <th class="border-r-2">Product</th>
                        <th class="border-r-2">Qty</th>
                        <th class="border-r-2">Price</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <tr v-for="product, index in order.products" :key="index">
                            <td class="text-center border-r-2">{{ index+1 }}</td>
                            <td class="text-center border-r-2">{{ product.name }}</td>
                            <td class="text-center border-r-2">{{ product.pivot.qty }}</td>
                            <td class="text-center border-r-2">{{ product.pivot.price }} VND</td>
                            <td class="text-center">{{ product.pivot.qty * product.pivot.price }} VND</td>
                        </tr>
                    </tbody>
                    <tfoot class="border-t-2">
                        <tr>
                            <td colspan="4" class="text-center border-r-2 font-bold">Total</td>
                            <td class="text-center">{{ orderSummary }} VND</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </template>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps(['orders'])
const order = ref(props.orders.data)

const orderSummary = ref(0)
order.value.products.forEach((product) => {
    orderSummary.value += (product.pivot.price * product.pivot.qty)
})
</script>

<style scoped>

</style>