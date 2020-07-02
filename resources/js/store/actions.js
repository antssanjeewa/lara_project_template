import Axios from "axios";

// set message top popup
export const set_message = ({ commit }, message) => {
    commit('set_message', message)
}

// set loader
export const set_loader = ({ commit }) => {
    commit('set_loader')
}