<script setup>
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import { ElMessage } from 'element-plus';

const page = usePage()

const user = computed(() => page.props.auth.user)


const errors = ref({})

const submitForm = () => {
    let formData = new FormData()
    formData.append('name', user.value.name)
    formData.append('phone_number', user.value.phone_number)
    formData.append('address', user.value.address)
    formData.append('_method', 'PUT')
    axios.post(route('api.user.profile.update',user.value.id), formData)
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Change profile succeed',
                grouping: true
            })
            errors.value = {}
        })
        .catch(error => {
            errors.value = error.response.data.errors
        })
}

const form = ref({})
const passErrors = ref({})

const changePassword = () => {
    let formData = new FormData()
    Object.keys(form.value).forEach((key) => {
        formData.append(key, form.value[key])
    })
    formData.append('_method', 'PUT')
    axios.post(route('api.user.profile.change-password', user.value.id), formData)
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Change password succeed',
                grouping: true
            })
            passErrors.value = {}
            form.value = {}
        })
        .catch(error => {
            passErrors.value = error.response.data.errors
        })
}
</script>

<template>
    <UserLayout>
        <template #Title>Profile</template>
        <template #Content>
            <div class="h-full w-full flex">
                <div class="w-[50%] flex flex-col items-center border-r-2">
                    <p class="my-[10px]">Account information</p>
                    <el-form
                        :model="form"
                        style="width: 400px"
                        label-width="120px"
                    >
                        <el-form-item label="Email" prop="email">
                            <el-input v-model="user.email" disabled></el-input>
                        </el-form-item>
                        <el-form-item label="Name" prop="name">
                            <el-input v-model="user.name"></el-input>
                            <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Phone number" prop="phone_number">
                            <el-input v-model="user.phone_number"></el-input>
                            <p v-if="errors.phone_number" class="text-red-500">{{ errors.phone_number[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Address" prop="address">
                            <el-input v-model="user.address"></el-input>
                            <p v-if="errors.address" class="text-red-500">{{ errors.address[0] }}</p>
                        </el-form-item>
                        <div class="flex flex-col items-center">
                            <div class="w-full">
                                <el-button type="primary" @click.prevent="submitForm" class="w-full">Change information</el-button>
                            </div>
                        </div>
                    </el-form>
                </div>
                <div class="w-[50%] flex flex-col items-center">
                    <p class="my-[10px]">Password change</p>
                    <el-form
                        :model="form"
                        style="width: 400px"
                        label-width="120px"
                    >
                        <el-form-item label="Old password" prop="old_password">
                            <el-input v-model="form.old_password" type="password" show-password></el-input>
                            <p v-if="passErrors.old_password" class="text-red-500">{{ passErrors.old_password[0] }}</p>
                        </el-form-item>
                        <el-form-item label="New password" prop="new_password">
                            <el-input v-model="form.new_password" type="password" show-password></el-input>
                            <p v-if="passErrors.new_password" class="text-red-500">{{ passErrors.new_password[0] }}</p>
                        </el-form-item>
                        <el-form-item label="Confirm" prop="confirm_password">
                            <el-input v-model="form.confirm_password" type="password" show-password></el-input>
                            <p v-if="passErrors.confirm_password" class="text-red-500">{{ passErrors.confirm_password[0] }}</p>
                        </el-form-item>
                        <div class="flex flex-col items-center">
                            <div class="w-full">
                                <el-button type="primary" @click.prevent="changePassword" class="w-full">Change password</el-button>
                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </template>
    </UserLayout>
</template>

<style scope>

</style>