<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const navLinks = ref([
    {
        title: 'Category',
        route: 'admin.categories.index'
    },
    {
        title: 'Product',
        route: 'admin.products.index'
    },
    {
        title: 'Order',
        route: 'admin.orders.index'
    }
])

</script>

<template>  
    <div class="flex">
        <div class="h-screen w-[262px] bg-[#1F6391] flex flex-col">
            <Link v-for="link, index in navLinks" :key="index" class="text-[white] px-[10px] text-[20px] font-bold" :href="route(link.route)">
                {{ link.title }}
            </Link>
        </div>
        <div class="w-full">
            <slot name="Content"></slot>
        </div>
    </div>
</template>