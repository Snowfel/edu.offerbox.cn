<template>
  <DefaultLayout>
    <div class="text-center py-5">
      <div class="alert alert-warning fs-5 shadow-sm d-inline-block">
        {{ message }}
      </div>
      <div class="mt-4">
        <Link href="/wy/vocab" class="btn btn-primary">返回登录</Link>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  message: String,
})
</script>
