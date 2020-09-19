<template>
  <div>
    <v-dialog
      :persistent="persistent"
      :fullscreen="fullscreen"
      :scrollable="scrollable"
      :value="value"
      :width="width"
      @input="updateValue"
      :max-width="maxWidth"
    >
      <v-card >
        <v-card-title dark color="primary" style="background:#3777a2;color:#ffffff;text-transform: uppercase !important" >
          <div class="col-11 pa-0 ma-0">
            <v-icon v-if="iconTitle" class="mr-1" color="white">{{iconTitle}}</v-icon>
            <slot name="title"/>
          </div>
          <div class="col-1 pa-0 ma-0">
            <ed-button  
              text
              onlyIcon
              color="white"
              @click="updateValue" 
              iconLeft="fa fa-times-circle-o"
            />
          </div>
        </v-card-title>
        <v-card-subtitle v-if="!!$slots.subtitle">
          <slot name="subtitle"/>
        </v-card-subtitle>

        <v-card-text :style="($vuetify.breakpoint.smAndDown ? 'height: '+(this.$vuetify.breakpoint.height*0.9)+'px;' : '')">
          <slot name="content"/>
        </v-card-text>
        
        <div v-if="!!$slots.footer">
          <v-divider></v-divider>
          <v-card-actions class="justify-center">
            <slot name="footer"/>
          </v-card-actions>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>

import {EdButton} from "template";
import EdFormMixin from './mixins/formControl'

export default {
  name: 'EdModal',
  mixins:[EdFormMixin],
  components:{EdButton},
  props: {
    persistent: {
      type: Boolean,
      required: false,
      default: true
    },
    fullscreen: {
      type: Boolean,
      required: false,
      default: function(){
        return this.$vuetify.breakpoint.mobile
      }
    },
    scrollable:{
      type: Boolean,
      required: false,
      default: true
    },
    iconTitle:{
      type: String,
      required: false,
      default: null
    }
  },
  data() {
    return {
    }
  },
  beforeDestroy(){
	},
  created(){
  },  
  mounted(){
  }, 
  computed:{
    
  },
  methods: {
  }
}
</script>