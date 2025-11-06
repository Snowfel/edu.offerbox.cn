<template>
  <div class="flex h-screen bg-gray-100">
    <!-- 侧边栏 -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 font-bold text-lg">Admin Panel</div>
      <nav class="flex-1 px-2 space-y-1">
        <template v-for="item in filteredMenu" :key="item.name">
          <Link
              :href="route(item.route)"
              class="block px-4 py-2 rounded hover:bg-gray-700"
          >
            {{ item.label }}
          </Link>
        </template>
      </nav>
      <div class="p-4">
        <button @click="logout" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded">
          Logout
        </button>
      </div>
    </aside>

    <!-- 主内容 -->
    <div class="flex-1 flex flex-col overflow-auto">
      <!-- 顶部面包屑 -->
      <header class="bg-white shadow px-6 py-4">
        <nav class="text-gray-500 text-sm">
          <template v-for="(crumb, index) in breadcrumbs" :key="index">
            <span v-if="index > 0"> / </span>
            <span>{{ crumb }}</span>
          </template>
        </nav>
      </header>

      <!-- 页面内容 -->
      <main class="flex-1 p-6">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { usePage, Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const { props } = usePage()
const auth = props.auth.user || { permissions: [] }

// 后台菜单及对应权限
const menu = [
  { name: 'word-library', label: '词库管理', route: 'admin.word-libraries.index', permission: 'view_word_library' },
  { name: 'word', label: '单词管理', route: 'admin.words.index', permission: 'view_word' },
  { name: 'users', label: '用户管理', route: 'admin.users.index', permission: 'view_users' },
  { name: 'roles', label: '角色管理', route: 'admin.roles.index', permission: 'view_roles' },
  { name: 'permissions', label: '权限管理', route: 'admin.permissions.index', permission: 'view_permissions' },
]

// 权限过滤菜单
const filteredMenu = computed(() =>
    menu.filter(item => auth.permissions.includes(item.permission))
)

// 简单面包屑示例
const breadcrumbs = computed(() => {
  const segments = route().current().split('.')
  return segments.map(seg => seg.charAt(0).toUpperCase() + seg.slice(1))
})

const logout = () => {
  router.post('/logout', {}, { onSuccess: () => location.reload() })
}
</script>
