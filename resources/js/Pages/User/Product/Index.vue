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
                <p class="text-[20px]">{{ product.description }}</p>
            </div>
        </template>
    </UserLayout>
</template>

<script setup>
import { ref } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';

const props = defineProps(['product']);
const product = ref(props.product.data);
</script>

<style scoped>

</style>