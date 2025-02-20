<script setup>
    import { ref } from 'vue';
    import UserLayout from '@/Layouts/UserLayout.vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps(['categories']);

    const categories = ref(props.categories.data);
</script>

<template>
    <UserLayout>
        <template #Content>
            <div class="flex flex-col h-full overflow-y-scroll">
                
                <div v-for="category in categories" :key="category.id">
                    <div v-if="category.products.length > 0">
                        <h2 class="text-[24px] font-bold">{{ category.name }}</h2>
                        <div class="flex overflow-x-scroll">
                            <div 
                                v-for="product, index in category.products" 
                                :key="product.id"
                            >
                                <Link
                                    :href="route('user.product.show', product.id)"
                                    v-if="index <= 5"
                                    class="flex flex-col items-center min-w-[300px] h-[400px] border-2 border-[#333] rounded-[24px] m-[10px] cursor-pointer"
                                >
                                    <div>
                                        <img 
                                            :src="product.image" 
                                            alt="" 
                                            class="w-[300px] h-[300px] rounded-t-[24px]"    
                                        />
                                    </div>
                                    <div class="h-full w-full flex flex-col justify-center items-center">
                                        <p v-if="product.stock > 0" class="text-[20px]">Price: {{ product.price }} VND</p>
                                        <p v-else class="text-[20px] text-red-500">Out of stock</p>
                                        <h3 class="text-[20px] font-bold">{{ product.name }}</h3>
                                    </div>
                                </Link>
                            </div>
                            <Link :href="route('user.category.show', category.id)" v-if="category.products.length > 6" class="flex items-center justify-center min-w-[300px] h-[400px] border-2 border-[#333] rounded-[24px] m-[10px] cursor-pointer">
                                <h3 class="text-[20px] font-bold">More</h3>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </UserLayout>
</template>

<style scoped>

</style>