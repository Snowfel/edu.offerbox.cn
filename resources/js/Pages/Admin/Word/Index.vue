<template>
  <DefaultLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">单词管理</h1>
        <Link :href="`/admin/words/create`">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ 新建单词</button>
        </Link>
      </div>

      <!-- 筛选 -->
      <div class="mb-4 flex space-x-2">
        <input
            v-model="filters.keyword"
            type="text"
            placeholder="搜索单词"
            class="border rounded-lg p-2 flex-1"
            @keyup.enter="search"
        />

        <select v-model="filters.library_id" class="border rounded-lg p-2" @change="search">
          <option value="">全部词库</option>
          <option v-for="lib in libraries" :key="lib.id" :value="lib.id">{{ lib.name }}</option>
        </select>

        <button @click="search" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
          搜索
        </button>
      </div>

      <!-- 表格 -->
      <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-4 py-2 text-left">单词</th>
            <th class="px-4 py-2 text-left">词库</th>
            <th class="px-4 py-2 text-left">语言</th>
            <th class="px-4 py-2 text-left">难度</th>
            <th class="px-4 py-2 text-left">释义</th>
            <th class="px-4 py-2 text-right">操作</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
          <tr v-for="word in words.data" :key="word.id" class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ word.word }}</td>
            <td class="px-4 py-2">{{ word.library.name }}</td>
            <td class="px-4 py-2">{{ word.language }}</td>
            <td class="px-4 py-2">{{ word.difficulty }}</td>
            <td class="px-4 py-2 text-gray-600">{{ word.translation }}</td>
            <td class="px-4 py-2 text-right space-x-2">
              <Link :href="`/admin/words/${word.id}/edit`" class="text-blue-600 hover:underline">编辑</Link>
              <button @click="destroy(word.id)" class="text-red-600 hover:underline">删除</button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- 分页 -->
      <div class="mt-4 flex justify-end space-x-2">
        <button
            v-for="link in words.links"
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
  words: Object,
  libraries: Array,
  filters: Object,
})

const search = () => {
  router.get(route('admin.words.index'), filters, { preserveState: true, replace: true })
}

const destroy = (id) => {
  if (confirm('确定删除该单词吗？')) {
    router.delete(`/admin/words/${id}`)
  }
}

const goPage = (url) => {
  if (url) router.get(url, {}, { preserveState: true, replace: true })
}
</script>
