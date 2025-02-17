<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex">
        <div class="h-screen w-[262px] bg-[#1F6391] flex flex-col">
            <Link class="text-[white] px-[10px] text-[20px] font-bold" href="">
                Category
            </Link>
        </div>
        <div class="w-full">
            <slot name="Content"></slot>
        </div>
    </div>
</template>

<style scoped>

</style>