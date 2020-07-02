import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import Dashboard from '../components/DashBoard'
import Assert from '../components/Assert'


import AssertType from '../components/AdminBoard/AssertType'
import ElementCategory from '../components/AdminBoard/ElementCategory'

import UserManage from '../components/Managment/User'
import RoleManage from '../components/Managment/Role'
import PermissionManage from '../components/Managment/Permission'

import Remarks from '../components/RemarkHistory'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/asserts', component: Assert },
    
    { path: '/assert_type', component: AssertType },
    { path: '/element_category', component: ElementCategory },
    
    { path: '/user_manage', component: UserManage },
    { path: '/role_manage', component: RoleManage },
    { path: '/permission_manage', component: PermissionManage },

    { path: '/remarks', component: Remarks },
  ]

export default new Router({
    routes
});