<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-center mb-6">
        {{ guard === 'admin' ? '后台登录' : '用户登录' }}
      </h1>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">邮箱</label>
          <input
              v-model="form.email"
              type="email"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请输入邮箱"
          />
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">密码</label>
          <input
              v-model="form.password"
              type="password"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              placeholder="请输入密码"
          />
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <div class="mb-4 flex items-center space-x-2">
          <input type="checkbox" v-model="form.remember" id="remember" />
          <label for="remember" class="text-gray-700">记住我</label>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
            :disabled="form.processing"
        >
          登录
        </button>

        <p v-if="form.errors.general" class="text-red-500 text-sm mt-2 text-center">
          {{ form.errors.general }}
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  guard: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
  errors: {},
  general: '',
})

const submit = () => {
  form.post(
      props.guard === 'admin' ? route('admin.login.submit') : route('user.login.submit'),
      {
        onError: (errors) => {
          form.errors = errors
          if (errors.email) {
            form.general = errors.email
          }
        },
      }
  )
}
</script>
