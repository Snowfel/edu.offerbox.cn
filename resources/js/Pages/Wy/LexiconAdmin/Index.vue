<template>
  <DefaultLayout>
    <div class="container py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">词库管理</h2>
        <Link class="btn btn-success" :href="route('wy.lexicon.admin.create')">+ 新增词库</Link>
      </div>

      <div v-if="flash.success" class="alert alert-success">{{ flash.success }}</div>

      <table class="table table-striped align-middle">
        <thead class="table-light">
        <tr><th>ID</th><th>词库名称</th><th>数量</th><th class="text-center">操作</th></tr>
        </thead>
        <tbody>
        <tr v-for="lexicon in lexicons.data" :key="lexicon.id">
          <td>{{ lexicon.id }}</td>
          <td>{{ lexicon.lexiconname }}</td>
          <td>{{ lexicon.vocabcount }}</td>
          <td class="text-center">
            <Link class="btn btn-sm btn-outline-primary me-2" :href="route('wy.lexicon.admin.edit', lexicon.id)">编辑</Link>
            <button class="btn btn-sm btn-outline-danger" @click="destroy(lexicon.id)">删除</button>
          </td>
        </tr>
        </tbody>
      </table>

      <!-- 简单分页 -->
      <nav v-if="lexicons.last_page > 1">
        <ul class="pagination">
          <li class="page-item" :class="{disabled: !lexicons.prev_page_url}">
            <a class="page-link" :href="lexicons.prev_page_url">上一页</a>
          </li>
          <li class="page-item disabled">
            <span class="page-link">{{ lexicons.current_page }} / {{ lexicons.last_page }}</span>
          </li>
          <li class="page-item" :class="{disabled: !lexicons.next_page_url}">
            <a class="page-link" :href="lexicons.next_page_url">下一页</a>
          </li>
        </ul>
      </nav>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  lexicons: Object,
  flash: Object,
})

function destroy(id) {
  if (!confirm('确定要删除吗？')) return
  router.delete(route('wy.lexicon.admin.destroy', id))
}
</script>
