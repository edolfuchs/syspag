<template>
  <div>
    <v-dialog v-model="dialog" persistent scrollable :max-width="(this.$vuetify.breakpoint.lgAndDown ? '100%' : '50%')">
      <v-card>
        <v-card-title class="headline">
          <v-icon left color="default" v-if="false">fa fa-question-circle</v-icon>
          {{title}}
        </v-card-title>

        <v-card-text style="max-height: 300px;" v-html="message" ></v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          
          <ed-button color="primary darken-1" tile outlined  @click="resolve" label="Fechar" v-if="isAlert"/>
          <ed-button color="green darken-1" tile outlined  @click="resolve" label="Sim" v-if="!isAlert"/>
          <ed-button color="error darken-1" tile outlined  @click="reject" label="Não" v-if="!isAlert"/>

        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>

import {EdButton} from 'template'

export default {
  name: "EdDialog",
  components:{EdButton},
  data: () => ({
    dialog: false,
    message: null,
    title: null,
    promise: null,
    isAlert:false,
    promiseResolve: () => {},
    promiseReject: () => {},
  }),
  created() {
  },
  mounted() {
  },
  methods: {
    confirm(message = "", title = "Atenção") {
      this.message = message;
      this.title = title;
      this.isAlert = false;
      this.dialog = true;
      this.promise = new Promise((resolve, reject) => {
        this.promiseResolve = resolve;
        this.promiseReject = reject;
      });
      return this.promise;
    },

    alert(message = "", title = "Atenção") {
      this.message = message;
      this.title = title;
      this.isAlert = true;
      this.dialog = true;
      this.promise = new Promise((resolve, reject) => {
        this.promiseResolve = resolve;
        this.promiseReject = reject;
      });
      return this.promise;
    },

    resolve() {
      if (this.promiseResolve) this.promiseResolve();
      this.reset();
    },

    reject() {
      if (this.promiseReject) this.promiseReject();
      this.reset();
    },

    reset() {
      this.promise = null;
      this.promiseResolve = null;
      this.promiseReject = null;
      this.message = null;
      this.title = null;
      this.dialog = false;
      //this.$destroy();
    },
  },
};
</script>
