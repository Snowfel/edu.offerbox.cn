<template>
  <DefaultLayout>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- 词库列表 -->
          <div class="card border-0 shadow-lg">
            <div class="card-header bg-success text-white text-center fs-4 fw-bold">
              词库列表
            </div>
            <div class="card-body">
              <div v-for="item in list || [] " :key="item.id" class="mb-3 d-grid">
                <a :href="`/wy/vocab/list/${item.id}`" class="btn btn-outline-primary fs-5">
                  {{ item.lexiconname }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { onMounted } from 'vue'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const props = defineProps({
  list: Array,
})
const auth = useAuthStore()

onMounted(() => {
  auth.checkLogin()
})
</script>
