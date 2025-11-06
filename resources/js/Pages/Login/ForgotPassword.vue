<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-center mb-6">重置密码</h1>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">邮箱</label>
          <input
              v-model="form.email"
              type="email"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请输入邮箱"
          />
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
        </div>

        <button
            type="submit"
            class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700"
            :disabled="form.processing"
        >
          发送重置链接
        </button>

        <p class="mt-4 text-center text-gray-600">
          已记得密码？
          <a :href="props.guard === 'admin' ? route('admin.login.login') : route('user.login.index')" class="text-blue-600 hover:underline">登录</a>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  guard: String,
})

const form = useForm({
  email: '',
  errors: {},
})

const submit = () => {
  form.post(
      props.guard === 'admin' ? route('admin.password.email') : route('user.password.email'),
      {
        onError: (errors) => {
          form.errors = errors
        },
      }
  )
}
</script>
