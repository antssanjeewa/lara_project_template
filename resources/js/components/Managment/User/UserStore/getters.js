import state from "./state";
// **********************************************************************************************************
//                           Get Dialog Value in the State
// **********************************************************************************************************
export const getDialog = (state) => {
    return state.dialog
}

// **********************************************************************************************************
//                           Get Item Object in the State
// **********************************************************************************************************
export const getItem = (state) => {
    return state.item
}

// **********************************************************************************************************
//                           Get All Item List in the State
// **********************************************************************************************************
export const getItemList = (state) => {
    return state.itemList
}

// **********************************************************************************************************
//                           Get All Item List in the State
// **********************************************************************************************************
export const getAsserts = (state) => {
    return state.asserts
}

// **********************************************************************************************************
//                           Get All Item List in the State
// **********************************************************************************************************
export const getLoginUser = (state) => {
    return state.loginUser
}