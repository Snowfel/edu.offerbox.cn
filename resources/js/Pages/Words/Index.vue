<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
  words: Array,
  library: Object
})

const handleDelete = (id) => {
  if (confirm('确定要删除该单词吗？')) {
    router.delete(`/admin/words/${id}`)
  }
}
</script>

<template>
  <Head :title="`单词管理 - ${library.name}`" />

  <div class="p-6 space-y-4">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">单词管理 - {{ library.name }}</h1>
      <Link :href="`/admin/words/create?library_id=${library.id}`" class="btn btn-primary">
        + 新建单词
      </Link>
    </div>

    <div class="bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-700">
        <tr>
          <th class="px-4 py-2">单词</th>
          <th class="px-4 py-2">音标</th>
          <th class="px-4 py-2">语言</th>
          <th class="px-4 py-2">难度</th>
          <th class="px-4 py-2">释义</th>
          <th class="px-4 py-2 text-right">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="w in words" :key="w.id" class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ w.word }}</td>
          <td class="px-4 py-2">{{ w.phonetic }}</td>
          <td class="px-4 py-2">{{ w.language }}</td>
          <td class="px-4 py-2">{{ w.difficulty }}</td>
          <td class="px-4 py-2 text-gray-600">{{ w.meaning }}</td>
          <td class="px-4 py-2 text-right space-x-2">
            <Link :href="`/admin/words/${w.id}/edit`" class="text-blue-600 hover:underline">编辑</Link>
            <button @click="handleDelete(w.id)" class="text-red-600 hover:underline">删除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
