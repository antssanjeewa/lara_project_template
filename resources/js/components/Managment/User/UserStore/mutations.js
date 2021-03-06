
// **********************************************************************************************************
//                           Set Dialog Value in State
// **********************************************************************************************************
export const set_dialog = (state) => {
    return state.dialog = !state.dialog
}

// **********************************************************************************************************
//                           Assign Item to value in State
// **********************************************************************************************************
export const set_edit_item = (state,editItem) => {
    if(editItem){
        return Object.assign(state.item, editItem)
    }else{
        return Object.assign(state.item, state.defaultItem)
    }
}

// **********************************************************************************************************
//                           Set All Item to  Array in State
// **********************************************************************************************************
export const set_all_items = (state, items) => {
    return state.itemList = items
}

// **********************************************************************************************************
//                           Set Active Item in State
// **********************************************************************************************************
export const set_active_item = (state, item) => {
    return state.activeItem = item
}

// **********************************************************************************************************
//                           Set Active Item in State
// **********************************************************************************************************
export const set_asserts = (state, item) => {
    return state.asserts = item
}

// **********************************************************************************************************
//                           Set Active Item in State
// **********************************************************************************************************
export const set_login_user = (state, item) => {
    return state.loginUser = item
}