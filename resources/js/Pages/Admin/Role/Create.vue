<template>
  <AdminLayout>
    <div class="p-6 bg-white rounded shadow">
      <h1 class="text-2xl font-bold mb-4">创建角色</h1>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1">角色名称</label>
          <input v-model="form.name" type="text" class="border p-2 w-full rounded" />
          <p v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</p>
        </div>
        <div class="mb-4">
          <label class="block mb-1">权限</label>
          <div class="space-y-1">
            <div v-for="perm in permissions" :key="perm.id">
              <label class="inline-flex items-center">
                <input type="checkbox" v-model="form.permissions" :value="perm.id" class="mr-2" />
                {{ perm.display_name || perm.name }}
              </label>
            </div>
          </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">保存</button>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  permissions: Array,
})

const form = useForm({
  name: '',
  permissions: [],
  errors: {},
})

const submit = () => {
  form.post(route('admin.roles.store'), {
    onError: (errors) => form.errors = errors,
  })
}
</script>
