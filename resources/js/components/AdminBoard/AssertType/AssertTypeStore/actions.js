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
export const get_item_list = ({commit},page) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/assert_types?page=${page}`).then(response => {
            commit('set_item_list', response.data)
            resolve(response.data);
        }, error => {
            console.log(error.response)
            // http failed, let the calling function know that action did not work out
            reject(error);
        })
    })
}

