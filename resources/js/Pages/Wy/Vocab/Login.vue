<template>
  <DefaultLayout>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- 登录卡片 -->
          <div v-if="!isLoggedIn" class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-primary text-white text-center fs-4 fw-bold">
              词库登录
            </div>
            <div class="card-body text-center">
              <form @submit.prevent="handleLogin">
                <div class="mb-3">
                  <label class="form-label fs-5 fw-semibold">登录码</label>
                  <input
                      v-model="form.pwd"
                      type="text"
                      class="form-control form-control-lg text-center"
                      placeholder="请输入登录码"
                  />
                </div>
                <button type="submit" class="btn btn-warning w-100 fs-5" :disabled="form.processing">
                  {{ form.processing ? '验证中...' : '验证' }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const props = defineProps({
  list: Array,
})

const isLoggedIn = ref(false)
const form = useForm({ pwd: '' })

onMounted(() => {
  const savedId = sessionStorage.getItem('wy_lexicon_loginid')
  if (!savedId) {
    isLoggedIn.value = false
    return
  }

  axios.post(route('user.login.check'), { loginid: savedId }).then((res) => {
    if (res.data.ret === 'success') {
      isLoggedIn.value = true
      router.visit(route('wy.lexicon.index'))
    } else {
      sessionStorage.removeItem('wy_lexicon_loginid')
    }
  })
})

function handleLogin() {
  if (!form.pwd.trim()) {
    alert('请输入登录码')
    return
  }

  form.post(route('wy.lexicon.login'), {
    preserveScroll: true,
    onSuccess: (res) => {
      const data = res.props ?? {}
      if (data.ret === 'success') {
        sessionStorage.setItem('wy_lexicon_loginid', data.loginid)
        isLoggedIn.value = true
      } else {
        alert('登录码错误?')
      }
    },
    onError: () => alert('请求失败，请稍后重试'),
  })
}
</script>
