<template>
    <UserLayout>
        <template #Title>Signup</template>
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
                        <el-form-item label="Name" prop="name">
                            <el-input v-model="form.name"></el-input>
                            <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Phone number" prop="phone_number">
                            <el-input v-model="form.phone_number"></el-input>
                            <p v-if="errors.phone_number" class="text-red-500">{{ errors.phone_number[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Address" prop="address">
                            <el-input v-model="form.address"></el-input>
                            <p v-if="errors.address" class="text-red-500">{{ errors.address[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Password" prop="password">
                            <el-input v-model="form.password" type="password" show-password></el-input>
                            <p v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Confirm" prop="password_confirmation">
                            <el-input v-model="form.password_confirmation" type="password" show-password></el-input>
                            <p v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</p>
                        </el-form-item>
                        <div class="flex flex-col items-center">
                            <div class="w-full">
                                <el-button type="primary" @click.prevent="submitForm" class="w-full">Signup</el-button>
                            </div>
                            <div class="w-full mt-[10px] cursor-pointer" @click.prevent="toLoginPage">
                                <p class="text-[14px] text-center">Login</p>
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
import { ElMessage } from 'element-plus'

const form = ref({})
const errors = ref({})

const submitForm = () => {
    errors.value = {}
    axios.post(route('api.user.auth.register'),form.value)
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Signup complete',
            })
            router.visit(route('user.auth.login'));
        })
        .catch(error => {
            if(error.response.data.errors){
                errors.value = error.response.data.errors
            }

            if(error.response.data.error){
                ElMessage({
                    type: 'error',
                    message: error.response.data.error,
                })
            }
        })
}

const toLoginPage = () => {
    router.visit(route('user.auth.login'))
}
</script>

<style scoped>

</style>