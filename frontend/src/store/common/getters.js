
const getConfig = (state) => {
  return state.config
}

const getResponse = (state) => {
  return state.response
}

const getNavigation = (state) => {
  return state.navigation
}

const getDrawer = (state) => {
  return state.drawer
}

const getDrawerHidden = (state) => {
  return state.drawer_hidden
}

export {
  getConfig,
  getResponse,
  getNavigation,
  getDrawer,
  getDrawerHidden
}
