<template>
<div v-if="pagination && pagination.total>0">
  <div class="text-center ed-pagination-label">
    Página {{pagination.current_page}} de {{pagination.last_page}}
  </div>

  <div class="text-center">
    <v-pagination v-model="page" :length="pagination.last_page" circle @input="onPage($event)"></v-pagination>
  </div>

  <div class="text-center ed-pagination-label">
    <span v-if="pagination.total == 1">1 ocorrência</span>
    <span v-else-if="pagination.total > 1">{{pagination.total}} ocorrência</span>
  </div>
</div>
</template>

<script>
export default {
  name: "EdPagination",
  components: {},
  props: {
    pagination: {
      type: Object,
      required: false,
      default: function () {
        return null;
      },
    },
  },
  beforeDestroy() {},
  data() {
    return {
      page: 1,
    };
  },
  created() {},
  mounted() {
    this.inicialize();
  },
  computed: {},
  methods: {

    inicialize(){
      if(this.pagination){
        this.page = this.pagination.current_page;
      }
    },

    onPage(event) {
      this.$emit('page',{page:event})
    },
  },
  watch: {
    pagination() {
      this.inicialize();
    },
  },
};
</script>

<style>
.ed-pagination-label {
  font-size: 0.750em;
  color: #666;
}
</style>
