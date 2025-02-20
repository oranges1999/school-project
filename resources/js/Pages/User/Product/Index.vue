<template>
    <UserLayout>
        <template #Title>{{ product.name }}</template>
        <template #Content>
            <div class="flex h-full flex-col items-center overflow-y-scroll">
                <div class="pt-[10px]  flex flex-col items-center">
                    <img 
                        :src="product.image" 
                        alt="" 
                        class="w-[400px] h-[400px] rounded-[24px]"    
                    />
                    <p class="text-[25px]">Price: {{ product.price }}</p>
                    <el-button
                        v-if="product.stock > 0"
                        type="primary" 
                        @click.prevent="open(product.id)"
                    >
                        Add to cart
                    </el-button>
                    <p v-else class="text-[25px] text-red-500">Out of stock</p>
                    <p class="text-[20px] !text-wrap">{{ product.description }}</p>
                </div>
                <div class="flex justify-between w-[500px]">
                    <el-input :disabled="user == null" v-model="comment" class="!w-[400px]" :placeholder="user == null?'Log in to leave a comment':'Leave a comment ...'"/>
                    <el-button v-if="user == null" type="primary" @click.prevent="toLogin">Login</el-button>
                    <el-button v-else type="primary" @click.prevent="postComment">Comment</el-button>
                </div>
                <div class="w-full">
                    <h2 class="text-[24px] font-bold">Comments</h2>
                    <div v-for="comment in product.comments" :key="comment.id" class="flex w-full my-[10px]">
                        <div class="border-r-2">
                            <p class="text-[20px] mr-[10px]">{{ comment.author.name }}</p>
                            <p class="text-[20px] mr-[10px]">{{ comment.author.email }}</p>
                        </div>
                        <div class="flex w-full justify-between">
                            <i class="ml-[10px] text-[20px]">{{ comment.content }}</i>
                            <div v-if="user != null && comment.author.id == user.id" class="flex justify-center items-center">
                                <el-button type="danger" @click.prevent="confirmDeleteComment(comment.id)">Delete</el-button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </template>
    </UserLayout>
</template>

<script setup>
import { h, ref } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { ElMessageBox, ElMessage, ElInputNumber } from 'element-plus'
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const user = page.props.auth.user;
const props = defineProps(['product']);
const product = ref(props.product.data);

const apiGetProductData = () => {
    axios.get(route('api.user.product.show', product.value.id))
    .then(response => {
        product.value = response.data
    })
    .catch(error => {
        console.log(error)
        ElMessage({
            type: 'error',
            message: 'An error occurred',
            grouping: true
        })
    })
}

const cart = ref(JSON.parse(localStorage.getItem('cart'))??[])

const addToCart = (id, qty) => {
    let index = cart.value.findIndex(product => product.id == id)
    if(index != -1){
        cart.value[index].qty += qty
    } else {
        let item = { 
            id: id, 
            image:product.value.image,
            name: product.value.name,
            price: product.value.price,
            max: product.value.stock,
            qty: qty
        }
        cart.value.push(item)
    }
    ElMessage({
        type: 'success',
        message: 'Add to cart success',
        grouping: true
    })
    localStorage.setItem('cart', JSON.stringify(cart.value))
}

const open = (id) => {
    const qty = ref(1)
    const max = ref(product.value.stock)
    ElMessageBox.confirm(
        () => h(ElInputNumber, {
            modelValue: qty.value,
            'onUpdate:modelValue': (val) => {
                if(val > max.value){
                    qty.value = max.value
                } else {
                    qty.value = val
                }
            },
        }),
        'Stock: ' + product.value.stock,
        {
            confirmButtonText: 'Add',
            cancelButtonText: 'Cancel',
            type: 'info',
            center: true,
        }
    )
    .then(() => {
        addToCart(id, qty.value)
    })
    .catch(() => {
    })
}

const toLogin = () => {
    router.visit(route('user.auth.login',{url:window.location.href}))
}

const comment = ref('')
const postComment = () => {
    axios.post(route('api.user.comment.store', product.value.id),{content: comment.value})
    .then(response => {
        ElMessage({
            type: 'success',
            message: 'Comment success',
            grouping: true
        })
        comment.value = ''
        apiGetProductData()
    })
    .catch(error => {
        ElMessage({
            type: 'error',
            message: 'An error occurred',
            grouping: true
        })
    })
}

const confirmDeleteComment = (id) => {
    ElMessageBox.confirm(
        'Are you sure to delete this comment?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
    .then(() => {
        axios.delete(route('api.user.comment.destroy',id))
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Delete comment success',
                grouping: true
            })
            apiGetProductData()
        })
        .catch(error => {
            ElMessage({
                type: 'error',
                message: 'An error occurred',
                grouping: true
            })
        })
    })
    .catch(() => {
    })
}
</script>