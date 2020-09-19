import Vue from 'vue'


let Cookie = require('tiny-cookie');

let VueCookie = {

  install(Vue) {
    Vue.prototype.$cookie = this;
    Vue.cookie = this;
  },

  set(name, value, options = {}) {

    let opts = Object.assign(
      {
        expires: '24h',
        secure: false,
        path: '/'
      },
      options,
    );

    return Cookie.set(
      name, 
      JSON.stringify(value), 
      opts
    );
  },

  get(key) {

    if(!key)return null;

    let cookie = Cookie.get(key)

    if(!cookie)return null

    try {
      return JSON.parse(cookie)
    } catch (error) {
      return cookie
    }
  },

  delete(key) {
    Cookie.remove(key)
  }
};

Vue.use(VueCookie)

export default VueCookie
