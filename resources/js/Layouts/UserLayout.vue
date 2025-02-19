<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage()

const categories = computed(() => page.props.categories.data)
</script>

<template>
    <div class="container mx-auto h-full flex flex-col">
        <!-- Header -->
        <div class="relative w-full h-[162px] bg-[#1F6391]">
            <div class="flex flex-col justify-around items-center h-full">
                <div class="">
                    <h1 class="text-[white] text-[32px] font-bold">Hệ Thống Bán Lẻ Đồ Điện Gia Dụng</h1>
                </div>
                <div class="flex">
                    <Link 
                        :href="route('user.toppage')"
                        class="text-[white] px-[10px] text-[20px]" 
                    >
                        All product
                    </Link>
                    <div 
                        v-for="category in categories" 
                        :key="category.id" 
                        class="text-[white] px-[10px] text-[20px] cursor-pointer"
                        @click="router.visit(route('user.category.show', category.id))"
                    >
                        <p v-if="category.products.length > 0">
                            {{ category.name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="absolute top-5 right-0 flex justify-around w-[155px]">
                <Link href="">
                    <img src="/Image/Profile.svg" alt="">
                </Link>
                <Link :href="route('user.cart.show')">
                    <img src="/Image/Cart.svg" alt="">
                </Link>
            </div>
        </div>
        <!-- Title -->
        <div class="h-[50px] bg-[#F2F2F2] flex justify-center items-center">
            <p class="text-[32px] text-center">
                <slot name="Title">
                    All product
                </slot>
            </p>
        </div>
        <!-- Main Content -->
        <div class="w-full custom-h-screen bg-white">
            <slot name="Content"/>
        </div>
        <!-- Footer -->
        <div class="w-full h-[74px] bg-[#1F6391] flex justify-center items-center">
            <p class="text-[white] text-[20px] font-bold">
                © 2024 Hệ Thống Bán Lẻ Đồ Điện Gia Dụng
            </p>
        </div>
    </div>
</template>

<style scoped>
.custom-h-screen {
    height: calc(100vh - 286px);
}
</style>