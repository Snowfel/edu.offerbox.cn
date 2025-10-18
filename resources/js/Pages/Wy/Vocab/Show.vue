<!-- resources/js/Pages/WyLexicon/Show.vue -->
<template>
  <DefaultLayout>
    <div class="container py-5" v-cloak>
      <div class="card shadow border-0">
        <div class="card-header bg-success text-white fs-4 fw-bold">
          {{ lexiconname }}
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li
                v-for="(word, i) in words"
                :key="word.id ?? i"
                class="list-group-item fs-5 d-flex justify-content-between align-items-center"
            >
              <span @click="playWordAudio(word)">
                {{ i + 1 }}  {{ word.word}}
              <i class="fas fa-play-circle text-primary" style="cursor:pointer"></i>
              </span>

              <div v-if="word.showDetail" class="mt-2 w-100 text-muted">
                <div class="text-muted">{{ word.means }}</div>
                <div v-if="word.symbols">
                  <span v-if="word.symbols.ph_en">英 [{{ word.symbols.ph_en }}] </span>
                  <span v-if="word.symbols.ph_am">美 [{{ word.symbols.ph_am }}]</span>
                  <div v-for="part in word.symbols.parts || []" :key="part.part">
                    {{ part.part }}:
                    <span v-for="(m, idx) in part.means" :key="idx">
                      {{ m }}<span v-if="idx+1 < part.means.length">; </span>
                    </span>
                  </div>
                </div>
                <div v-else class="text-muted">暂无音标和释义</div>
              </div>
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
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import axios from 'axios'

const props = defineProps({
  lexiconname: String,
  words: Array, // [{id, vocab, orderid}]
})

const playAudio = ref(null)

function toggleWordDetail(word) {
  console.log(word.showDetail)
  word.showDetail = !word.showDetail
  console.log(word.showDetail)
}

async function playWordAudio(word) {
  try {
    /*console.log(word.showDetail)
    // 先展开单词详情
    if (!word.showDetail) {
    }
    this.toggleWordDetail(word)*/

    const res = await axios.post('/api/wy/vocab/audio', {text: word.word})
    if (res.data.ret === 'success') {
      word.audioUrl = res.data.url
      word.means = res.data.means
      word.symbols = res.data.symbols
      console.log(res.data)
      word.showDetail = true
    } else {
      alert('音频获取失败')
      return
    }
  } catch (e) {
    alert('请求失败')
    return
  }

  // 停止当前播放
  if (playAudio.value) {
    playAudio.value.pause()
    playAudio.value = null
  }

  const audio = new Audio(word.audioUrl)
  playAudio.value = audio
  audio.play().catch(() => {
    console.warn('自动播放被阻止，可通过用户操作播放')
  })
}
</script>

<style scoped>
[v-cloak] { display: none; }
.list-group-item span { cursor: pointer; }
</style>
