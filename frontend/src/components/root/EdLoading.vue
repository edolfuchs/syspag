<template> 
  <div class="text-center"> 
    <v-overlay :value="loading" :z-index="9999"> 
      <v-progress-circular indeterminate :size="64" :z-index="10000"/>
      <p v-if="text" style="color:#fff;font-weight:bold"><b>{{text}}</b></p>
    </v-overlay> 
  </div> 
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'EdLoading',
  data() {
    return {
      loading:false,
      text:null,
    };
  },
  mounted(){
  },  
  methods: {
    set(loading,text){
      this.loading = loading
      this.text = text
    },
  },
  computed: {
  },
  watch: {
    loading(){
    },
    text(){
    }
  },
}
</script>
