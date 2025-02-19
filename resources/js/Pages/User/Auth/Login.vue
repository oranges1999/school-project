<template>
    <UserLayout>
        <template #Title>Login</template>
        <template #Content>
            <div class="w-full h-full flex justify-center items-center">
                <div class="bg-[#F8F8F8] p-[20px] border rounded-[12px]">
                    <el-form
                        :model="form"
                        style="width: 500px"
                        label-width="120px"
                    >
                        <el-form-item label="Email" prop="email">
                            <el-input v-model="form.email"></el-input>
                            <p v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Password" prop="password">
                            <el-input v-model="form.password"></el-input>
                            <p v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</p>
                        </el-form-item>
                        <div class="flex flex-col items-center">
                            <div class="w-full">
                                <el-button type="primary" @click.prevent="submitForm" class="w-full">Login</el-button>
                            </div>
                            <div class="w-full mt-[10px] cursor-pointer" @click.prevent="toSignupPage">
                                <p class="text-[14px] text-center">Signup</p>
                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </template>
    </UserLayout>
</template>

<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3';

const form = ref({})
const errors = ref({})

const submitForm = () => {
    console.log('dsadas')
}

const toSignupPage = () => {
    router.visit(route('user.auth.register'))
}
</script>

<style scoped>

</style>