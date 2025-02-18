<template>
    <AdminLayout>
        <template #Content>
            <div>
                <h1 class="text-[#1F6391] text-[30px] font-bold">Products Creates</h1>
                <div>
                    <el-button @click="toProductIndex" type="primary">Back</el-button>
                </div>
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
                    <el-form-item label="Description" prop="description">
                        <el-input v-model="form.description"></el-input>
                        <p v-if="errors.description" class="text-red-500">{{ errors.description[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Price" prop="price">
                        <el-input-number 
                            v-model="form.price" 
                            :controls="false"    
                            class="!w-full"
                        />
                        <p v-if="errors.price" class="text-red-500">{{ errors.price[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Category" prop="category">
                        <el-select
                            v-model="form.category_id"
                            placeholder="Select category"
                            class="!w-full"
                            label="dsadsadsads"
                        >
                            <el-option
                                v-for="category, index in categories"
                                :key="index"
                                :label="category.name"
                                :value="category.id"
                            />
                        </el-select>
                        <p v-if="errors.category_id" class="text-red-500">{{ errors.category_id[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Stock" prop="stock">
                        <el-input-number 
                            v-model="form.stock" 
                            :controls="false"    
                            class="!w-full"
                        />
                        <p v-if="errors.price" class="text-red-500">{{ errors.price[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Image" prop="image">
                        <div class="upload-btn-wrapper cursor-pointer">
                            <button class="btn">Upload a file</button>
                            <input type="file" @change="getImage($event)" />
                        </div>
                        <img v-if="fileUrl" :src="fileUrl" alt="">
                        <p v-if="errors.file" class="text-red-500">{{ errors.file[0] }}</p>
                    </el-form-item>
                    <el-form-item label="Status" prop="status">
                        <div>
                            <p>{{ form.status ? 'Active' : 'Disabled' }}</p>
                            <el-switch
                                v-model="form.status"
                                size="large"
                                :active-value="1"
                                :inactive-value="0"
                            />
                            <p v-if="errors.status" class="text-red-500">{{ errors.status[0] }}</p>
                        </div>
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
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import axios from 'axios'
import { ElMessage } from 'element-plus';

const form = ref({
    status: false
})
const errors = ref({})
const categories = ref()
const file = ref()
const fileUrl = ref()
const toProductIndex = () => {
    router.visit(route('admin.products.index'))
}

const getCategoriesData = async () => {
    await axios.get(route('api.admin.categories.get-data'))
        .then(response => {
            categories.value = response.data
        })
        .catch(errors => {
            console.log(response)
        })
}
getCategoriesData()

const getImage = (evt) => {
    form.value.image = evt.target.files[0];
    fileUrl.value = URL.createObjectURL(form.value.image)
}

const submitForm = () => {
    let formData = new FormData()
    Object.keys(form.value).forEach(key => {
        formData.append(key, form.value[key])
    })
    axios.post(route('api.admin.products.store'), formData)
        .then(response => {
            router.visit(route('admin.products.index'))
            ElMessage({
                type: 'success',
                message: 'Create completed',
            })
        })
        .catch(error => {
            errors.value = error.response.data.errors;
        })
    form.value = {}
}
</script>

<style scoped>
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>