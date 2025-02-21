<template>
    <div class="w-full h-screen flex flex-col justify-center items-center">
        <p class="text-[20px]">Admin</p>
        <div class="flex flex-col justify-center border p-[30px] rounded-[24px]">
            <div class="flex flex-col">
                <el-form :model="form" label-width="auto">
                    <el-form-item label="Email">
                        <el-input v-model="form.email"/>
                    </el-form-item>
                    <el-form-item label="Password">
                        <el-input v-model="form.password" type="password" show-password/>
                    </el-form-item>
                </el-form>
            </div>
            <el-button type="primary" @click="login">Login</el-button>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ElMessage } from 'element-plus';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({})

const login = () => {
    axios.post(route('api.admin.login'), form.value)
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Login success',
            })
            let redirectUrl = route().params?.url
            if(redirectUrl){
                router.visit(redirectUrl)
            }  else {
                router.visit(route('admin.overview.index'))
            }
        })
        .catch(error => {

        })
}
</script>

<style scoped>

</style>