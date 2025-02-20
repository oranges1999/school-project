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
                    <div v-if="user != null">
                        <el-form-item label="Name" prop="name">
                            <el-input v-model="user.name"/>
                            <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Phone number" prop="phone_number">
                            <el-input v-model="user.phone_number"/>
                            <p v-if="errors.phone_number" class="text-red-500">{{ errors.phone_number[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Address" prop="address">
                            <el-input v-model="user.address"/>
                            <p v-if="errors.address" class="text-red-500">{{ errors.address[0] }}</p>
                        </el-form-item>
                    </div>
                    <table class="w-full border-collapse border border-gray-400">
                        <thead>
                            <th class="border border-gray-300">Product</th>
                            <th class="border border-gray-300">Price</th>
                            <th class="border border-gray-300">Qty</th>
                            <th class="border border-gray-300">Total</th>
                            <th class="border border-gray-300">Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="product, index in cart" :key="index">
                                <td class="text-center border border-gray-300">{{ product.name }}</td>
                                <td class="text-center border border-gray-300">{{ product.price }} VND</td>
                                <td class="text-center border border-gray-300">
                                    <el-input-number v-model="product.qty" :min="1" :max="product.max" @change="calculateTotal()" />
                                </td>
                                <td class="text-center border border-gray-300">{{ product.price * product.qty }} VND</td>
                                <td class="text-center border border-gray-300">
                                    <el-button type="danger" @click.prevent="openConfirmDelete(index)">Delete</el-button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="border border-gray-300">
                            <tr>
                                <td colspan="3" class="text-[20px] font-bold text-center">Total</td>
                                <td colspan="3" class="text-[20px] font-bold text-center">{{ cartSummary }} VND</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div v-if="user === null" class="w-full flex flex-col items-center justify-center">
                        <p>Login to place order</p>
                        <el-button type="primary" @click.prevent="toLoginPage">Login</el-button>
                    </div>
                    <div v-else class="w-full flex justify-center">
                        <el-button type="primary" @click.prevent="submitForm">Create</el-button>
                    </div>
                </el-form>
           </div>
        </template>
    </UserLayout>
</template> 

<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { ElMessage, ElMessageBox } from 'element-plus';
import { computed, ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3';

const cart = ref(JSON.parse(localStorage.getItem('cart'))??[])
const page = usePage()
const user = computed(() => page.props.auth.user)
const cartSummary = ref(0)
const calculateTotal = () => {
    cartSummary.value = 0
    cart.value.forEach(element => {
        cartSummary.value += element.qty * element.price
    });
}
calculateTotal()


const form = ref({
    total: cartSummary.value,
    product: cart.value,
})

const errors = ref({})

const submitForm = () => {
    const formData = ref({
        ...form.value,
        ...user.value,
    })
    if(cart.value.length > 0){
        axios.post(route('api.user.order.store'),formData.value)
            .then(response => {
                localStorage.removeItem('cart')
                router.visit(route('user.toppage'))
                ElMessage({
                    type: 'success',
                    message: 'Order has been placed',
                })
            })
            .catch(error => {
                const message = ref("An error occurred")
                if(error.response.status == 422){
                    errors.value = error.response.data.errors
                } else {
                    message.value = error.response.data.message
                }
                ElMessage({
                    type: 'error',
                    message: message.value,
                })
            })
    } else {
        ElMessage({
            type: 'error',
            message: 'Your cart is empty',
        })
    }
}

const openConfirmDelete = (index) => {
    ElMessageBox.confirm(
    'Are you sure to remove this item from cart?',
    'Warning',
    {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
    }
    )
    .then(() => {
        cart.value.splice(index, 1)
        localStorage.setItem('cart', JSON.stringify(cart.value))
        calculateTotal()
    })
    .catch(() => {
    })
}

const toLoginPage = () => {
    let currentUrl = window.location.href
    router.visit(route('user.auth.login',{url:currentUrl}))
}
</script>

<style scoped>

</style>