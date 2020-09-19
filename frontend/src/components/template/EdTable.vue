<template>
  <div class="row">
    <div class="text-left col-xs-12 col-md-12 col-lg-12 col-xl-12" v-if="!disabledRegisterRows">
      <ed-button
        :label="getConfig.registerName"
        :disabled="getConfig.disabledRegisterRow"
        color="primary"
        class="mr-1"
        iconLeft="fa fa-plus-circle"
        @click="$emit('register')"
      />
    </div>

    <div class="text-left col-12">
      <v-data-table
        class="elevation-1 ed-table mb-4"
        v-model="selected"
        :headers="tableHeaders"
        :options.sync="options"
        :items="tableRows"
        :loading="loading"
        hide-default-footer
        dense
        loading-text="Carregando..."
        no-data-text="Nenhum registro encontrado"
      >
        <!--
            <template v-for="(header,indexHeader) in headers" v-slot:[`item.${header.value}`]="{ item }">
              <span :class="(item._item.ativo == 0 ? 'ed-inativo' : '')" :title="(item._item.ativo == 0 ? 'Registro inativo' : '')">
                {{item[header.value]}}
              </span>
            </template>
        -->
        <template v-for="(header,indexHeader) in headers" v-slot:[`item.${header.value}`]="{ item }">
          <span
            :class="(item._item.ativo == 0 ? 'ed-inativo' : '')"
            :title="(item._item.ativo == 0 ? 'Registro inativo' : '')"
            :style="(item.style ? item.style : '')"
            :key="indexHeader"
            v-html="item[header.value]"
          ></span>
        </template>
      </v-data-table>

      <ed-pagination v-if="pagination && !loading" :pagination="pagination" @page="onBusca" />
    </div>
  </div>
</template>
</template>
</v-data-table>
</v-card>
</div>
</template>
</v-data-table>
</v-card>
</div>
</template>

<script>
import { mapGetters } from "vuex";
import { EdButton, EdInputText, EdPagination, EdAlert } from "template";

export default {
  name: "EdTable",
  components: {
    EdButton,
    EdInputText,
    EdPagination,
    EdAlert,
  },
  props: {
    headers: {
      type: Array,
      required: false,
      default: function () {
        return [];
      },
    },
    rows: {
      type: Array,
      required: false,
      default: function () {
        return [];
      },
    },
    pagination: {
      type: Object,
      required: false,
      default: function () {
        return null;
      },
    },
    config:{
      type: Object,
      required: false,
      default: function () {
        return {};
      },
    },  
    loading: {
      type: Boolean,
      required: false,
      default: function () {
        return false;
      },
    },
    disabledRegisterRows: {
      type: Boolean,
      required: false,
      default: function () {
        return false;
      },
    },
    disabledUpdatedRows: {
      type: Boolean,
      required: false,
      default: function () {
        return false;
      },
    },
  },
  beforeDestroy() {
    this.selected = [];
    this.tableHeaders = [];
    this.tableRows = [];
  },
  data() {
    return {
      selected: [],
      tableHeaders: [],
      tableRows: [],
      options: null,
      drawer: false,
    };
  },
  created() {},
  mounted() {
    this.inicialize();
  },
  computed: {
    ...mapGetters("common", ["getResponse"]),
    getConfig(){
      return Object.assign(
        {
          registerName:'Novo Registro',
        },
      this.config)
    }
  },
  methods: {
    inicialize() {

      this.tableHeaders = [];
      this.tableRows = [];

      this.headers.forEach((header) => {
        this.tableHeaders.push(header);
      });

      this.rows.forEach((row) => {
        this.tableRows.push(row);
      });
    },

    onBusca(page = {}) {
      this.$emit("search", Object.assign(this.busca, page));
    },
  },
  watch: {
    headers: {
      handler: function (newVal) {},
      deep: true,
    },
    rows: {
      handler: function (newVal) {
        this.inicialize();
      },
      deep: true,
    },
    pagination: {
      handler: function (newVal) {},
      deep: true,
    },
    selected() {
      this.drawer = this.selected.length > 0;
    },
    options() {},
    loading() {},
    config(){},
    disabledRegisterRows() {},
  },
};
</script>

<style>
.ed-table tr th {
  font-size: 13px !important;
  text-transform: uppercase;
  font-weight: bold;
}

.ed-table tr td {
  font-size: 13px !important;
}

.ed-table-acoes {
  text-align: center;
  width: 180px;
}
@media only screen and (max-width: 800px) {
  .ed-table-acoes {
    text-align: center;
    width: 100% !important;
  }
}
</style>
