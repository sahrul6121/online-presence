<template>
  <div>
    <!-- setting Time in -->
    <setting-time-in/>

    <!-- Setting over time -->
    <setting-over-time/>
  </div>

</template>

<script>
import store from '@/store'
import {
  ref, onUnmounted, computed, watch,
  // ref, watch, computed, onUnmounted,
} from '@vue/composition-api'
import {
  BCard, BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

import SettingTimeIn from './SettingTimeIn.vue'
import SettingOverTime from './SettingOverTime.vue'

export default {
  components: {
    BCard, 
    BRow, 
    BCol, 
    BFormGroup, 
    BFormInput, 
    BFormCheckbox, 
    BForm, 
    BButton,

    // App SFC
    SettingTimeIn,
    SettingOverTime,
  },
  directives: {
    Ripple,
  },
}
</script>
