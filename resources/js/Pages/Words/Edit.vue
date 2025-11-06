<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

const props = defineProps({
  word: Object,
  library: Object
})

const form = useForm({
  word: props.word?.word ?? '',
  phonetic: props.word?.phonetic ?? '',
  language: props.word?.language ?? '',
  difficulty: props.word?.difficulty ?? '',
  meaning: props.word?.meaning ?? '',
  library_id: props.library?.id ?? props.word?.library_id ?? ''
})

const handleSubmit = () => {
  if (props.word?.id) {
    form.put(`/admin/words/${props.word.id}`)
  } else {
    form.post('/admin/words')
  }
}
</script>

<template>
  <Head :title="props.word ? '编辑单词' : '新建单词'" />

  <div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ props.word ? '编辑单词' : '新建单词' }}</h1>

    <form @submit.prevent="handleSubmit" class="bg-white p-6 rounded-lg shadow space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">单词</label>
        <input v-model="form.word" class="w-full border-gray-300 rounded-md" required />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">音标</label>
          <input v-model="form.phonetic" class="w-full border-gray-300 rounded-md" />
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">语言</label>
          <input v-model="form.language" class="w-full border-gray-300 rounded-md" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">难度</label>
        <select v-model="form.difficulty" class="w-full border-gray-300 rounded-md">
          <option value="">请选择</option>
          <option value="easy">简单</option>
          <option value="medium">中等</option>
          <option value="hard">困难</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">释义</label>
        <textarea v-model="form.meaning" rows="3" class="w-full border-gray-300 rounded-md"></textarea>
      </div>

      <div class="flex justify-end">
        <Button type="submit" :disabled="form.processing">
          {{ form.processing ? '保存中...' : '保存' }}
        </Button>
      </div>
    </form>
  </div>
</template>
