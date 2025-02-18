<template>
    <AdminLayout>
        <template #Content>
            <div class="items-center h-full">
                <h1 class="text-[#1F6391] text-[30px] font-bold">Category</h1>
                <div>
                    <el-button @click="toCreateCategory" type="primary">Create</el-button>
                </div>
                <div>
                    <table class="w-full mt-10">
                        <thead>
                            <tr class="border-b-2">
                                <th class="border-r-2 w-[10%]">No.</th>
                                <th class="border-r-2 w-[50%]">Name</th>
                                <th class="border-r-2 w-[30%]">Created at</th>
                                <th class="w-[20%]">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="categories.length > 0">
                            <tr v-for="category, index in categories" :key="category.id">
                                <td class="text-center border-r-2">{{ index+1 }}</td>
                                <td class="text-center border-r-2">{{ category.name }}</td>
                                <td class="text-center border-r-2">
                                    {{ new Date(category.created_at).toDateString() }}
                                </td>
                                <td class="text-center">
                                    {{ console.log(category.id) }}
                                    <el-button @click.prevent="toCategoryEdit(category.id)" type="primary">Edit</el-button>
                                    <el-button @click.prevent="confirmDelete(category.id, category.name)" type="danger">Delete</el-button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="">
                                <td colspan="4" class="text-center !w-[100px]">
                                    <p class="mt-[20px]">It's Empty :(</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { ElMessageBox, ElMessage } from 'element-plus';
import axios from 'axios';

const toCreateCategory = () => {
    router.visit(route('admin.categories.create'));
}

const props = defineProps({
    categories: {
        type: Array,
        required: true
    }
});

const categories = ref(props.categories);

const getCategories = () => {
    axios.get(route('api.admin.categories.get-data'))
        .then(response => {
            categories.value = response.data;
        })
        .catch(error => {
            console.log(error);
        });
}

const confirmDelete = (id, name) => {
    ElMessageBox.confirm(
    'Are you sure you want to delete this category:' + name + '?',
    'Warning',
    {
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        axios.delete(route('api.admin.categories.destroy', {id: id}))
            .then(() => {
                getCategories();
                ElMessage({
                    type: 'success',
                    message: 'Delete completed',
                })
            })
            .catch((error) => {
                ElMessage({
                    type: 'info',
                    message: 'Delete canceled',
                })
            })   
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

const toCategoryEdit = (id) => {
    router.visit(route('admin.categories.edit', id));
}
</script>

<style scoped>

</style>