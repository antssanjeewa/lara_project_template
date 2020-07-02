// **********************************************************************************************************
//                           Toggle the Dialog Form Visibility
// **********************************************************************************************************
export const set_toggle_form = ({commit}) => {
    return commit('set_dialog')
}

// **********************************************************************************************************
//                           Set the Edit Item Value
// **********************************************************************************************************
export const set_edit_item = ({commit},item) => {
    return commit('set_edit_item', item)
}

// **********************************************************************************************************
//                           Get all Items in database with Pagination
// **********************************************************************************************************
export const get_item_list = ({ commit },item) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/staff?page=${item.page}`,{params:{search:item.query}}).then(response => {
            // Response data store the state array through mutation
            commit('set_all_items', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}
// **********************************************************************************************************
//                           Add New Item to database
// **********************************************************************************************************
export const add_new_item = ({ dispatch },item) => {
    return new Promise((resolve, reject) => {
        axios.post('api/staff',item).then(response => {
            dispatch('set_message', { message: response.data.message, type: 'success' }, { root: true })
            resolve(response.data);
        }, error => {
            dispatch('set_message', { message: error.response.data, type: 'error' }, { root: true })
            reject(error);
        })
    })
}
// **********************************************************************************************************
//                           Update Exist Item in database
// **********************************************************************************************************
export const update_exist_item = ({ dispatch },item) => {
    return new Promise((resolve, reject) => {
        axios.put(`api/staff/${item.id}`, item).then(response => {
            dispatch('set_message', { message: response.data.message, type: 'success' }, { root: true })
            resolve(response.data);
        }, error => {
            dispatch('set_message', { message: error.response.data, type: 'error' }, { root: true })
            reject(error);
        })
    })
}
// **********************************************************************************************************
//                           Get Item Fully Details in database
// **********************************************************************************************************
export const get_item_details = ({ commit },id) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/staff/${id}`).then(response => {
            // Response data store the state array through mutation
            commit('set_active_item', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}
// **********************************************************************************************************
//                           Delete iven Item in database
// **********************************************************************************************************
export const delete_given_item = ({ commit },id) => {
    return new Promise((resolve, reject) => {
        axios.delete(`api/staff/${id}`).then(response => {
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get Item Fully Details in database
// **********************************************************************************************************
export const get_asserts = ({ commit }) => {
    return new Promise((resolve, reject) => {
        axios.get('api/staff/asserts').then(response => {
            // Response data store the state array through mutation
            commit('set_asserts', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Get Item Fully Details in database
// **********************************************************************************************************
export const get_login_user = ({ commit }) => {
    return new Promise((resolve, reject) => {
        axios.get('api/staff/login').then(response => {
            // Response data store the state array through mutation
            commit('set_login_user', response.data.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}