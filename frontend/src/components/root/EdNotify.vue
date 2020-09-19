<template>
  <div>
    <v-snackbar
      v-model="visible"
      :color="snackbar.color"
      dark
    >
      <v-icon v-if="snackbar.color == 'error'">fa fa-exclamation-triangle</v-icon>
      <v-icon v-else-if="snackbar.color == 'success'">fa fa-check</v-icon>
      <v-icon v-else>fa fa-info-circle</v-icon>

      {{ snackbar.message }}

      <template v-slot:action="{ attrs }">
        <v-icon @click="hide" color="#ffffff">fa fa-times</v-icon>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    name: 'EdNotify',
    components:{},
    data: () => ({
      visible: false,
      snackbar: {
        enabled: false,
        color: 'success',
        mode: 'multi-line',
        timeout: 4000,
        message: 'Success!',
        callback: null,
        location: 'bottom',
        close: {
          text: 'Close',
          color: ''
        }
      }
    }),
    mounted() {
    },
    methods: {

      error(message, options = {}) {
        this.snackbar.message = message
        this.snackbar.color = 'error'
        this.setOptions(options)
      },

      success(message, options = {}) {
        this.snackbar.message = message
        this.snackbar.color = 'success'
        this.setOptions(options)
      },

      warning(message, options = {}) {
        this.snackbar.message = message
        this.snackbar.color = 'orange'
        this.setOptions(options)
      },

      info(message, options = {}) {
        this.snackbar.message = message
        this.snackbar.color = 'primary'
        this.setOptions(options)
      },

      hide(){
        this.visible = false
        if( this.snackbar.callback ){
          this.snackbar.callback()
        }
      },

      setOptions(options = {}){
        if(options.callback){
          this.snackbar.callback = options.callback
        }

        if(options.location){
          this.snackbar.location = options.location
        }
        this.visible = true

        let self = this
        setTimeout(function(){ 
          self.reset
        }, this.timeout);
      },

      reset() {
        this.$destroy();
      },
    }
  }
</script>
