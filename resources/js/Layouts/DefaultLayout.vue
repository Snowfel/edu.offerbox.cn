<template>
  <div class="min-h-screen flex flex-col bg-gray-50 text-gray-800">
    <!-- 顶部导航 -->
    <header class="bg-gray-900 text-white shadow">
      <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
        <h1 class="text-lg font-semibold tracking-wide">OfferBox 系统</h1>
        <nav class="space-x-6">
          <Link href="/" class="hover:text-indigo-400 transition">首页</Link>
          <Link href="/wy/vocab" class="hover:text-indigo-400 transition">词库</Link>
        </nav>
      </div>
    </header>

    <!-- 主体内容 -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
      <slot />
    </main>

    <!-- 底部 -->
    <footer class="border-t bg-white py-4 text-center text-sm text-gray-500">
      © 2025 <a href="https://edu.offerbox.cn" class="hover:text-indigo-600">edu.offerbox.cn</a> - All rights reserved.
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
