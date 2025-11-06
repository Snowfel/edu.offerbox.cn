<template>
  <DefaultLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">词库管理</h1>
        <Link href="{{ route('admin.word-libraries.create') }}">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ 新建词库</button>
        </Link>
      </div>

      <!-- 搜索 -->
      <div class="mb-4 flex">
        <input
            v-model="filters.keyword"
            type="text"
            placeholder="搜索词库名称"
            class="border rounded-lg p-2 flex-1 mr-2"
            @keyup.enter="search"
        />
        <button @click="search" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
          搜索
        </button>
      </div>

      <!-- 表格 -->
      <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-4 py-2 text-left">名称</th>
            <th class="px-4 py-2 text-left">上级</th>
            <th class="px-4 py-2 text-left">描述</th>
            <th class="px-4 py-2 text-right">操作</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
          <tr v-for="item in libraries.data" :key="item.id" class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ item.name }}</td>
            <td class="px-4 py-2">{{ item.parent?.name ?? '无' }}</td>
            <td class="px-4 py-2 text-gray-600">{{ item.description }}</td>
            <td class="px-4 py-2 text-right space-x-2">
              <Link :href="`/admin/word-libraries/${item.id}/edit`" class="text-blue-600 hover:underline">编辑</Link>
              <Link :href="`/admin/words?library_id=${item.id}`" class="text-green-600 hover:underline">单词</Link>
              <button @click="destroy(item.id)" class="text-red-600 hover:underline">删除</button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- 分页 -->
      <div class="mt-4 flex justify-end space-x-2">
        <button
            v-for="link in libraries.links"
            :key="link.label"
            v-html="link.label"
            :disabled="!link.url"
            @click="goPage(link.url)"
            class="px-3 py-1 border rounded hover:bg-gray-100 disabled:text-gray-400"
        ></button>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const props = defineProps({
  libraries: Object,
  filters: Object,
})

const search = () => {
  router.get(route('admin.word-libraries.index'), { keyword: filters.keyword }, { preserveState: true, replace: true })
}

const destroy = (id) => {
  if (confirm('确定删除该词库吗？')) {
    router.delete(`/admin/word-libraries/${id}`)
  }
}

const goPage = (url) => {
  if (url) router.get(url, {}, { preserveState: true, replace: true })
}
</script>
