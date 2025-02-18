<script setup>
    import { ref } from 'vue';
    import UserLayout from '@/Layouts/UserLayout.vue';
    import { Link } from '@inertiajs/vue3'

    const props = defineProps(['categories', 'category']);

    const categories = ref(props.categories.data);
    const category = ref(props.category.data);
</script>

<template>
    <UserLayout>
        <template #Title>{{ category.name }}</template>
        <template #Content>
            <div class="flex flex-wrap justify-around h-full overflow-y-scroll">
                <div class="flex " v-for="product in category.products" :key="product.id">
                    <Link 
                        :href="route('user.product.show', product.id)"
                        class="flex flex-col items-center min-w-[300px] h-[400px] border-2 border-[#333] rounded-[24px] m-[10px]"
                    >
                        <div>
                            <img 
                                :src="product.image" 
                                alt="" 
                                class="w-[300px] h-[300px] rounded-t-[24px]"    
                            />
                        </div>
                        <div class="h-full w-full flex flex-col justify-center items-center">
                            <p class="text-[20px]">Price: {{ product.price }} VND</p>
                            <h3 class="text-[20px] font-bold">{{ product.name }}</h3>
                        </div>
                    </Link>  
                </div>
            </div>
        </template>
    </UserLayout>
</template>

<style scoped>

</style>