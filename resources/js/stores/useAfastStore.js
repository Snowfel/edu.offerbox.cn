import { defineStore } from 'pinia'

export const useAfastStore = defineStore('afast', {
  state: () => ({
    questions: [],
    answers: [],
    currentIndex: 0,
    finished: false,
    scores: {}, // 每个维度5分制平均分
    total: 0,   // 综合5分制平均分
    level: '',
    scoresPercent: {}, // 每个维度百分制平均分
    totalPercent: 0, // 综合百分制
  }),

  getters: {
    progress(state) {
      return (state.answers.filter(v => v !== null).length / state.questions.length) * 100
    }
  },

  actions: {
    init() {
      this.questions = [
        // 追求卓越
        ...[
          '我会主动承担额外的工作任务，而不仅仅完成分配的任务。',
          '我经常为自己设定比组织要求更高的目标。',
          '遇到困难或挑战时，我会积极寻找解决方案，而不是放弃。',
          '我在工作中会主动寻找改进方法，提高效率和质量。',
          '我愿意投入额外时间和精力以保证工作成果的高质量。',
          '我会关注自己职业发展的长期目标，并为之努力。',
          '当团队遇到问题时，我会主动承担责任，提出可行方案。',
          '我会持续反思并改进自己的工作方法，以追求卓越表现。'
        ].map(q => ({ text: q, dim: 'achievement' })),

        // 人际通达
        ...[
          '我能理解和关注他人的需求与感受。',
          '我在遇到分歧时，能够积极寻找共识并推动解决方案。',
          '我乐于与团队成员交流，分享想法和经验。',
          '我在团队中能够有效地组织或协调他人的工作。',
          '我能够通过说服或引导，激励他人实现目标。',
          '我愿意从不同角度分析问题，考虑他人的意见。',
          '我能够在困难情境下保持冷静，并帮助团队达成共识。',
          '我主动建立信任关系，并有效影响团队氛围。'
        ].map(q => ({ text: q, dim: 'social' })),

        // 敏锐学习
        ...[
          '我乐于尝试新的方法或工具来解决问题。',
          '我会主动学习新知识并将其应用到实际工作中。',
          '我能够从经验和反馈中快速总结经验教训。',
          '我在面对新挑战时，能够快速适应并找到解决策略。',
          '我会不断探索新的技能或方法来提升工作效率。',
          '我愿意打破常规思维，尝试创新性的解决方案。',
          '我会主动学习他人的优秀做法并加以改进。',
          '我能够持续追踪行业或领域的新趋势，并思考应用价值。'
        ].map(q => ({ text: q, dim: 'learning' })),

        // 系统思考
        ...[
          '我在分析问题时，能够同时考虑多种因素和影响。',
          '我能够理解各项工作或决策之间的逻辑关系和连锁影响。',
          '我在做决策前，会权衡不同方案的优缺点。',
          '我能够提前预测潜在风险，并制定应对措施。',
          '我会从整体角度审视问题，而不仅关注局部细节。',
          '我在遇到复杂问题时，能够提出系统化解决方案。',
          '我能够整合不同来源的信息，做出理性分析。',
          '我在分析问题和制定方案时，能够保持客观和理性。'
        ].map(q => ({ text: q, dim: 'thinking' })),
      ]

      this.answers = Array(this.questions.length).fill(null)
      this.currentIndex = 0
      this.finished = false
      this.scores = {}
      this.total = 0
      this.level = ''
      this.totalPercent = 0
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
      const scoresPercent = {}

      dims.forEach((dim, i) => {
        const start = i * 8
        const slice = this.answers.slice(start, start + 8)
        scores[dim] = this.avg(slice)
        scoresPercent[dim] = this.avg(slice) * 20
      })

      this.scores = scores
      this.scoresPercent = scoresPercent
      this.total = (scores.achievement + scores.learning + scores.thinking + scores.social) / 4
      this.totalPercent = (this.total / 5) * 100 // 5分制转百分制
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