<template>
    <AdminLayout>
        <template #Content>
            <div class="items-center h-full">
                <h1 class="text-[#1F6391] text-[30px] font-bold">Create Category</h1>
                <el-form
                    :model="form"
                    style="width: 600px"
                    label-width="120px"
                    class="mt-10"
                >
                    <el-form-item label="Name" prop="name">
                        <el-input v-model="form.name"></el-input>
                        <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click.prevent="submitForm">Create</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </template>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import axios from 'axios';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';

const form = ref({
    name: ''
});

const errors = ref([]);

const submitForm = () => {
    let data = new FormData();
    data = form.value;
    axios.post(route('api.admin.categories.store'), data)
        .then(response => {
            ElMessage({
                type: 'success',
                message: 'Create completed',
            })
            router.visit(route('admin.categories.index'));
        })
        .catch(error => {
            errors.value = error.response.data.errors;
        });
}
</script>

<style scoped>

</style>