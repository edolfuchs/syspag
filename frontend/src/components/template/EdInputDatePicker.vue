<template>
  <v-dialog ref="dialog" v-model="modal" persistent  width="290px">
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        :value="value"
        :label="label"
        :disabled="disabled"
        readonly
        prepend-icon="fa fa-calendar"
        locale="pt"
        v-mask="'99/99/9999'"
        v-bind="attrs"
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker scrollable :value="value" @input="$emit('input',$event)" :min="min">
      <v-spacer></v-spacer>
      <div class="col-12 pa-0 ma-0 text-center">
        <ed-button color="error" @click="modal = false" onlyIcon iconLeft="fa fa-times-circle" small/>
        <ed-button color="success" @click="setDate(value)" onlyIcon iconLeft="fa fa-check-circle-o" small/>
      </div>
    </v-date-picker>
  </v-dialog>
</template>

<script>
import EdFormMixin from "./mixins/formControl";
import EdButton from './EdButton'

export default {
  name: "EdInputDatePicker",
  mixins: [EdFormMixin],
  components:{EdButton},
  props: {
    min: {
      type: String,
      required: false,
      default: null,
    },
  },
  data() {
    return {
      modal:false,
      data:null
    };
  },
  beforeDestroy() {},
  created() {
  },
  mounted() {},
  computed: {},
  methods: {
    setDate(ev){
      this.$emit('input', ev);
      this.modal = false;
    }
  },
};
</script>