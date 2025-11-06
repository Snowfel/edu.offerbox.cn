<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-center mb-6">
        {{ guard === 'admin' ? '管理员注册' : '用户注册' }}
      </h1>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">姓名</label>
          <input
              v-model="form.name"
              type="text"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请输入姓名"
          />
          <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

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

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">密码</label>
          <input
              v-model="form.password"
              type="password"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请输入密码"
          />
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">确认密码</label>
          <input
              v-model="form.password_confirmation"
              type="password"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请再次输入密码"
          />
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
            :disabled="form.processing"
        >
          注册
        </button>

        <p class="mt-4 text-center text-gray-600">
          已有账号？
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
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  errors: {},
})

const submit = () => {
  form.post(
      props.guard === 'admin' ? route('admin.register.submit') : route('user.register.submit'),
      {
        onError: (errors) => {
          form.errors = errors
        },
      }
  )
}
</script>
