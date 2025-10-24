import { defineStore } from 'pinia'

export const usePerformanceStore = defineStore('performance', {
  state: () => ({
    questions: [],       // 绩效题库
    answers: [],         // 用户答案
    currentIndex: 0,     // 当前题目索引
    finished: false,
    scores: {},          // 每个维度平均分（5分制）
    total: 0,            // 综合5分制
    totalPercent: 0,     // 百分制
    level: '',           // 等级
  }),

  getters: {
    progress(state) {
      return (state.answers.filter(v => v !== null).length / state.questions.length) * 100
    }
  },

  actions: {
    init() {
      // 绩效题目示例（可根据实际需求扩展）
      this.questions = [
        { text: '本季度目标完成情况如何？', dim: 'result' },
        { text: '工作质量是否达到组织期望？', dim: 'quality' },
        { text: '在工作中是否积极主动承担责任？', dim: 'initiative' },
        { text: '团队协作与沟通表现如何？', dim: 'team' },
        { text: '是否持续提升自身工作方法和效率？', dim: 'improvement' },
        { text: '是否在关键项目中取得超预期成果？', dim: 'impact' },
        { text: '对组织目标达成贡献是否明显？', dim: 'contribution' },
        { text: '在困难情境下能否稳定产出？', dim: 'stability' },
      ]

      this.answers = Array(this.questions.length).fill(null)
      this.currentIndex = 0
      this.finished = false
      this.scores = {}
      this.total = 0
      this.totalPercent = 0
      this.level = ''
    },

    nextQuestion() {
      if (this.currentIndex < this.questions.length - 1) this.currentIndex++
    },

    prevQuestion() {
      if (this.currentIndex > 0) this.currentIndex--
    },

    submit() {
      this.calculateScores()
      this.finished = true
    },

    calculateScores() {
      const dims = Array.from(new Set(this.questions.map(q => q.dim)))
      const scores = {}

      dims.forEach(dim => {
        const slice = this.questions
          .map((q, i) => ({ q, a: this.answers[i] }))
          .filter(item => item.q.dim === dim)
          .map(item => item.a)
        scores[dim] = this.avg(slice)
      })

      this.scores = scores
      this.total = Object.values(scores).reduce((a, b) => a + b, 0) / dims.length
      this.totalPercent = (this.total / 5) * 100
      this.level = this.getLevel(this.total)
    },

    avg(arr) {
      const valid = arr.filter(v => v !== null)
      return valid.length ? valid.reduce((a, b) => a + b, 0) / valid.length : 0
    },

    getLevel(score) {
      if (score >= 4.5) return '卓越'       // 90-100
      if (score >= 4.0) return '优秀'       // 80-89
      if (score >= 3.0) return '满意'       // 70-79
      if (score >= 2.0) return '待改进'     // 60-69
      return '不胜任'                        // 0-59
    },

    restart() {
      this.init()
    }
  }
})
