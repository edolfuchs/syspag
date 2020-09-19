<template>
  <v-text-field
    autocomplete="off"
    :label="label"
    :required="required"
    :name="name"
    :prepend-inner-icon="iconLeft"
    :append-icon="iconRight"
    :type="type"
    :outlined="outlined"
    :loading="loading"
    :rules="getRules"
    :error="getError"
    :error-messages="getErrorContents"
    :value="value"
    :disabled="disabled"
    :readonly="readonly"
    :placeholder="placeholder"
    validate-on-blur
    @input="$emit('input', $event)"
    @keydown="$emit('keydown', $event)"
    @blur="$emit('blur', $event)"
    @keyup.enter="$emit('keyup', $event)"
    @change="$emit('change', $event)"
  >
    <template v-slot:prepend v-if="!!$slots.prepend">
      <slot name="prepend"/>
    </template>

    <template v-slot:append v-if="!!$slots.append">
      <slot name="append"/>
    </template>

  </v-text-field>
</template>

<script>
import EdFormMixin from "./mixins/formControl";

export default {
  name: "EdInputText",
  mixins: [EdFormMixin],
  props: {
    type: {
      type: String,
      required: false,
      default: "text",
    },
  },
  data() {
    return {};
  },
  beforeDestroy() {},
  created() {},
  mounted() {},
  computed: {},
  methods: {},
};
</script>