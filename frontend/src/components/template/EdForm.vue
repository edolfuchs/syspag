<template>
  <v-form :ref="ref" :disabled="block" autocomplete="off" lazy-validation class="ed-form">
    <div class="col-md-12 pa-2 justify-center text-center">
      <div class="row">
        <slot />
      </div>
    </div>

    <ed-alert type="warning" :message="blockMessage" v-if="block && blockMessage" />

    <div :class="'col-md-12 pa-0 justify-center '+classFooter">
      <ed-button
        v-if="handlerSave"
        :color="colorButton"
        :label="labelButton"
        :disabled="block || !isValidRecaptcha"
        @click="validar"
        :iconLeft="iconButton"
        size="100%"
      />
      <slot name="form-footer" />
    </div>
  </v-form>
</template>

<script>
import EdButton from "./EdButton";
import EdAlert from "./EdAlert";

export default {
  name: "EdForm",
  mixins: [],
  components: { EdButton, EdAlert },
  props: {
    block: {
      type: Boolean,
      required: false,
      default: false,
    },
    blockMessage: {
      type: String,
      required: false,
      default: null,
    },
    handlerSave: {
      type: Function,
      required: false,
      default: null,
    },
    labelButton: {
      type: String,
      required: false,
      default: "Salvar",
    },
    colorButton: {
      type: String,
      required: false,
      default: "primary",
    },
    iconButton: {
      type: String,
      required: false,
      default: "fa fa-floppy-o",
    },
    classFooter: {
      type: String,
      default: "text-right",
    },
    recaptcha: {
      type: Boolean,
      default: false,
    },
    formData: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      ref: "form-" + this.$utilidade.randomString(),
      recaptchaKey: process.env.GOOGLE_RECAPTCHA,
    };
  },
  beforeDestroy() {},
  created() {},
  mounted() {},
  computed: {
    isValidRecaptcha(){

      if(!this.recaptcha)return true;

      return (this.formData && this.formData.recaptcha);
    }
  },
  methods: {
    validar() {

      if(!this.isValidRecaptcha){
        this.$root.$dialog.alert("Por favor informe se você não é robô");
        return;
      }

      if (!this.$refs[this.ref].validate()) {
        this.$root.$dialog.alert("Por favor preencher todos os campos");
        return;
      }

      if (this.handlerSave) {
        this.handlerSave();
      }
    },

    onRecaptchaVerify(ev){
      this.$emit('recaptcha',ev);
    }, 

    onRecaptchaError(ev){
      this.$emit('recaptcha',null);
    } 
  },
  watch: {
    block() {},
    blockMessage() {},
    recaptchaResponse(){
    },
    'formData.recaptcha'(){}
    
  },
};
</script>