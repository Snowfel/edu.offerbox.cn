<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

const props = defineProps({
  library: Object,
  parents: Array,
})

const form = useForm({
  name: props.library?.name ?? '',
  description: props.library?.description ?? '',
  parent_id: props.library?.parent_id ?? '',
})

const handleSubmit = () => {
  if (props.library?.id) {
    form.put(`/admin/word-libraries/${props.library.id}`)
  } else {
    form.post('/admin/word-libraries')
  }
}
</script>

<template>
  <Head :title="props.library ? '编辑词库' : '新建词库'" />

  <div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">
      {{ props.library ? '编辑词库' : '新建词库' }}
    </h1>

    <form @submit.prevent="handleSubmit" class="space-y-4 bg-white p-6 rounded-lg shadow">
      <div>
        <label class="block text-sm font-medium mb-1">名称</label>
        <input v-model="form.name" type="text" class="w-full border-gray-300 rounded-md" required />
        <div v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">上级词库</label>
        <select v-model="form.parent_id" class="w-full border-gray-300 rounded-md">
          <option value="">无</option>
          <option v-for="p in parents" :value="p.id" :key="p.id">{{ p.name }}</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">描述</label>
        <textarea v-model="form.description" rows="3" class="w-full border-gray-300 rounded-md"></textarea>
      </div>

      <div class="flex justify-end">
        <Button type="submit" :disabled="form.processing">
          {{ form.processing ? '保存中...' : '保存' }}
        </Button>
      </div>
    </form>
  </div>
</template>
