<template>
  <DefaultLayout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
      <h1 class="text-xl font-semibold mb-6">编辑词库</h1>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">词库名称</label>
          <input
              v-model="form.name"
              type="text"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          />
          <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">
            {{ form.errors.name }}
          </p>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">上级词库</label>
          <select
              v-model="form.parent_id"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          >
            <option value="">无（顶级词库）</option>
            <option v-for="p in parents" :key="p.id" :value="p.id">
              {{ p.name }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-1">描述</label>
          <textarea
              v-model="form.description"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
              rows="3"
          ></textarea>
        </div>

        <div class="flex justify-end">
          <Link
              :href="route('admin.word-libraries.index')"
              class="text-gray-500 hover:underline mr-4"
          >返回</Link>

          <button
              type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
              :disabled="form.processing"
          >
            更新
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
  library: Object,
  parents: Array,
})

const form = useForm({
  name: props.library.name,
  parent_id: props.library.parent_id,
  description: props.library.description,
})

const submit = () => {
  form.put(route('admin.word-libraries.update', props.library.id))
}
</script>
