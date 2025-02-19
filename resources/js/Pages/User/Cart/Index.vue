<template>
    <UserLayout>
        <template #Title>Cart</template>
        <template #Content>
            <div class="w-full h-full flex justify-center ">
                <el-form
                    :model="form"
                    style="width: 600px"
                    label-width="120px"
                    class="mt-10"
                >
                    <el-form-item label="Name" prop="name">
                        <el-input v-model="form.name"/>
                        <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Phone number" prop="phone_number">
                        <el-input v-model="form.phone_number"/>
                        <p v-if="errors.phone_number" class="text-red-500">{{ errors.phone_number[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Address" prop="address">
                        <el-input v-model="form.address"/>
                        <p v-if="errors.address" class="text-red-500">{{ errors.address[0] }}</p>
                    </el-form-item>
                    <table class="w-full border-collapse border border-gray-400">
                        <thead>
                            <th class="border border-gray-300">Product</th>
                            <th class="border border-gray-300">Price</th>
                            <th class="border border-gray-300">Qty</th>
                            <th class="border border-gray-300">Total</th>
                        </thead>
                        <tbody>
                            <tr v-for="product, index in cart" :key="index">
                                <td class="text-center border border-gray-300">{{ product.name }}</td>
                                <td class="text-center border border-gray-300">{{ product.price }} VND</td>
                                <td class="text-center border border-gray-300">{{ product.qty }}</td>
                                <td class="text-center border border-gray-300">{{ product.price * product.qty }} VND</td>
                            </tr>
                        </tbody>
                        <tfoot class="border border-gray-300">
                            <tr>
                                <td colspan="3" class="text-[20px] font-bold text-center">Total</td>
                                <td colspan="3" class="text-[20px] font-bold text-center">{{ cartSummary }} VND</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="w-full flex justify-center">
                        <el-button type="primary" @click.prevent="submitForm">Create</el-button>
                    </div>
                </el-form>
           </div>
        </template>
    </UserLayout>
</template> 

<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { ElMessage } from 'element-plus';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3';

const cart = ref(JSON.parse(localStorage.getItem('cart'))??[])
const cartSummary = ref(0)
cart.value.forEach(element => {
    cartSummary.value += element.qty * element.price
});

let productId = []
cart.value.forEach(product => {
    productId.push(product.id)
});

const form = ref({
    total: cartSummary.value,
    product: productId
})

const errors = ref({})

const submitForm = () => {
    if(cart.value.length > 0){
        axios.post(route('api.user.order.store'),form.value)
            .then(response => {
                localStorage.removeItem('cart')
                router.visit(route('user.toppage'))
                ElMessage({
                    type: 'success',
                    message: 'Order has been placed',
                })
            })
            .catch(error => {
                errors.value = error.response.data.errors
                ElMessage({
                    type: 'error',
                    message: 'Something wrong, please check again',
                })
            })
    } else {
        ElMessage({
            type: 'error',
            message: 'Your cart is empty',
        })
    }
}
</script>

<style scoped>

</style>