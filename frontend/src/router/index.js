import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  history: true,
  mode: 'history',
  routes: [
    {
      name: '404',
      path: '*',
      component: () => import('@/layout/404'),
    },
    {
      path: '/',
      component: () => import('@/layout/Index'),
      children: [
        {
          path: '',
          name:'login',
          component: () => import('page/Login/Index'),
          meta: {
            requiresAuth: false,
            title: 'Login',
            navigation: []
          },
        },
        {
          path: 'cadastrar',
          name:'cadastrar',
          component: () => import('page/Cadastro/Index'),
          meta: {
            requiresAuth: false,
            title: 'Novo Cadastro',
            navigation: []
          },
        },
        {
          path: 'inicio',
          name:'home',
          component: () => import('page/Home/Index'),
          meta: {
            requiresAuth: true,
            title: 'Incício',
            navigation: []
          },
        },
        {
          path: 'transferencia',
          name:'transferencia',
          component: () => import('page/Transferencia/Index'),
          meta: {
            requiresAuth: true,
            title: 'Transferência',
            navigation: []
          },
        },
        {
          path: 'extrato',
          name:'extrato',
          component: () => import('page/Extrato/Index'),
          meta: {
            requiresAuth: true,
            title: 'Extrato',
            navigation: []
          },
        },
      ]
    }
  ]
})
