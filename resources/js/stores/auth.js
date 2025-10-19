// resources/js/stores/auth.js
import { defineStore } from 'pinia'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    loginid: sessionStorage.getItem('user_loginid') || null,
    isLoggedIn: !!sessionStorage.getItem('user_loginid'),
  }),

  actions: {
    async checkLogin() {
      if (!this.loginid) {
        this.isLoggedIn = false
        return false
      }

      try {
        const res = await axios.post(route('user.login.check'), { loginid: this.loginid })
        if (res.data.ret === 'success') {
          this.isLoggedIn = true
          return true
        } else {
          this.logout()
          return false
        }
      } catch (e) {
        console.error('登录检查失败:', e)
        this.logout()
        return false
      }
    },

    async login(pwd) {
      try {
        const res = await axios.post(route('user.login.submit'), { pwd: pwd })
        if (res.data.ret === 'success') {
          this.loginid = res.data.loginid
          this.isLoggedIn = true
          sessionStorage.setItem('user_loginid', this.loginid)
          return true
        } else {
          alert('登录码错误')
          return false
        }
      } catch (e) {
        alert('请求失败，请稍后重试')
        return false
      }
    },

    logout() {
      this.loginid = null
      this.isLoggedIn = false
      sessionStorage.removeItem('user_loginid')
      router.visit(route('wy.lexicon.login'))
    },
  },
})
