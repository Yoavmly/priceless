import {createRouter,createWebHistory} from "vue-router";


import Dashboard from "../views/Dashboard.vue";
import Register from "../views/Register.vue";
import Login from "../views/Login.vue";
import Forums from '../views/Forums.vue';
import Post from '../views/Post.vue';
import Topic from "../views/Topic.vue";
import CreatePost from "../views/CreatePost.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Verify from "../views/Verify.vue";
import Verified from "../views/Verified.vue";
import store from '../store/index.js';



const routes = [

    {
      path :'/',
      redirect: '/forums',
      component: DefaultLayout,
      children : [
          {
              path : '/dashboard',
              name  : 'dashboard',
              component : Dashboard
          },
          {
              path: '/',
              name: 'forums',
              component: Forums
          },
          {
              path: '/topic/:id',
              name: 'topic',
              component: Topic
          },
          {
              path: '/post/:id',
              name: 'post',
              component: Post
          },
          {
              path : '/topic/:id/createPost',
              name : 'createPost',
              component:  CreatePost
          }

      ]
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: ForgotPassword
    },
    {
        path:'/reset-password',
        name : 'resetPassword',
        component: ResetPassword
    },
    {
        path:'/verify',
        name : 'verify',
        component: Verify
    },
    {
        path:'/verified',
        name : 'verified',
        component: Verified
    }
]





const router = createRouter( {

    history : createWebHistory(),
    routes

})


router.beforeEach((to, from, next) => {
    if ((to.name === 'verify' || to.name === 'verified' || to.name ==='login' || to.name ==='register') && store.state.user.token !== null && store.state.user.data.email_verified_at !== null ) next({ path: '/' })
    else next()
})

export default router;
