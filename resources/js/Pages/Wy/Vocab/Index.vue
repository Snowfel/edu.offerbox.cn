<template>
  <DefaultLayout>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- 词库列表 -->
          <div v-if="isLoggedIn" class="card border-0 shadow-lg">
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
    } else {
      sessionStorage.removeItem('wy_lexicon_loginid')
      alert('登录已过期，请重新登录')
      router.visit(route('wy.lexicon.login'))
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
