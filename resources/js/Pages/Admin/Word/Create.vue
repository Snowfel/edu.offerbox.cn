<template>
  <DefaultLayout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
      <h1 class="text-xl font-semibold mb-6">新建单词</h1>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">单词</label>
          <input
              v-model="form.word"
              type="text"
              class="w-full border rounded-lg p-2"
          />
          <p v-if="form.errors.word" class="text-red-500 text-sm mt-1">
            {{ form.errors.word }}
          </p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">所属词库</label>
          <select
              v-model="form.library_id"
              class="w-full border rounded-lg p-2"
          >
            <option value="">请选择</option>
            <option v-for="lib in libraries" :key="lib.id" :value="lib.id">
              {{ lib.name }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">释义</label>
          <textarea
              v-model="form.translation"
              rows="3"
              class="w-full border rounded-lg p-2"
          ></textarea>
        </div>

        <div class="mb-4 grid grid-cols-3 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">语言</label>
            <input
                v-model="form.language"
                type="text"
                class="w-full border rounded-lg p-2"
                placeholder="如：EN / CN"
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">标签</label>
            <input
                v-model="form.tags"
                type="text"
                class="w-full border rounded-lg p-2"
                placeholder="如：动词,日常"
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">难度</label>
            <select v-model="form.difficulty" class="w-full border rounded-lg p-2">
              <option value="">请选择</option>
              <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end">
          <Link :href="route('admin.words.index')" class="text-gray-500 hover:underline mr-4">
            返回
          </Link>
          <button
              type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
              :disabled="form.processing"
          >
            保存
          </button>
        </div>
      </form>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const props = defineProps({
  libraries: Array,
})

const form = useForm({
  word: '',
  library_id: '',
  translation: '',
  language: '',
  tags: '',
  difficulty: '',
})

const submit = () => {
  form.post(route('admin.words.store'))
}
</script>
