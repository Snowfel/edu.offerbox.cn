import { defineStore } from 'pinia'

export const usePerformanceStore = defineStore('performance', {
  state: () => ({
    questions: [],
    answers: [],
    currentPage: 0,        // 当前页码
    pageSize: 3,           // 每页题目数量，可自定义
    finished: false,
    scores: {},
    total: 0,
    totalPercent: 0,
    level: '',
  }),

  getters: {
    // 当前页题目
    currentQuestions(state) {
      const start = state.currentPage * state.pageSize
      return state.questions.slice(start, start + state.pageSize)
    },
    // 总页数
    totalPages(state) {
      return Math.ceil(state.questions.length / state.pageSize)
    },
    // 已完成进度
    progress(state) {
      const answered = state.answers.filter(v => v !== null).length
      return (answered / state.questions.length) * 100
    }
  },

  actions: {
    init(pageSize = 3) {
      this.pageSize = pageSize
      this.currentPage = 0
      this.finished = false
      this.scores = {}
      this.total = 0
      this.totalPercent = 0
      this.level = ''

      // 题库略，可使用之前 48 道题
      this.questions = [
        // 结果导向 Result
        { text: '我能按时完成工作目标，并确保质量达标。', dim: 'result' },
        { text: '我在完成任务时，会主动评估进度并调整计划。', dim: 'result' },
        { text: '我会优先处理对组织目标影响最大的任务。', dim: 'result' },
        { text: '我能够在压力下保持高效率产出。', dim: 'result' },
        { text: '我会定期检查自己的目标完成情况，并主动汇报。', dim: 'result' },
        { text: '我能够在关键时刻完成对组织最重要的工作。', dim: 'result' },

        // 工作质量 Quality
        { text: '我注重工作的细节和准确性。', dim: 'quality' },
        { text: '我在完成任务时，力求成果超出基本要求。', dim: 'quality' },
        { text: '我会主动改进工作流程以提高质量。', dim: 'quality' },
        { text: '我能及时发现并纠正工作中的错误。', dim: 'quality' },
        { text: '我会参考最佳实践来确保产出质量。', dim: 'quality' },
        { text: '我在工作中坚持高标准，不轻易妥协。', dim: 'quality' },

        // 主动性 Initiative
        { text: '我会主动承担额外任务而不是等待分配。', dim: 'initiative' },
        { text: '我在发现问题时会主动提出解决方案。', dim: 'initiative' },
        { text: '我会主动学习新技能来提升工作能力。', dim: 'initiative' },
        { text: '我会在团队中主动提出改进建议。', dim: 'initiative' },
        { text: '我在工作中主动寻找创新的解决方法。', dim: 'initiative' },
        { text: '我会积极承担挑战性的工作任务。', dim: 'initiative' },

        // 团队协作 Team
        { text: '我能有效与团队成员沟通达成共识。', dim: 'team' },
        { text: '我乐于分享经验帮助团队共同成长。', dim: 'team' },
        { text: '我在团队中能够协调不同意见，推动决策。', dim: 'team' },
        { text: '我会主动支持团队成员完成工作。', dim: 'team' },
        { text: '我能在冲突中保持理性并促进合作。', dim: 'team' },
        { text: '我能够在团队中发挥积极影响力。', dim: 'team' },

        // 改进能力 Improvement
        { text: '我会主动总结工作经验，不断优化方法。', dim: 'improvement' },
        { text: '我愿意尝试新的工具或流程提升效率。', dim: 'improvement' },
        { text: '我会根据反馈及时调整自己的工作方法。', dim: 'improvement' },
        { text: '我能从失败中吸取教训，改进行为。', dim: 'improvement' },
        { text: '我会定期反思并设定个人改进目标。', dim: 'improvement' },
        { text: '我能主动发现问题并提出改进措施。', dim: 'improvement' },

        // 影响力 Impact
        { text: '我的工作成果对团队和组织有积极影响。', dim: 'impact' },
        { text: '我能通过自己的行动激励他人提高效率。', dim: 'impact' },
        { text: '我能在关键时刻推动重要项目落地。', dim: 'impact' },
        { text: '我能清晰表达意见并赢得他人认同。', dim: 'impact' },
        { text: '我的工作决策能够带来明显的正面效果。', dim: 'impact' },
        { text: '我能影响团队在复杂情况下保持高效运作。', dim: 'impact' },

        // 贡献度 Contribution
        { text: '我对组织目标达成的贡献是可量化的。', dim: 'contribution' },
        { text: '我能在团队中主动承担关键责任。', dim: 'contribution' },
        { text: '我的工作成果超出常规预期。', dim: 'contribution' },
        { text: '我能在关键任务中发挥重要作用。', dim: 'contribution' },
        { text: '我会积极参与跨部门协作。', dim: 'contribution' },
        { text: '我对组织整体绩效的提升有明显贡献。', dim: 'contribution' },

        // 稳定性 Stability
        { text: '我在工作中保持稳定的产出水平。', dim: 'stability' },
        { text: '我能在压力和变化中保持良好状态。', dim: 'stability' },
        { text: '我在关键项目中表现可靠。', dim: 'stability' },
        { text: '我能持续高效地完成重复性任务。', dim: 'stability' },
        { text: '我能够在不确定环境下做出合理决策。', dim: 'stability' },
        { text: '我能稳定保持工作质量，不受情绪影响。', dim: 'stability' },
      ]
      this.answers = Array(this.questions.length).fill(null)
    },

    nextPage() {
      if (this.currentPage < this.totalPages - 1) this.currentPage++
    },

    prevPage() {
      if (this.currentPage > 0) this.currentPage--
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
      if (score >= 4.5) return '卓越'
      if (score >= 4.0) return '优秀'
      if (score >= 3.0) return '满意'
      if (score >= 2.0) return '待改进'
      return '不胜任'
    },

    restart(pageSize = 3) {
      this.init(pageSize)
    }
  }
})
