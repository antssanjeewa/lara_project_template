
// Set nav bar show / hide
export const set_drawer = (state) => {
    return state.drawer = !state.drawer
}

// Set nav bar show / hide
export const set_help_dialog = (state) => {
    return state.helpDialog = !state.helpDialog
}


// set update item to form
export const set_remark_history = (state, item) => {
    return state.remarks = item
}
