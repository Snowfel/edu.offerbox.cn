<template>
  <div class="min-h-screen flex flex-col">
    <!-- 顶部导航 -->
    <nav class="bg-gray-800 text-white px-6 py-3 flex justify-between items-center">
      <div class="font-bold text-lg">Edu System</div>
      <div class="space-x-4">
        <Link href="/" class="hover:underline">首页</Link>
        <Link v-if="auth.user" @click.prevent="logout" class="hover:underline cursor-pointer">登出</Link>
      </div>
    </nav>

    <!-- 主内容 -->
    <main class="flex-1 bg-gray-100">
      <slot></slot>
    </main>

    <!-- 底部 -->
    <footer class="bg-gray-200 text-center p-4 text-gray-600">
      © 2025 Edu System
    </footer>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()
const auth = props.value.auth || {}

const logout = () => {
  router.post('/logout', {}, {
    onSuccess: () => location.reload(),
  })
}
</script>
