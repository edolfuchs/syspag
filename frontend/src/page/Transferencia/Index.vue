<template>
  <div>
    <ed-modal v-model="flag.boolShowModalEdit" width="50%">
      <div slot="title">Efetuar Nova Transferência</div>
      <div slot="content">
        <ed-form
          :handler-save="salvar"
          labelButton="Transferir"
          :block="$root.$session.getUsuarioLogado.obj_tipo_usuario.intId == 3"
          block-message="Você não tem permissão para acessar essa tela. Entre em contato com o administrador do sistema."
        >
          <ed-input-select
            class="col-md-12"
            label="Selecione o Beneficiário"
            name="intIdUsuarioBeneficiario"
            rules="required"
            v-model="formData.intIdUsuarioBeneficiario"
            :items="list.arrayBeneficiario"
            icon-left="fa fa-user"
          />

          <ed-input-text
            class="col-md-12"
            label="Qual o valor a transferir?"
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
      :loading="flag.boolLoadingTable"
      :pagination="tablePagination"
      @search="getTransferencia"
      @register="onRegister"
      :config="{registerName:'Nova Transferência',disabledRegisterRow:$root.$session.getUsuarioLogado.obj_tipo_usuario.intId == 3}"
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
          value: "strDataTransferencia",
          width: "150px",
        },
        {
          text: "Beneficiário",
          sortable: false,
          value: "strBeneficiario",
        },
        {
          text: "Valor",
          sortable: false,
          value: "floatValor",
        },
        {
          text: "Status",
          sortable: false,
          value: "strStatus",
        },
        {
          text: "Notificação da Transferência",
          sortable: false,
          value: "strDataNotificacao",
        },
      ],
      formData: {
        id: 0,
        intIdUsuarioBeneficiario: null,
        floatValor: null,
        strDataTransferencia: this.$utilidade.toDate(null, true),
      },
      strHoje: this.$utilidade.toDate(null, true),
      list: {
        arrayBeneficiario: [],
      },
      tableRows: [],
      tablePagination: null,
      flag: {
        boolLoadingUsuario: false,
        boolLoadingTable: false,
        boolShowModalEdit: false,
      },
    };
  },
  beforeDestroy() {
    this.tableRows = [];
    this.tableHeaders = [];
  },
  mounted() {
    this.getTransferencia();
    this.getUsuario();
  },
  computed: {},
  methods: {
    onRegister() {
      this.flag.boolShowModalEdit = true;
    },

    getUsuario() {
      this.flag.boolLoadingUsuario = true;
      this.list.arrayBeneficiario = [];

      this.$root.$request.get("usuario", {}).then((result) => {
        if (result.status == 200) {
          this.list.arrayBeneficiario = result.data.data;
        }
        this.flag.boolLoadingUsuario = false;
      });
    },

    getTransferencia(busca) {
      this.flag.boolLoadingTable = true;
      this.tablePagination = null;
      this.tableRows = [];

      this.$root.$request
        .get("transferencia", {
          busca: busca,
        })
        .then((result) => {
          if (result.status == 200) {
            this.tablePagination = result.data;

            result.data.data.forEach((data) => {
              let strDataNotificacao = data.strObservacao;

              if (data.strDataNotificacao) {
                strDataNotificacao =
                  "Usuário notificado em " +
                  this.$utilidade.toDate(data.strDataNotificacao);
              }

              let item = {
                intId: data.intId,
                strBeneficiario: data.obj_usuario_beneficiario.strNome,
                floatValor: this.$utilidade.floatToMoney(data.floatValor),
                strDataTransferencia: data.strDataTransferencia,
                strStatus: data.obj_tipo_status_transferencia.strNome,
                strDataNotificacao: strDataNotificacao,
                disabledDeleteRows:
                  data.obj_tipo_status_transferencia.intId != 9,
                style: "color:" + data.obj_tipo_status_transferencia.strCor,
                _item: data,
              };

              this.tableRows.push(item);
            });
          }
          this.flag.boolLoadingTable = false;
          this.$parent.$parent.getSaldoPorUsuario();
        });
    },

    salvar() {
      this.$root.$loading.set(true);

      let formData = Object.assign({}, this.formData);
      formData.floatValor = this.$utilidade.moneyToFloat(formData.floatValor);

      this.$root.$request.post("transferencia", formData).then((result) => {
        if (result.status == 200) {
          this.$root.$notify.success("Transferência cadastrado com sucesso");
          this.getTransferencia();
          this.flag.boolShowModalEdit = false;
        }

        this.$root.$loading.set(false);
      });
    },
  },
  watch: {},
};
</script>
