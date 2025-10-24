<template>
  <div class="container mx-auto p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6 text-center">人才盘点绩效测评</h1>

    <!-- 测评卡片 -->
    <div v-if="!store.finished" class="bg-white rounded-2xl shadow p-6">
      <div v-for="(q, idx) in store.currentQuestions" :key="idx" class="mb-4">
        <p class="text-lg font-semibold mb-2">{{ q.text }}</p>

        <div class="grid grid-cols-5 gap-4">
          <label
            v-for="n in 5"
            :key="n"
            class="flex flex-col items-center cursor-pointer border rounded-lg p-2 hover:border-blue-500"
            :class="{'border-blue-600 bg-blue-50': store.answers[store.currentPage * store.pageSize + idx] === n}"
          >
            <input
              type="radio"
              :name="'q' + (store.currentPage * store.pageSize + idx)"
              :value="n"
              v-model.number="store.answers[store.currentPage * store.pageSize + idx]"
              class="hidden"
            />
            <span class="text-sm">{{ scaleLabels[n - 1] }}</span>
            <span class="mt-1 text-lg font-bold">{{ n }}</span>
          </label>
        </div>
      </div>

      <!-- 进度条 -->
      <div class="mb-6">
        <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
          <div class="bg-blue-600 h-3" :style="{ width: store.progress + '%' }"></div>
        </div>
        <p class="text-sm mt-1 text-gray-600">{{ store.progress.toFixed(0) }}% 已完成</p>
      </div>

      <!-- 分页按钮 -->
      <div class="flex justify-between">
        <button
          class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50"
          :disabled="store.currentPage === 0"
          @click="store.prevPage"
        >
          上一页
        </button>

        <button
          class="px-4 py-2 bg-blue-600 text-white rounded disabled:opacity-50"
          :disabled="!isCurrentPageCompleted"
          @click="nextOrSubmit"
        >
          {{ store.currentPage === store.totalPages -1 ? '提交' : '下一页' }}
        </button>
      </div>
    </div>

    <!-- 测评完成显示 -->
    <div v-else class="text-center">
      <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-xl font-semibold mb-4">测评完成！</p>
        <p class="text-lg mb-1">综合得分（5分制）：<strong>{{ store.total.toFixed(2) }}</strong></p>
        <p class="text-lg mb-1">综合得分（百分制）：<strong>{{ store.totalPercent.toFixed(0) }}%</strong></p>
        <p class="text-lg mb-4">绩效等级：<strong>{{ store.level }}</strong></p>
        <button
          class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          @click="store.restart(store.pageSize)"
        >
          重新测评
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { usePerformanceStore } from '@/stores/usePerformanceStore'

const store = usePerformanceStore()
const scaleLabels = ['非常不同意','不同意','一般','同意','非常同意']

// 页面首次加载初始化题目
onMounted(() => {
  if (!store.questions || store.questions.length === 0) {
    store.init(3) // 每页显示3题
  }
})

// 检查当前页题目是否都已作答
const isCurrentPageCompleted = computed(() => {
  const start = store.currentPage * store.pageSize
  const end = start + store.pageSize
  const slice = store.answers.slice(start, end)
  return slice.every(v => v !== null)
})

const nextOrSubmit = () => {
  if (store.currentPage === store.totalPages - 1) {
    store.submit()
  } else {
    store.nextPage()
  }
}
</script>
