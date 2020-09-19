

const setConfig = (context, config) => {
  context.commit('SET_CONFIG', config)
}

const setResponse = (context, response) => {
  context.commit('SET_RESPONSE', response)
}


const setNavigation = (context, navigation) => {
  context.commit('SET_NAVIGATION', navigation)
}

const setDrawer = (context, drawer) => {
  context.commit('SET_DRAWER', drawer)
}

const setDrawerHidden = (context, drawer_hidden) => {
  context.commit('SET_DRAWER_HIDDEN', drawer_hidden)
}

export {
  setConfig,
  setResponse,
  setNavigation,
  setDrawer,
  setDrawerHidden
}
