const SET_CONFIG = (state, config) => {
  state.config = Object.assign(state.config,config)
}

const SET_RESPONSE = (state, response) => {
  state.response = response
}

const SET_NAVIGATION = (state, navigation) => {
  state.navigation = navigation
}

const SET_DRAWER = (state, drawer) => {
  state.drawer = !state.drawer
}

const SET_DRAWER_HIDDEN = (state, drawer_hidden) => {
  state.drawer_hidden = (drawer_hidden === undefined ? false : drawer_hidden)
}

export {
  SET_CONFIG,
  SET_RESPONSE,
  SET_NAVIGATION,
  SET_DRAWER,
  SET_DRAWER_HIDDEN
}
