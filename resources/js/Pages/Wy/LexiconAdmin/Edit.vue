<template>
  <DefaultLayout>
    <div class="container py-4" style="max-width:800px;">
      <h2 class="mb-4">{{ mode === 'create' ? '新增词库' : '编辑词库' }}</h2>

      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">词库名称</label>
          <input v-model="form.lexiconname" class="form-control" />
          <div v-if="form.errors.lexiconname" class="text-danger mt-1">{{ form.errors.lexiconname }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">词数 (可选)</label>
          <input v-model="form.vocabcount" type="number" class="form-control" />
        </div>

        <!-- 简单单词编辑区域（仅在编辑时显示） -->
        <div v-if="mode === 'edit'">
          <h5 class="mt-3">单词列表</h5>
          <div v-for="(w, idx) in form.words" :key="idx" class="mb-2 d-flex gap-2">
            <input v-model="w.word" class="form-control" placeholder="word" />
            <input v-model="w.definition" class="form-control" placeholder="definition" />
            <button type="button" class="btn btn-outline-danger" @click="removeWord(idx)">删除</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary mt-2" @click="addWord">+ 添加单词</button>
        </div>

        <div class="d-flex justify-content-between mt-4">
          <Link href="{!! route('wy.lexicon.admin.index') !!}" class="btn btn-outline-secondary">返回</Link>
          <button class="btn btn-primary" :disabled="form.processing">{{ form.processing ? '保存中...' : (mode === 'create' ? '保存' : '更新') }}</button>
        </div>
      </form>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  lexicon: Object,
  mode: String,
})

const form = useForm({
  lexiconname: props.lexicon.lexiconname || '',
  vocabcount: props.lexicon.vocabcount || 0,
  orderid: props.lexicon.orderid || 0,
  isreadlist: props.lexicon.isreadlist ?? true,
  words: props.lexicon.words ? JSON.parse(JSON.stringify(props.lexicon.words)) : [],
})

function addWord() {
  form.words.push({ id: null, word: '', definition: '', order: 0 })
}
function removeWord(idx) {
  form.words.splice(idx,1)
}

function submit() {
  if (props.mode === 'create') {
    form.post(route('wy.lexicon.admin.store'))
  } else {
    form.put(route('wy.lexicon.admin.update', props.lexicon.id))
  }
}
</script>
