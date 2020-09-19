<template>
  <v-main class="pa-0" v-if="flag.carregado">
    <v-container class="fill-height" fluid>
      <div class="row align-center justify-center d-flex">
        <div class="col-sm-8 col-md-4 col-12 align-self-stretch">
          <v-card class="elevation-12">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>Dados de Acesso</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
              <ed-form
                :handler-save="postLogin"
                :formData="formData"
                iconButton="fa fa-sign-in"
                labelButton="Entrar"
                classFooter="text-center"
              >
                <ed-input-text
                  class="col-12"
                  label="Digite seu Email"
                  name="strEmail"
                  v-model="formData.strEmail"
                  icon-left="fa fa-envelope-o"
                  outlined
                  rules="required|email"
                  type="email"
                />

                <ed-input-text
                  class="col-12"
                  label="Digite sua Senha"
                  name="strSenha"
                  v-model="formData.strSenha"
                  type="password"
                  icon-left="fa fa-lock"
                  outlined
                />
              </ed-form>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </v-container>
  </v-main>
</template>

<script>
import { EdButton, EdInputText, EdForm } from "template";

export default {
  name: "PageAuthLogin",
  mixins: [],
  components: { EdButton, EdInputText, EdForm },
  data() {
    return {
      flag: {
        carregado: false,
      },
      formData: {
        strEmail: this.$route.query.strEmail
          ? this.$route.query.strEmail
          : null,
        strSenha: null,
      },
    };
  },
  created() {
    if (this.$root.$session.validarSessao()) {
      this.$router.push({ name: "home" });
      return;
    }

    this.flag.carregado = true;
  },
  mounted() {},
  computed: {},
  methods: {
    postLogin() {
      this.$root.$loading.set(true);

      this.$root.$request.post("login", this.formData).then((result) => {
        this.$root.$loading.set(false);

        if (result.status == 200) {
          this.$root.$session.login(result);
        }
      });
    },
  },
  watch: {},
};
</script>

