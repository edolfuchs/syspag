<template>
  <v-app id="app" >
    <ed-session ref="session" />
    <ed-request ref="request"/>
    <ed-notify ref="notify" />
    <ed-dialog ref="dialog" />
    <ed-loading ref="loading" />
    <router-view />
  </v-app>
</template>

<script>
import {
  EdSession,
  EdRequest,
  EdNotify,
  EdDialog,
  EdLoading,
} from "components/root";


export default {
  name: "App",
  components: {EdSession, EdRequest, EdNotify, EdDialog, EdLoading },

  data() {
    return {
    };
  },
  created() {
  },
  mounted() {
    this.$root.$session = this.$refs.session;
    this.$root.$request = this.$refs.request;
    this.$root.$notify = this.$refs.notify;
    this.$root.$dialog = this.$refs.dialog;
    this.$root.$loading = this.$refs.loading;
  },
  beforeDestroy() {
  },
  computed: {
  },
  watch:{
  },
  methods: {
  },
};
</script>
