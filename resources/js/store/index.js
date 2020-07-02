import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'


//===========================================================================================================
//                                      Common Components
//===========================================================================================================
import dashboard from '../components/DashBoard/DashboardStore'

import assert_type from '../components/AdminBoard/AssertType/AssertTypeStore'
import element_category from '../components/AdminBoard/ElementCategory/ElementCategoryStore'

import staff from '../components/Managment/User/UserStore'
import role from '../components/Managment/Role/RoleStore'
import permission from '../components/Managment/Permission/PermissionStore'



export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules: {
        //------------------------------------- Common --------------------------------------------------------------

        dashboard,

        assert_type,
        element_category,

        staff,
        role,
        permission
    }
});