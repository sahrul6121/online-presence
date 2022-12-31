<template>
   <b-card
      title="Work Schedule Setting"
      class="mb-0 mb-2"
   >
      <div class="m-2">
         <b-row>
            <!-- Time In -->
            <b-col cols="4">
               <b-form-group
                  label="Time In"
                  label-for="v-time-in"
               >

                  <b-form-timepicker locale='en' />
               </b-form-group>
            </b-col>
         </b-row>

         <b-row class="justify-content-end text-right">
            <b-col cols="4">
               <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  type="submit"
                  variant="primary"
                  class="mr-1"
               >
                  Submit
               </b-button>
            </b-col>
         </b-row>
      </div>
   </b-card>
</template>

<script>
import {
  BCard, BRow, BCol, BFormGroup, BFormInput, BFormCheckbox, BForm, BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { BFormTimepicker } from 'bootstrap-vue'

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

    BFormTimepicker,
  },
  directives: {
    Ripple,
  },
}
</script>

<style>

</style>
