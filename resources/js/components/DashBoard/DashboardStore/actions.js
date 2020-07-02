// **********************************************************************************************************
//                           Add new Donation Record to the Database
// **********************************************************************************************************
export const set_toggle_navbar = ({commit}) => {
    return commit('set_drawer')
}

// **********************************************************************************************************
//                           Add new Donation Record to the Database
// **********************************************************************************************************
export const set_toggle_help_dialog = ({commit}) => {
    return commit('set_help_dialog')
}

// get all donation records in database
export const get_remarks = ({commit},page) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/remarks?page=${page}`).then(response => {
            commit('set_remark_history', response.data)
            resolve(response.data);
        }, error => {
            console.log(error.response)
            // http failed, let the calling function know that action did not work out
            reject(error);
        })
    })
}


// get all donation records in database
export const get_search_remarks = ({commit},item) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/remarks/search?page=${item.page}`,{ params: { searchquery: item.query , main:item.main, sub:item.sub}  
    }).then(response => {
            commit('set_remark_history', response.data)
            resolve(response.data);
        }, error => {
            console.log(error.response)
            reject(error);
        })
    })
}

