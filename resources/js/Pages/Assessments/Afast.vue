<template>
  <DefaultLayout>
    <div class="max-w-3xl mx-auto py-10">
      <h1 class="text-2xl font-bold mb-6 text-center">高潜人才潜力测评问卷（A-FAST 模型）</h1>

      <div v-if="!store.finished">
        <div class="mb-6">
          <div class="flex justify-between mb-1 text-sm">
            <span>进度：{{ store.currentIndex + 1 }}/{{ store.questions.length }}</span>
            <span>{{ Math.round(store.progress) }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div
              class="bg-blue-500 h-2 rounded-full transition-all"
              :style="{ width: store.progress + '%' }"
            ></div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow mb-6">
          <h2 class="text-lg font-semibold mb-4">{{ store.questions[store.currentIndex] }}</h2>
          <div class="space-y-3">
            <label
              v-for="n in 5"
              :key="n"
              class="flex items-center space-x-2 cursor-pointer"
            >
              <input
                type="radio"
                :name="'q' + store.currentIndex"
                :value="n"
                v-model.number="store.answers[store.currentIndex]"
              />
              <span>{{ scaleLabels[n - 1] }}</span>
            </label>
          </div>
        </div>

        <div class="flex justify-between">
          <button
            class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300"
            :disabled="store.currentIndex === 0"
            @click="store.prevQuestion"
          >上一步</button>

          <button
            v-if="store.currentIndex < store.questions.length - 1"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700"
            :disabled="!store.answers[store.currentIndex]"
            @click="store.nextQuestion"
          >下一步</button>

          <button
            v-else
            class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700"
            :disabled="!store.answers[store.currentIndex]"
            @click="store.submit"
          >提交</button>
        </div>
      </div>

      <div v-else class="bg-white p-8 rounded-2xl shadow text-center">
        <h2 class="text-xl font-bold mb-4">测评结果</h2>
        <div class="mb-6">
          <p>追求卓越：{{ store.scores.achievement?.toFixed(2) }}</p>
          <p>敏锐学习：{{ store.scores.learning?.toFixed(2) }}</p>
          <p>系统思考：{{ store.scores.thinking?.toFixed(2) }}</p>
          <p>人际通达：{{ store.scores.social?.toFixed(2) }}</p>
        </div>
        <p class="text-lg font-semibold mb-2">综合潜力得分：{{ store.total.toFixed(2) }}</p>
        <p class="text-xl font-bold text-blue-600">{{ store.level }}</p>
        <button class="mt-6 px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300" @click="store.restart">
          重新测评
        </button>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { useAfastStore } from '@/stores/useAfastStore'

const store = useAfastStore()
const scaleLabels = ['非常不同意', '不同意', '一般', '同意', '非常同意']
</script>
