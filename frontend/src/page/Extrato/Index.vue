<template>
  <div>
    <ed-modal v-model="showModalEdit" width="50%">
      <div slot="title">Adicionar dinheiro na minha carteira</div>
      <div slot="content">
        <ed-form
          :handler-save="salvar"
          labelButton="Inserir"
          :block="$root.$session.getUsuarioLogado.obj_tipo_usuario.intId == 3"
          block-message="Você não tem permissão para acessar essa tela. Entre em contato com o administrador do sistema."
        >
          <ed-input-text
            class="col-md-12"
            label="Qual o valor que dejeja incluir no seu saldo?"
            name="floatValor"
            rules="required"
            v-model="formData.floatValor"
            v-mask="'money'"
            icon-left="fa fa-usd"
          />
        </ed-form>
      </div>
    </ed-modal>

    <ed-table
      :headers="tableHeaders"
      :rows="tableRows"
      :loading="loading"
      :pagination="tablePagination"
      @search="getExtrato"
      @register="onRegister"
      :config="{registerName:'Inserir Dinheiro',disabledRegisterRow:$root.$session.getUsuarioLogado.obj_tipo_usuario.intId == 3}"
      :disabledRegisterRows="$root.$session.getUsuarioLogado.obj_tipo_usuario.intId == 3"
      disabledRowsDelete
    />
  </div>
</template>

<script>
import { EdTable, EdModal, EdInputText, EdInputSelect, EdForm } from "template";

export default {
  name: "PageTransferencia",
  components: {
    EdTable,
    EdModal,
    EdInputText,
    EdInputSelect,
    EdForm,
  },
  data() {
    return {
      tableHeaders: [
        {
          text: "Data",
          sortable: false,
          value: "strDataCadastro",
          width: "200px",
        },
        {
          text: "Histórico",
          sortable: false,
          value: "strHistorico",
        },
        {
          text: "Valor",
          sortable: false,
          value: "floatValor",
          width: "200px",
        },
      ],
      formData: {
        id: 0,
        intIdUsuarioBeneficiario: null,
        floatValor: null,
        floatSaldo: null,
        strObservacao: "Crédito adicionado",
      },
      list: {
        arrayBeneficiario: [],
      },
      tableRows: [],
      tablePagination: null,
      loading: false,
      showModalEdit: false,
    };
  },
  beforeDestroy() {
    this.tableRows = [];
    this.tableHeaders = [];
  },
  mounted() {
    this.getExtrato();
  },
  computed: {},
  methods: {
    onRegister() {
      this.formData.floatValor = null;
      this.showModalEdit = true;
    },

    getExtrato(busca) {
      this.loading = true;
      this.tablePagination = null;
      this.tableRows = [];

      this.$root.$request
        .get("extrato", {
          busca: busca,
        })
        .then((result) => {
          if (result.status == 200) {
            this.tablePagination = result.data;

            result.data.data.forEach((data) => {
              let strHistorico = data.strObservacao;

              if (data.obj_usuario_lancamento) {
                strHistorico += " > " + data.obj_usuario_lancamento.strNome;
              }

              let item = {
                intId: data.intId,
                strHistorico: strHistorico,
                floatValor: this.$utilidade.floatToMoney(
                  data.floatValor * parseInt(data.obj_tipo_lancamento.strValor)
                ),
                strDataCadastro: this.$utilidade.toDate(
                  data.strDataCadastro,
                  false
                ),
                disabledDeleteRows: true,
                style: "color:" + data.obj_tipo_lancamento.strCor,
                _item: data,
              };

              this.tableRows.push(item);
            });
          }
          this.loading = false;
          this.$parent.$parent.getSaldoPorUsuario();
        });
    },

    salvar() {
      this.$root.$loading.set(true);

      let formData = Object.assign({}, this.formData);
      formData.floatValor = this.$utilidade.moneyToFloat(formData.floatValor);

      this.$root.$request.post("extrato", formData).then((result) => {
        if (result.status == 200) {
          this.$root.$notify.success(
            "Valor inserido com sucesso em seu carteira"
          );
          this.showModalEdit = false;
          this.getExtrato();
        }

        this.$root.$loading.set(false);
      });
    },
  },
  watch: {},
};
</script>
