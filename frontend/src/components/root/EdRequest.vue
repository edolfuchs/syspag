<template>
<div></div>
</template>

<script>
import Axios from "axios";
import {
  mapActions,
  mapGetters
} from "vuex";

export default {
  name: "EdRequest",
  mixins: [],
  props: {
  },
  data() {
    return {
      requestParam: {
        url: process.env.URL_API+'api/',
        service: null,
        method: null,
        headers: null,
      },
    };
  },

  mounted() {
  },
  computed: {
    ...mapGetters("common", ["getResponse"]),
  },
  watch: {
    isOnline() {}
  },

  methods: {
    ...mapActions("common", ["setResponse"]),

    get(_service, _params = '') {

      if(_params && _params.busca){
        _params.page = _params.busca.page;
        delete _params.busca.page;
        delete _params.busca.isTrusted;
      }
      
      this.requestParam.service = _service + "?" + $.param(_params);
      this.requestParam.method = "GET";

      return this.request();
    },

    post(_service, _params, _filters, _force_web) {
      _filters = !_filters ? "" : "?" + $.param(_filters);

      this.requestParam.service = _service + _filters;
      this.requestParam.param = _params;
      this.requestParam.method = "POST";

      return this.request();
    },

    put(_service, _params, _filters, _force_web) {
      _filters = !_filters ? "" : "?" + $.param(_filters);

      this.requestParam.service = _service + _filters;
      this.requestParam.param = _params;
      this.requestParam.method = "PUT";

      return this.request();
    },

    delete(_service, _params, _filters, _force_web) {
      _filters = !_filters ? "" : "?" + $.param(_filters);

      this.requestParam.service = _service + _filters;
      this.requestParam.param = _params;
      this.requestParam.method = "DELETE";

      return this.request();
    },

    getHeaders() {
      let jwt = this.$cookie.get(this.$root.$session.getConfig.jwt);
      let version = this.$cookie.get("Version");

      var headers = {
        'Accept': "application/json",
        "Content-Type": "application/json;charset=UTF8",
        'Content-Type': 'application/json;charset=UTF8',
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'GET, POST, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept, X-File-Name, X-File-Size, X-File-Type'
      };

      if (jwt) {
        headers.Authorization = "Bearer " + jwt;
      }

      return headers;
    },

    setHeaders() {
      this.requestParam.headers = this.getHeaders();
      Axios.defaults.headers.common = this.requestParam.headers;
    },

    request() {

      this.setHeaders();

      let response = {};
      let promisses = [];

      return new Promise((resolve, reject) => {
        return Axios({
            method: this.requestParam.method,
            url: this.requestParam.service,
            data: this.requestParam.param,
            baseURL: this.requestParam.url,
            timeout: 60000
          })
          .then((result) => {
            response = result;
            promisses.push(response);

            this.setResponse(null);

            return Promise.all(promisses).then(
              (success) => {
                resolve(success[0]);
              },
              (err) => {}
            );
          })
          .catch((err) => {
            response = Object.assign({}, err).response;

            if (!response) {

              console.log(err)
              switch (err.code) {
                case 'ECONNABORTED':
                  err.message = 'Tempo limite excedido. Verifique sua conexão com a internet.'
                  break;

                default:
                  err.message = (err.message ? err.message : "Não foi possível completar a requisição") + '. Código do erro: ' + err.code
                  break;
              }

              response = {
                data: {
                  error: {
                    code: err.code,
                    msg: err.message,
                  },
                },
                status: 500,
              };
            }

            if (!response.data.error || !response.data.error.msg) {
              response.data = {
                error: {
                  msg: response.statusText
                }
              };
            }

            switch (response.status) {

              case 401:

                if (this.$route.meta.requiresAuth)
                  this.$root.$session.limparSessao();
                break;

              case 403:
                this.setNotificationError(response.data.error.msg);
                break;

              default:
                if (this.requestParam.method != 'GET') {
                  this.$root.$dialog.alert(response.data.error.msg);
                }
                break;
            }

            this.setResponse(response);
            promisses.push(response);

            return Promise.all(promisses).then(
              (success) => {
                resolve(success[0]);
              },
              (err) => {}
            );
          });
      });
    },
  },
};
</script>
