<template>
  <DefaultLayout>
    <div class="container py-5">
      <div class="card shadow border-0">
        <div class="card-header bg-success text-white fs-4 fw-bold">
          {{ lexiconname }}
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li v-for="(word, i) in words" :key="i" class="list-group-item fs-5">
              {{ i + 1 }}. {{ word }}
            </li>
          </ul>
        </div>
      </div>

      <div class="text-center mt-4">
        <Link href="/wy/vocab" class="btn btn-outline-secondary">返回列表</Link>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  id: Number,
  lexiconname: String,
  words: Array,
})
</script>
