<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

/*const props = defineProps({
  libraries: Array
})*/
const { props } = usePage()
const auth = props.auth
const wordLibraries = props.wordLibraries

const handleDelete = (id) => {
  if (confirm('确定要删除该词库吗？')) {
    //router.delete(`/admin/word-libraries/${id}`)
    router.delete(route('admin.word-libraries.destroy', id))
  }
}
</script>

<template>
  <Head title="词库管理" />

  <div class="p-6 space-y-4">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">词库管理</h1>
      <Link href="/admin/word-libraries/create">
        <Button>+ 新建词库</Button>
      </Link>
    </div>

    <div class="bg-white rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr class="text-left text-gray-700">
          <th class="px-4 py-2">名称</th>
          <th class="px-4 py-2">上级</th>
          <th class="px-4 py-2">描述</th>
          <th class="px-4 py-2 text-right">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in libraries" :key="item.id" class="hover:bg-gray-50">
          <td class="px-4 py-2 font-medium">{{ item.name }}</td>
          <td class="px-4 py-2 text-gray-600">{{ item.parent?.name ?? '无' }}</td>
          <td class="px-4 py-2 text-gray-500">{{ item.description }}</td>
          <td class="px-4 py-2 text-right space-x-3">
<!--            <Link :href="`/admin/word-libraries/${item.id}/edit`" class="text-blue-600 hover:underline">编辑</Link>-->
            <Link
                v-if="auth.user.permissions.includes('edit_word_library')"
                :href="route('admin.word-libraries.edit', item.id)"
                class="text-blue-600 hover:underline"
            >编辑</Link>
            <Link :href="`/admin/words?vocab_id=${item.id}`" class="text-green-600 hover:underline">单词</Link>
<!--            <button @click="handleDelete(item.id)" class="text-red-600 hover:underline">删除</button>-->
            <button
                v-if="auth.user.permissions.includes('delete_word_library')"
                @click="destroy(item.id)"
                class="text-red-600 hover:underline"
            >删除</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
