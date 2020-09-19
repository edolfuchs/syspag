<template>
  <v-btn
    @click="$emit('click', $event)"
    :text="text"
    :title="title"
    :color="color"
    :to="to"
    :outlined="outlined"
    :loading="loading"
    :bottom="bottom"
    :right="right"
    :left="left"
    :top="top"
    :dark="dark"
    :fab="fab"
    :fixed="fixed"
    :link="link"
    :small="small"
    :x-small="xSmall"
    :light="light"
    :large="large"
    :icon="icon"
    :disabled="disabled"
    exact
  >
    <v-icon :left="!onlyIcon" v-if="iconLeft">{{iconLeft}}</v-icon>
    {{(label ? label : null)}}
    <v-icon :right="!onlyIcon" v-if="iconRight">{{iconRight}}</v-icon>
  </v-btn>
</template>

<script>
import EdFormMixin from "./mixins/formControl";

export default {
  name: "EdButton",
  mixins: [EdFormMixin],
  props: {
    text: {
      type: Boolean,
      required: false,
      default: false,
    },
    icon: {
      type: Boolean,
      required: false,
      default: false,
    },
    to: {
      type: [String, Object],
      required: false,
      default: null,
    },
    outlined: {
      type: Boolean,
      required: false,
      default: false,
    },
    link: {
      type: Boolean,
      required: false,
      default: false,
    },
    bottom: {
      type: Boolean,
      required: false,
      default: false,
    },
    top: {
      type: Boolean,
      required: false,
      default: false,
    },
    right: {
      type: Boolean,
      required: false,
      default: false,
    },
    left: {
      type: Boolean,
      required: false,
      default: false,
    },
    dark: {
      type: Boolean,
      required: false,
      default: false,
    },
    onlyIcon: {
      type: Boolean,
      required: false,
      default: false,
    },
    fab: {
      type: Boolean,
      required: false,
      default: false,
    },
    fixed: {
      type: Boolean,
      required: false,
      default: false,
    },
    xSmall: {
      type: Boolean,
      required: false,
      default: false,
    },
    small: {
      type: Boolean,
      required: false,
      default: false,
    },
    large: {
      type: Boolean,
      required: false,
      default: false,
    },
    light: {
      type: Boolean,
      required: false,
      default: false,
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