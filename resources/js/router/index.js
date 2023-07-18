import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Home.vue')
  },
  {
    path: '/login',
    name: 'Login',
    meta: {
      guest: true
    },
    component: () => import('../views/auth/Login.vue')
  },
  {
    path: '/about-us',
    name: 'AboutUs',
    component: () => import('../views/AboutUs.vue')
  },
  {
    path: '/contact-us',
    name: 'ContactUs',
    component: () => import('../views/ContactUs.vue')
  },
  // {
  //   path: '/quick-count',
  //   name: 'QuickCount',
  //   component: () => import('../views/QuickCount.vue')
  // },
  {
    path: '/vote',
    name: 'Vote',
    meta: {
      auth: true
    },
    component: () => import('../views/Vote.vue')
  },
  {
    path: '/candidates/:id',
    name: 'CandidateDetail',
    meta: {
      auth: true
    },
    component: () => import('../views/CandidateDetail.vue')
  },
  {
    path: '/control-panel',
    name: 'ControlPanel',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/Index.vue')
  },
  {
    path: '/control-panel/students',
    name: 'Students',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/students/Index.vue')
  },
  {
    path: '/control-panel/students/create',
    name: 'StudentsCreate',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/students/Create.vue')
  },
  {
    path: '/control-panel/students/:student_number',
    name: 'StudentsView',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/students/View.vue')
  },
  {
    path: '/control-panel/candidates',
    name: 'CandidatesIndex',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/candidates/Index.vue')
  },
  {
    path: '/control-panel/candidates/create',
    name: 'CandidatesCreate',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/candidates/Create.vue')
  },
  {
    path: '/control-panel/configurations/voting',
    name: 'VotingConfiguration',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/configuration/Voting.vue')
  },
  {
    path: '/control-panel/configurations/user',
    name: 'UserConfiguration',
    meta: {
      admin: true
    },
    component: () => import('../views/control_panel/configuration/User.vue')
  },
  {
    path: '*',
    name: '404',
    component: () => import('../views/errors/Error404.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  linkActiveClass: 'active',
  linkExactActiveClass: 'exact-active',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.auth)) {
    if (store.getters.authenticated && store.getters.user) {
      next()
      return
    }
    next('/login')
  }

  if (to.matched.some((record) => record.meta.admin)) {
    if (store.getters.authenticated && store.getters.user.userdata.is_admin) {
      next()
      return
    }
    next('/')
  }

  if (to.matched.some((record) => record.meta.guest)) {
    if (!store.getters.authenticated) {
      next()
      return
    }
    next('/')
  }

  next()
})

export default router
