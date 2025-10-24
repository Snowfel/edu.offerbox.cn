import { defineStore } from 'pinia'

export const useAfastStore = defineStore('afast', {
  state: () => ({
    questions: [],
    answers: [],
    currentIndex: 0,
    finished: false,
    scores: {},
    total: 0,
    level: '',
  }),

  getters: {
    progress(state) {
      return (state.answers.filter(v => v !== null).length / state.questions.length) * 100
    }
  },

  actions: {
    init() {
      this.questions = [
        // ✅ 追求卓越（Achievement）
        ...['我喜欢为自己设定更高目标', '我会主动承担困难任务', '遇到挫折时我仍能坚持目标', '我乐于接受绩效挑战', '我能快速纠正工作偏差', '我渴望在工作中表现出色', '我常反思并提升自己的表现', '我会为达成目标付出额外努力'].map(q => ({ text: q, dim: 'achievement' })),

        // ✅ 敏锐学习（Learning Agility）
        ...['我喜欢尝试新方法来解决问题', '我能从错误中快速吸取教训', '我喜欢跨领域学习', '我会主动寻求他人反馈', '我能灵活调整自己的做法', '我乐于学习新知识并应用到工作中', '我会从不同角度分析问题', '我在面对不确定性时保持积极态度'].map(q => ({ text: q, dim: 'learning' })),

        // ✅ 系统思考（System Thinking）
        ...['我能看清问题背后的根本原因', '我在决策时会考虑长远影响', '我善于分析复杂信息', '我能预见不同选择带来的连锁反应', '我会从整体角度理解组织运作', '我能整合多方意见做出平衡判断', '我倾向于制定系统化的解决方案', '我喜欢用逻辑分析来支持决策'].map(q => ({ text: q, dim: 'thinking' })),

        // ✅ 人际通达（Social Awareness）
        ...['我能察觉他人的情绪与需求', '我擅长与不同类型的人沟通', '我能在冲突中保持冷静', '我善于建立信任关系', '我能体谅他人的处境', '我会主动协调团队合作', '我乐于倾听不同意见', '我能准确传达自己的想法'].map(q => ({ text: q, dim: 'social' })),
      ]

      this.answers = Array(this.questions.length).fill(null)
      this.currentIndex = 0
      this.finished = false
      this.scores = {}
      this.total = 0
      this.level = ''
    },

    nextQuestion() {
      if (this.currentIndex < this.questions.length - 1) {
        this.currentIndex++
      }
    },

    prevQuestion() {
      if (this.currentIndex > 0) {
        this.currentIndex--
      }
    },

    submit() {
      this.calculateScores()
      this.finished = true
    },

    calculateScores() {
      const dims = ['achievement', 'learning', 'thinking', 'social']
      const scores = {}

      dims.forEach((dim, i) => {
        const start = i * 8
        const slice = this.answers.slice(start, start + 8)
        scores[dim] = this.avg(slice)
      })

      this.scores = scores
      this.total = (scores.achievement + scores.learning + scores.thinking + scores.social) / 4
      this.level = this.getLevel(this.total)
    },

    avg(arr) {
      const valid = arr.filter(v => v !== null)
      return valid.length ? valid.reduce((a, b) => a + b, 0) / valid.length : 0
    },

    getLevel(score) {
      if (score >= 4.5) return '极高潜力'
      if (score >= 4.0) return '高潜力'
      if (score >= 3.0) return '中等潜力'
      if (score >= 2.0) return '潜力有限'
      return '潜力较低'
    },

    restart() {
      this.init()
    }
  }
})
