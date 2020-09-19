<template>
  <div></div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "EdSession",
  components: {},
  data: () => ({
  }),
  mounted() {
  },
  computed: {
    ...mapGetters("common", ["getConfig"]),
    ...mapGetters("usuario", ["getUsuarioLogado","getSaldo"]),
  },
  watch: {
  },
  methods: {
    ...mapActions("usuario", ["setUsuarioLogado","setSaldo"]),
    ...mapActions("common", ["setConfig"]),

    login(result) {
      this.$cookie.set(this.getConfig.jwt, result.data.token, {
        expires: "12h",
      });
      this.setUsuarioLogado(result.data.usuario);
      this.$router.push({ name: "home" });
    },

    logout() {
      this.$root.$dialog
        .confirm(
          "Deseja realmente sair do sistema? Dados não salvos poderão ser perdidos."
        )
        .then(() => {
          this.$root.$loading.set(true);

          this.$root.$request.post("logout").then((result) => {
            this.$root.$loading.set(false);
            this.limparSessao();
          });
        });
    },

    limparSessao() {
      this.setUsuarioLogado(null);
      this.$cookie.delete(this.getConfig.jwt);
      this.$router.push({ name: "login" });
    },

    validarSessao() {
      if (!this.$cookie.get(this.getConfig.jwt)) return false;
      else return true;
    },
  },
};
</script>
