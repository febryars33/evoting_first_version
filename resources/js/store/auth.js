import axios from 'axios'
import { removeHeaderToken, setHeaderToken } from '../utils/auth'

export default {
  state: {
    user: null,
    authenticated: false
  },

  mutations: {
    set_user (state, data) {
      state.user = data
      state.authenticated = true
    },

    reset_user (state) {
      state.user = null
      state.authenticated = false
    }
  },

  getters: {
    authenticated (state) {
      return state.authenticated
    },

    user (state) {
      return state.user
    }
  },

  actions: {
    login ({ dispatch, commit }, credentials) {
      return new Promise((resolve ,reject) => {
        axios.post('/api/v1/auth/login', credentials)
          .then(response => {
            const token = response.data.results.token
            localStorage.setItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME, token)
            setHeaderToken(token)
            dispatch('get_user')
            resolve(response)
          })
          .catch(error => {
            commit('reset_user')
            localStorage.removeItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME)
            reject(error)
          })
      })
    },

    async get_user({ commit }) {
      if(!localStorage.getItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME)) {
        return
      }

      try {
        const response = await axios.get('/api/v1/auth/session/userdata')
        commit('set_user', response.data.results)
        // console.log(response.data.results[0])
      } catch (error) {
        commit('reset_user')
        removeHeaderToken()
        localStorage.removeItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME)
        return error
      }
    },

    logout ({ commit }) {
      return new Promise((resolve) => {
        axios.post('/api/v1/auth/logout')
          .then((response) => {
            commit('reset_user')
            localStorage.removeItem(process.env.MIX_APP_SESSION_LOCAL_STORAGE_NAME)
            removeHeaderToken()
            resolve()
          })
          .catch((response) => {
            console.log('error logout')
          })
      })
    }
  }
}