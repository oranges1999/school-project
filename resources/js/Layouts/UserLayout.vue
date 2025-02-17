<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="container mx-auto h-full flex flex-col">
        <!-- Header -->
        <div class="relative w-full h-[162px] bg-[#1F6391]">
            <slot name="Header"/>
            <div class="absolute top-5 right-0 flex justify-around w-[155px]">
                <Link href="">
                    <img src="/Image/Profile.svg" alt="">
                </Link>
                <Link href="">
                    <img src="/Image/Cart.svg" alt="">
                </Link>
            </div>
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
    height: calc(100vh - 236px);
}
</style>