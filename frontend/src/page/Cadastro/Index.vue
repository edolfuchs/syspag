<template>
  <div>
    <ed-form
      :handler-save="salvar"
      labelButton="Cadastrar"
    >
      <h3 class="col-md-12 text-left">Novo Cadastro</h3>

      <ed-input-select
        class="col-md-12"
        label="Selecione um perfil de cadastro"
        name="intIdTipoUsuario"
        rules="required"
        v-model="formData.intIdTipoUsuario"
        :items="list.arrayTipoUsuario"
        
      />

      <ed-input-text
        class="col-md-4"
        label="Nome Completo"
        name="strNome"
        rules="required"
        v-model="formData.strNome"
        icon-left="fa fa-user"
        :disabled="!formData.intIdTipoUsuario"
      />

      <ed-input-text
        class="col-md-4"
        :label="(formData.intIdTipoUsuario == 2 ? 'CPF' : 'CNPJ')"
        name="strDocumento"
        rules="required"
        v-model="formData.strDocumento"
        icon-left="fa fa-id-card"
        :disabled="!formData.intIdTipoUsuario"
        v-mask="(formData.intIdTipoUsuario == 2 ? '999.999.999-99' : '99.999.999/9999-99')"
      />

      <ed-input-text
        class="col-md-4"
        label="Email"
        name="strEmail"
        rules="required|email"
        v-model="formData.strEmail"
        :disabled="!formData.intIdTipoUsuario"
        icon-left="fa fa-envelope"
      />

      <ed-input-text
        class="col-md-6"
        label="Escolha uma (mínimo 6 caracteres)"
        name="strSenha"
        rules="required"
        type="password"
        v-model="formData.strSenha"
        :disabled="!formData.intIdTipoUsuario"
        icon-left="fa fa-key"
      />

      <ed-input-text
        class="col-md-6"
        label="Confirme sua senha"
        name="strConfirmarSenha"
        rules="required"
        type="password"
        v-model="formData.strConfirmarSenha"
        :disabled="!formData.intIdTipoUsuario"
        icon-left="fa fa-key"
      />

    </ed-form>
  </div>
</template>

<script>
import { EdInputText, EdInputSelect,EdInputDatePicker, EdForm } from "template";


export default {
  name: "PageTransferenciaCadastrar",
  components: {
    EdForm,
    EdInputText,
    EdInputSelect,
    EdInputDatePicker,
  },
  data() {
    return {
      formData: {
        intId: 0,
        intIdTipoUsuario: null,
        strNome: null,
        strDocumento: null,
        strSenha:null,
        floatSaldo:null,
        strConfirmarSenha:null,
      },
      list: {
        arrayTipoUsuario: [
          {intId:2, strNome: "Comum"},
          {intId:3, strNome: "Lojista"}
        ],
      },
      flag:{
        boolLoadingUsuario:false
      }
    };
  },
  beforeDestroy() {
    this.formData = {};
    this.list = {};
  },
  mounted() {
  },
  computed: {
  },
  methods: {
    salvar() {
      this.$root.$loading.set(true);

      let formData = Object.assign(this.formData,{});
      formData.floatSaldo = this.$utilidade.moneyToFloat(formData.floatSaldo);

      this.$root.$request
        .post("cadastrar", formData)
        .then((result) => {

          if (result.status == 200) {
            this.$root.$notify.success("Cadastro efetuado com sucesso");
            this.$router.push({
              name: "login",
              query:{
                strEmail: result.data.strEmail
              }
            });
          }
          this.$root.$loading.set(false);
        });
    },
  },
  watch: {},
};
</script>
