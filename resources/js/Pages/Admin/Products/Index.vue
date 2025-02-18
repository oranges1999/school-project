<template>
    <AdminLayout>
        <template #Content>
            <div>
                <h1 class="text-[#1F6391] text-[30px] font-bold">Products</h1>
                <div>
                    <el-button @click="toCreateProduct" type="primary">Create</el-button>
                </div>
                <div>
                    <table class="w-full mt-10">
                        <thead>
                            <tr class="border-b-2">
                                <th class="border-r-2 w-[5%]">No.</th>
                                <th class="border-r-2 w-[10%]">Name</th>
                                <th class="border-r-2 w-[15%]">Description</th>
                                <th class="border-r-2 w-[15%]">Category</th>
                                <th class="border-r-2 w-[10%]">Price</th>
                                <th class="border-r-2 w-[5%]">Status</th>
                                <th class="border-r-2 w-[10%]">Created at</th>
                                <th class="border-r-2 w-[5%]">Stock</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="products.length > 0">
                            <tr v-for="product, index in products" :key="product.id">
                                <td class="text-center border-r-2">{{ index+1 }}</td>
                                <td class="text-center border-r-2">{{ product.name }}</td>
                                <td class="text-center border-r-2">{{ product.description }}</td>
                                <td class="text-center border-r-2">{{ product.category }}</td>
                                <td class="text-center border-r-2">{{ product.price }}</td>
                                <td class="text-center border-r-2">{{ product.status }}</td>
                                <td class="text-center border-r-2">
                                    {{ new Date(product.created_at).toDateString() }}
                                </td>
                                <td class="text-center border-r-2">{{ product.stock }}</td>
                                <td class="text-center">
                                    <div>
                                        <el-button @click.prevent="toEdit(product.id)" type="primary">Edit</el-button>
                                        <el-button @click.prevent="confirmDelete(product.id, product.name)" type="danger">
                                            Delete
                                        </el-button>
                                    </div>
                                    
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="">
                                <td colspan="9" class="text-center !w-[100px]">
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
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ElMessageBox, ElMessage } from 'element-plus';

const products = ref([])

const toCreateProduct = () => {
    router.visit(route('admin.products.create'))
}

const getProductsData = () => {
    axios.get(route('api.admin.products.get-data'))
        .then(response => {
            products.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}
getProductsData()

const confirmDelete = (id, name) => {

    ElMessageBox.confirm(
    'Are you sure you want to delete this product:' + name + '?',
    'Warning',
    {
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        axios.delete(route('api.admin.products.destroy', {id: id}))
            .then(() => {
                getProductsData();
                ElMessage({
                    type: 'success',
                    message: 'Delete completed',
                })
            })
            .catch((error) => {
                ElMessage({
                    type: 'danger',
                    message: 'Delete failed',
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

const toEdit = (id) => {
    router.visit(route('admin.products.edit', {id: id}))
}
</script>

<style scoped>

</style>