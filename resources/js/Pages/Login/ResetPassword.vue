<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-center mb-6">设置新密码</h1>

      <form @submit.prevent="submit">
        <input type="hidden" v-model="form.token" />

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">邮箱</label>
          <input
              v-model="form.email"
              type="email"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          />
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">新密码</label>
          <input
              v-model="form.password"
              type="password"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          />
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">确认新密码</label>
          <input
              v-model="form.password_confirmation"
              type="password"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          />
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
            :disabled="form.processing"
        >
          更新密码
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  token: String,
  email: String,
  guard: String,
})

const form = useForm({
  token: props.token || '',
  email: props.email || '',
  password: '',
  password_confirmation: '',
  errors: {},
})

const submit = () => {
  form.post(
      props.guard === 'admin' ? route('admin.password.update') : route('user.password.update'),
      {
        onError: (errors) => {
          form.errors = errors
        },
      }
  )
}
</script>
