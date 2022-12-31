<template>
   <b-card
      title="Overtime Setting"
      class="mb-0"
   >
      <div class="m-2">
         <b-row>
            <!-- first name -->
            <b-col cols="4">
               <b-form-group
                  label="Fee / Hour"
                  label-for="v-fee-hour"
               >
                  <b-form-input
                     id="v-fee-hour"
                     type="number"
                     placeholder="Fee / Hour"
                  />
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
  },
  directives: {
    Ripple,
  },
}
</script>
