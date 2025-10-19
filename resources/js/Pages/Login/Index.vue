<template>
  <DefaultLayout>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- 登录卡片 -->
          <div v-if="!auth.isLoggedIn" class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-primary text-white text-center fs-4 fw-bold">
              用户登录
            </div>
            <div class="card-body text-center">
              <form @submit.prevent="handleLogin">
                <div class="mb-3">
                  <label class="form-label fs-5 fw-semibold">登录码</label>
                  <input
                      v-model="pwd"
                      type="text"
                      class="form-control form-control-lg text-center"
                      placeholder="请输入登录码"
                  />
                </div>
                <button type="submit" class="btn btn-warning w-100 fs-5">
                  登录
                </button>
              </form>
            </div>
          </div>

          <div v-else class="alert alert-success text-center fs-5">
            已登录，正在跳转...
          </div>
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { useAuthStore } from '@/stores/auth'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const auth = useAuthStore()
const pwd = ref('')

onMounted(async () => {
  const ok = await auth.checkLogin()
  if (ok) {
    router.visit(route('wy.lexicon.index'))
  }
})

async function handleLogin() {
  if (!pwd.value.trim()) {
    alert('请输入登录码')
    return
  }

  const ok = await auth.login(pwd.value)
  if (ok) {
    router.visit(route('wy.lexicon.index'))
  }
}
</script>
