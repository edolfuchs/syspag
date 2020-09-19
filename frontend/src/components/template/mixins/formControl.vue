<template>
  <div></div>
</template>

<script>
export default {
  name: 'ed-form-mixin',
  components:{},
  props: {
    required: {
      type: Boolean,
      required: false,
      default: false
    },
    loading: {
      type: Boolean,
      required: false,
      default: false
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    },
    readonly: {
      type: Boolean,
      required: false,
      default: false
    },
    clearable:{
      type: Boolean,
      required: false,
      default: false 
    },
    name: {
      type: [String],
      required: false,
      default:null
    },
    width: {
      type: [Number, String],
      required: false,
      default:'auto'
    },
    maxWidth:{
      type: [Number, String],
      required: false,
      default:null
    },
    label: {
      type: [Number, String, Boolean],
      required: false,
      default: false
    },
    title: {
      type: [Number, String],
      required: false,
      default: null
    },
    value: {
      type: [Number, String, Boolean, Array, Object],
      required: false,
      default: null
    },
    color: {
      type: [String],
      required: false,
      default: 'primary'
    },
    iconRight:{
      type: String,
      required: false,
      default: null
    },
    iconLeft:{
      type: String,
      required: false,
      default: null
    },
    classe: {
      type: [String],
      required: false,
      default: null
    },
    rules:{
      type: [String],
      required: false,
      default: function(){return null}
    },
    outlined: {
      type: Boolean,
      required: false,
      default: false,
    },
    multiple: {
      type: Boolean,
      required: false,
      default: false,
    },
    placeholder:{
      type:String,
      default:null
    }
  },
  data() {
    return {
      intUniqId: Date.now(),
      validateClass: '',
      labelHtml: ''
    }
  },
  methods: {
    updateValue($event) {
      let type = typeof this.value

      switch (type) {
        case 'boolean':
          this.$emit('input', !this.value);
          this.$emit('click',!this.value);
          break;

      
        default:
          if($event.target.value === undefined){
            this.$emit('click',false);
          }
          else{
            this.$emit('input', $event.target.value);
            this.$emit('change', $event.target.value);
          }
          break;
      }
    },

    focus() {
      if (this.$refs.field) {
        this.$refs.field.focus()
      }
    },

    // disable(boolValue) {
    //   if (this.$refs.field) {
    //     this.$refs.field.disabled = boolValue || boolValue === undefined
    //   }
    // },

    // readonly(boolValue) {
    //   if (this.$refs.field) {
    //     this.$refs.field.readOnly = boolValue || boolValue === undefined
    //   }
    // },

    validate() {
    },
  },
  mounted() {
  },
  watch: {
    name(){
    },
    label() {
    },
    value(){
    },
    rules(){
    },
    multiple(){
    },
    clearable(){
    },
    required() {
    },
    loading(){
    },
    disabled(){
    },
    readonly(){
    }
  },
  computed:{
    getError(){
      let response = this.$root.$request.getResponse;

      if(response && response.status == 400){
        for(var field in response.data.error.options){
          if(field == this.name){
            return true;
          }
        }
      } 

      return false;
    },

    getErrorContents(){

      let response = this.$root.$request.getResponse;

      if(response && response.status == 400){
        for(var field in response.data.error.options){
          if(field == this.name){
            return response.data.error.options[field];
          }
        }
      } 

      return [];
    },

    getRules(){

      let rules = [], arrayAux = []
      
      if(this.rules){
        arrayAux = this.rules.split('|').concat(arrayAux)
        
        arrayAux.forEach(rule => {
          
          if(rule.indexOf('required') != -1){
            rules.push(
              v => !!v || 'Campo obrigatório'
            )
          }

          if(rule.indexOf('email') != -1){
            rules.push(
              v => (v && this.$utilidade.isEmail(v)) || 'Email inválido'
            )
          }

          if(rule.indexOf('numeric') != -1){
            rules.push(
              v => (v && this.$utilidade.isNumeric(v)) || 'Digite um número válido'
            )
          }

          if(rule.indexOf('cpf') != -1){
            rules.push(
              v => (v && this.$utilidade.isCpf(v)) || 'Digite um CPF válido'
            )
          }

          if(rule.indexOf('cnpj') != -1){
            rules.push(
              v => (v && this.$utilidade.isCnpj(v)) || 'Digite um CNPJ válido'
            )
          }

          if(rule.indexOf('min:') != -1){

            let min = parseInt(rule.split(':')[1])

            rules.push(
              v => (v && v.length >= min) || 'Campo deve conter ao menos '+min+' caracteres'
            )
          }

          if(rule.indexOf('max:') != -1){

            let max = parseInt(rule.split(':')[1])

            rules.push(
              v => (v && v.length <= max) || 'Campo deve conter até '+max+' caracteres'
            )
          }

        });
      }

      return rules

    }
  }
}
</script>