<template>
    <AdminLayout>
        <template #Content>
            <div>
                <h1 class="text-[#1F6391] text-[30px] font-bold">Orders</h1>
                <div>
                    <table class="w-full mt-10">
                        <thead>
                            <tr class="border-b-2">
                                <th class="border-r-2 w-[5%]">No.</th>
                                <th class="border-r-2 w-[10%]">Receiver</th>
                                <th class="border-r-2 w-[15%]">Phone number</th>
                                <th class="border-r-2 w-[20%]">Address</th>
                                <th class="border-r-2 w-[10%]">Total</th>
                                <th class="border-r-2 w-[5%]">Status</th>
                                <th class="border-r-2 w-[10%]">Created at</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="orders.length > 0">
                            <tr v-for="order, index in orders" :key="order.id">
                                <td class="text-center border-r-2">{{ index+1 }}</td>
                                <td class="text-center border-r-2">{{ order.name }}</td>
                                <td class="text-center border-r-2">{{ order.phone_number }}</td>
                                <td class="text-center border-r-2">{{ order.address }}</td>
                                <td class="text-center border-r-2">{{ order.total }} VND</td>
                                <td class="text-center border-r-2">{{ order.status }}</td>
                                <td class="text-center border-r-2">
                                    {{ new Date(order.created_at).toDateString() }}
                                </td>
                                <td class="text-center">
                                    <div>
                                        <el-button @click.prevent="showOrders(order.id)" type="primary">Show</el-button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="">
                                <td colspan="9" class="text-center !w-[100px]">
                                    <p class="mt-[20px]">It's Empty :(</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </AdminLayout>
</template> 

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['orders'])

const orders = props.orders.data

const showOrders = (id) => {
    router.visit(route('admin.orders.show',id))
}
</script>

<style scoped>

</style>
