import state from "./state";

//get message
export const getMessage = (state) => {
    return state.message
}

// get theme data
export const getTheme = (state) => {
    return state.themeData
}

// get Loader
export const getLoader = (state) => {
    return state.loader
}
