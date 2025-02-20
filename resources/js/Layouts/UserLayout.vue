<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage()

const categories = computed(() => page.props.categories.data)
const user = computed(() => page.props.auth.user)

const logout = () => {
    axios.post(route('api.user.auth.logout'))
        .then(response => {
            window.location.reload()
        })
        .catch(error => {
            console.log(error)
        })
}

const showSearchResult = ref(false)
const searchResultActive = () => {
    showSearchResult.value = true
}
const searchResultInactive = () => {
    showSearchResult.value = false
}

const search = ref('')
const products = ref()
const getSearchData = () => {
    if(search.value != ''){
        axios.post(route('api.user.search'),{search: search.value})
        .then(response => {
            products.value = response.data
        })
        .catch(error => {

        })
    }
}
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
                    >
                        <div 
                            v-if="category.products.length > 0" 
                            class="text-[white] px-[10px] text-[20px] cursor-pointer"
                            @click="router.visit(route('user.category.show', category.id))"
                        >
                            <p>
                                {{ category.name }}
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="absolute top-5 right-0 flex justify-around w-[155px]">
                <el-dropdown>
                    <img src="/Image/Profile.svg" alt="">
                    <template #dropdown>
                        <el-dropdown-menu v-if="user != null">
                            <el-dropdown-item>
                                <Link :href="route('user.order.index')">Your order</Link>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <Link :href="route('user.profile.index')">Profile</Link>
                            </el-dropdown-item>
                            <el-dropdown-item @click.prevent="logout">
                                Log out
                            </el-dropdown-item>
                        </el-dropdown-menu>
                        <el-dropdown-menu v-else>
                            <el-dropdown-item>
                                <Link :href="route('user.auth.login')">Login</Link>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <Link :href="route('user.auth.register')">Signup</Link>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
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
        <div class="relative flex justify-end">
            <div class="flex">
                <el-input v-model="search" style="width: 240px" placeholder="Search something ..."  @change="getSearchData"/>
                <!-- <el-button 
                    type="primary" 
                    @click.prevent="getSearchData"
                    @blur="searchResultInactive"
                >
                    Search
                </el-button> -->
            </div>
            <div v-if="search != ''" class="absolute top-[100%] bg-[#D9D9D9] w-[315.8px]">
                <template v-for="product, index in products" :key="index">
                    <Link class="flex" :href="route('user.product.show',product.id)">
                        <img :src="product.image" alt="" class="w-[100px]">
                        <div>
                            <p>{{ product.name }}</p>
                            <p>{{ product.price }} VND</p>
                            <p v-if="product.stock == 0" class="text-red-500">Out of stock!</p>
                        </div>
                    </Link>
                </template>
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
    height: calc(100vh - 286px);
}
</style>