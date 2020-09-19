<template> 
  <v-alert :type="type">
    <span v-if="message">{{message}}</span>
    <slot/>
  </v-alert>
</template>

<script>

export default {
  name: 'EdAlert',
  props: {
    type: {
      type: String,
      required: false,
      default: 'success'
    },
    message:{
      type: String,
      required: false,
      default: null
    }
  },
  data() {
    return {
    };
  },
  mounted(){
  },  
  methods: {
  },
  computed: {
  },
  watch: {

  },
}
</script>
