<template>
    <UserLayout>
        <template #Title>{{ product.name }}</template>
        <template #Content>
            <div class="mt-[10px] h-full flex flex-col items-center overflow-y-scroll">
                <img 
                    :src="product.image" 
                    alt="" 
                    class="w-[400px] h-[400px] rounded-[24px]"    
                />
                <p class="text-[25px]">Price: {{ product.price }}</p>
                <!-- <el-button @click.prevent="addToCart(product.id)" type="primary">
                    Add to cart
                </el-button> -->
                <el-button type="primary" @click.prevent="open(product.id)">Add to cart</el-button>
                <p class="text-[20px] !text-wrap">{{ product.description }}</p>
            </div>
        </template>
    </UserLayout>
</template>

<script setup>
import { h, ref } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { ElMessageBox, ElMessage, ElInputNumber } from 'element-plus'

const props = defineProps(['product']);
const product = ref(props.product.data);

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
    ElMessageBox.confirm(
        () => h(ElInputNumber, {
            modelValue: qty.value,
            'onUpdate:modelValue': (val) => {
            qty.value = val
            },
        }),
        'Add to cart',
        {
            confirmButtonText: 'Add',
            cancelButtonText: 'Cancel',
            type: 'success',
            center: true,
        }
    )
        .then(() => {
            addToCart(id, qty.value)
        })
        .catch(() => {
        })
}
</script>