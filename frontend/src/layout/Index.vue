<template>
  <div v-if="flag.boolCarregado">
    <div>
      <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        app
        flat
        color="#ffffff"
        light
        style="border-bottom:solid 1px #e5e5e5"
      >
        <a href="/" class="d-flex router-link-active">
          <img src="https://cdn.vuetifyjs.com/images/logos/v-alt.svg" height="38px" width="38px" />
        </a>

        <v-toolbar-title
          class="ml-0 pl-4"
          width="400px"
          style="color:#3777a2;line-height: 14px !important;"
          v-if="$vuetify.breakpoint.lgAndUp"
        >
          <b>SysPag</b>
          <label style="font-size:.625rem;" v-if="$root.$session.getUsuarioLogado">
            <br />
            Olá, {{$root.$session.getUsuarioLogado.strNome}}. 
            <span>
              Seu saldo atual é de <span :style="'color:'+($root.$session.getSaldo == null || $root.$session.getSaldo == 0.00 ? 'red' : 'green')+' !important'">
                <b>R$ {{this.$utilidade.floatToMoney($root.$session.getSaldo != null ? $root.$session.getSaldo : '0.00')}}</b>
              </span>
            </span>
          </label>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-tabs right style="width:60% !important" icons-and-text v-model="rota" color="primary">
          <v-tab :to="{name:'login'}" v-if="!$root.$session.getUsuarioLogado" exact>
            Login
            <v-icon>fa fa-sign-in</v-icon>
          </v-tab>

          <v-tab :to="{name:'cadastrar'}" v-if="!$root.$session.getUsuarioLogado" exact>
            Cadastre-se
            <v-icon>fa fa-user-plus</v-icon>
          </v-tab>

          <v-tab :to="{name:'home'}" v-if="$root.$session.getUsuarioLogado">
            Início
            <v-icon>fa fa-home</v-icon>
          </v-tab>

          <v-tab :to="{name:'extrato'}" v-if="$root.$session.getUsuarioLogado">
            Extrato
            <v-icon>fa fa-file-text-o</v-icon>
          </v-tab>

          <v-tab
            :to="{name:'transferencia'}"
            v-if="$root.$session.getUsuarioLogado && $root.$session.getUsuarioLogado.obj_tipo_usuario.intId != 3"
          >
            Transferência
            <v-icon>fa fa-exchange</v-icon>
          </v-tab>

          <v-tab @click="$root.$session.logout()" v-if="$root.$session.getUsuarioLogado" exact>
            Sair
            <v-icon>fa fa-power-off</v-icon>
          </v-tab>
        </v-tabs>
      </v-app-bar>

      <v-main>
        <div class="d-flex flex-column pa-3" style="padding-bottom:100px !important">
          <div class="min">
            <transition name="fade" mode="out-in">
              <router-view />
            </transition>
          </div>
        </div>
      </v-main>
    </div>
  </div>
</template>

<script>
import { EdButton } from "template";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "layout-index",
  mixins: [],
  components: {
    EdButton,
  },
  data() {
    return {
      drawer: false,
      mini: false,
      rota: this.$route.name,
      flag: {
        boolCarregado: false,
      },
    };
  },
  beforeRouteUpdate(to, from, next) {
    this.validarRota(to, from, next);
  },
  created() {
    this.getUsuario();
  },
  mounted() {},
  computed: {},
  methods: {
    ...mapActions("common", ["setNavigation"]),

    getUsuario() {
      this.$root.$loading.set(true);

      this.$root.$request.get("usuario/me").then((result) => {
        if (result.status == 200) {
          this.$root.$session.setUsuarioLogado(result.data);
        }
        this.$root.$loading.set(false);
        this.flag.boolCarregado = true;
      });
    },

    getSaldoPorUsuario() {
      this.$root.$request.get("usuario/saldo").then((result) => {
        if (result.status == 200) {
          this.$root.$session.setSaldo(result.data);
        }
      });
    },

    validarRota(to, from, next) {
      if (!to) to = this.$route;

      document.title = to.meta.title;

      //VALIDAR AUTH
      if (to.meta.navigation) {
        this.setNavigation(to.meta.navigation);
      }

      if (!to.matched.some((record) => record.meta.requiresAuth)) {
        if (next) {
          next();
        }
      } else {
        if (!this.$root.$session.validarSessao()) {
          if (this.$route.name != "login")
            this.$router.push({
              name: "login",
            });
        } else {
          if (next) {
            next();
          }
        }
      }
    },
  },
};
</script>