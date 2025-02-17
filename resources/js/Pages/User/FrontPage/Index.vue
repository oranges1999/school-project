<script setup>
    import { ref } from 'vue';
    import UserLayout from '@/Layouts/UserLayout.vue';
    import { Link } from '@inertiajs/vue3'

    const navLinks = ref([
        {
            name: 'All products',
            href: '/',
            isActive: false
        },
        {
            name: 'Fryer',
            href: '/fryer',
            isActive: true
        },
        {
            name: 'Electric Hotpot',
            href: '/electric-hotpot',
            isActive: false
        },
        {
            name: 'Heater',
            href: '/heater',
            isActive: false
        },
        {
            name: 'Iron',
            href: '/iron',
            isActive: false
        },
        {
            name: 'Hydroelectric Tank',
            href: '/hydroelectric-tank',
            isActive: false
        },
    ])
</script>

<template>
    <UserLayout>
        <template #Header>
            <div class="flex flex-col justify-around items-center h-full">
                <div class="">
                    <h1 class="text-[white] text-[32px] font-bold">Hệ Thống Bán Lẻ Đồ Điện Gia Dụng</h1>
                </div>
                <div>
                    <Link 
                        v-for="link, index in navLinks" 
                        :key="index" 
                        href=""
                        class="text-[white] px-[10px] text-[20px]" 
                    >
                        {{ link.name }}
                    </Link>
                </div>
            </div>
        </template>
        <template #Content>
            <div class="flex justify-center items-center h-full">
                <h1 class="text-[#1F6391] text-[30px] font-bold">Trang chủ</h1>
            </div>
        </template>
    </UserLayout>
</template>

<style scoped>

</style>