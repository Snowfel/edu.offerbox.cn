<template>
  <DefaultLayout>
    <div class="p-6 bg-white rounded shadow">
      <h1 class="text-2xl font-bold mb-4">欢迎，{{ auth.user.name }}</h1>
      <p>这里是你的用户首页，你可以访问课程、测评、词库等功能。</p>
    </div>
  </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()
const auth = props.auth
</script>
