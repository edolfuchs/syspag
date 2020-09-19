<template>
  <v-select
    :items="items"
    :label="label"
    :name="name"
    :required="required"
    :value="value"
    :error="getError"
    :error-messages="getErrorContents"
    :outlined="outlined"
    :loading="loading"
    :rules="getRules"
    :item-value="itemValue"
    :item-text="itemText"
    :item-disabled="checkDisable"
    :return-object="isObject"
    :disabled="disabled"
    :readonly="readonly"
    :prepend-inner-icon="iconLeft"
    :append-icon="iconRight"
    :multiple="multiple"
    :clearable="clearable"
    :chips="multiple || chips"
    :small-chips="(chips || multiple)"
    no-data-text="Nenhum item encontrado"
    @change="$emit('input', $event)"
  > 
    <!--
      <template v-slot:selection="{ item, index }">
        <span v-if="index === 0" class="pr-1">{{ item[itemText] }}</span>
        <span v-if="index === 1" class="grey--text caption">(+{{ value.length - 1 }} outros)</span>
      </template>
    -->
  </v-select>
</template>

<script>
import EdFormMixin from "./mixins/formControl";

export default {
  name: "EdInputSelect",
  mixins: [EdFormMixin],
  props: {
    items: {
      type: [Array],
      required: false,
      default: function () {
        return [];
      },
    },
    itemValue: {
      type: [String, Function],
      required: false,
      default: "intId",
    },
    itemText: {
      type: [String, Number, Function],
      required: false,
      default: "strNome",
    },
    itemDisabled:{
      type: [String, Array, Function],
      required: false,
      default: function(){return null},
    },
    isObject: {
      type: [Boolean],
      required: false,
      default: false,
    },
    chips:{
      type: [Boolean],
      required: false,
      default: false,
    }
  },
  data() {
    return {};
  },
  beforeDestroy() {},
  created() {},
  mounted() {
  },
  computed: {},
  methods: {

    checkDisable(val){

      if(val && (val.bloqueado || val.ativo == 0))return true;

      if(this.itemDisabled != null){
        return this.itemDisabled(val);
      }

      return false;
    }
  },
  watch: {
    items() {},
  },
};
</script>