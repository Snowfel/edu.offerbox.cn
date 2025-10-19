<!-- resources/js/Pages/WyLexicon/Show.vue -->
<template>
  <DefaultLayout>
    <div class="container" v-cloak>
      <div class="card-header bg-success text-white fs-4 fw-bold">
        {{ lexiconname }}
      </div>
      <template
          v-for="(word, i) in words"
          :key="word.id ?? i"
          class="list-group-item fs-5 d-flex justify-content-between align-items-center"
      >
      <Disclosure as="div" class="mb-2" v-slot="{ open }">
        <DisclosureButton
            class="flex w-full justify-between rounded-lg bg-purple-100 px-4 py-2 text-left text-sm font-medium text-purple-900 hover:bg-purple-200 focus:outline-none focus-visible:ring focus-visible:ring-purple-500/75"
        >
          <span @click="playWordAudio(word)">{{ word.word}}</span>
          <ChevronUpIcon
              :class="open ? 'rotate-180 transform' : ''"
              class="h-5 w-5 text-purple-500"
          />
        </DisclosureButton>
        <DisclosurePanel class="px-4 pb-2 pt-4 text-sm text-gray-500">
          <template v-if="word.means">{{ word.means }}</template>
          <template v-if="word.symbols">
            <span v-if="word.symbols.ph_en">英 [{{ word.symbols.ph_en }}] </span>
            <span v-if="word.symbols.ph_am">美 [{{ word.symbols.ph_am }}]</span>
            <div v-for="part in word.symbols.parts || []" :key="part.part">
              {{ part.part }}:
              <span v-for="(m, idx) in part.means" :key="idx">
                {{ m }}<span v-if="idx+1 < part.means.length">; </span>
              </span>
            </div>
          </template>
          <template v-else>暂无音标和释义</template>
        </DisclosurePanel>
      </Disclosure>
      </template>


      <div class="text-center mt-4">
        <Link href="/wy/vocab" class="btn btn-outline-secondary">返回列表</Link>
      </div>
    </div>
  </DefaultLayout>

</template>

<script setup>
import {onMounted, ref} from 'vue'
import { Link } from '@inertiajs/vue3'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { useAuthStore } from '@/stores/auth'
import { Dialog, DialogPanel, DialogTitle, TransitionRoot } from '@headlessui/vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronUpIcon } from '@heroicons/vue/20/solid'
import axios from 'axios'

const props = defineProps({
  lexiconname: String,
  words: Array, // [{id, vocab, orderid}]
})

const playAudio = ref(null)

const auth = useAuthStore()

onMounted(() => {
  auth.checkLogin()
})

async function playWordAudio(word) {
  try {

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
