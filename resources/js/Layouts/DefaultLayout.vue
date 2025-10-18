<template>
  <div class="min-h-screen bg-gray-100 d-flex flex-column">
    <!-- 顶部导航 -->
    <header class="bg-dark text-white py-3 shadow">
      <div class="container d-flex justify-content-between align-items-center">
        <h4 class="m-0">OfferBox系统</h4>
        <nav>
          <a href="/" class="text-white text-decoration-none mx-3">首页</a>
          <a href="/wy/vocab" class="text-white text-decoration-none mx-3">词库</a>
        </nav>
      </div>
    </header>

    <!-- 主体内容 -->
    <main class="flex-fill container py-4">
      <slot />
    </main>

    <!-- 底部 -->
    <footer class="bg-light py-3 text-center border-top mt-auto">
      <small class="text-muted">© 2025 华樱外语 - All rights reserved.</small>
    </footer>
  </div>
</template>
