<template>
  <b-card>
    <b-alert
      v-if="presenceData.status"
      :variant="presenceData.status === 'ON_TIME' ? 'success' : 'danger'"
      show
    >
      <h4 class="alert-heading">
        {{ presenceData.date_out ? 'Already Tap Out' : 'Already Tap In' }}
      </h4>

      <div class="alert-body">
        {{ presenceData.date_out ? `You already tap out with status ${presenceData.status}` : `You already tap in with status ${presenceData.status}` }}
      </div>
    </b-alert>

    <!-- form -->
    <validation-observer
      #default="{ handleSubmit }"
      ref="refFormObserver"
    >
      <!-- Form -->
      <b-form
        class="p-2"
        @submit.prevent="handleSubmit(onSubmit)"
        @reset.prevent="resetForm"
      >
        <!-- Gender -->
        <validation-provider
          #default="validationContext"
          name="Type"
          rules="required"
        >
          <b-form-group
            label="Type"
            label-for="type"
          >
            <b-form-select
              v-model="presenceData.type"
              :disabled="!!presenceData.id"
              :options="[
                { text: 'Normal', value: 'NORMAL' },
                { text: 'Over Time', value: 'OVER_TIME' },
              ]"
            />

            <b-form-invalid-feedback>
              {{ validationContext.errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </validation-provider>

        <!-- Address -->
        <validation-provider
          #default="validationContext"
          name="Note"
        >
          <b-form-group
            label="Note"
            label-for="note"
          >
            <b-form-textarea
              id="note"
              v-model="presenceData.note"
              :disabled="!!presenceData.id"
              autofocus
              :state="getValidationState(validationContext)"
              trim
            />

            <b-form-invalid-feedback>
              {{ validationContext.errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </validation-provider>

        <!-- Form Actions -->
        <div class="d-flex mt-2">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            :disabled="!!presenceData.date_in"
            variant="success"
            class="mr-2"
            type="submit"
          >
            <feather-icon
              icon="LogInIcon"
              class="mr-25"
            />

            Tap In
          </b-button>

          <b-button
            v-if="presenceData.id"
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="secondary"
            class="mr-2"
            :disabled="!!presenceData.date_out"
            @click="onSubmitOut"
          >
            <feather-icon
              icon="LogOutIcon"
              class="mr-25"
            />

            Tap Out
          </b-button>

          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            :disabled="presenceData.type === 'OVER_TIME'"
            variant="primary"
            class="mr-2"
            @click="onSubmitOverTime"
          >
            <feather-icon
              icon="LogInIcon"
              class="mr-25"
            />

            Overtime Tap In
          </b-button>
        </div>

      </b-form>
    </validation-observer>
  </b-card>
</template>

<script>
import {
  BButton, BForm, BFormGroup, BCard, BFormTextarea, BFormSelect, BAlert, BFormInvalidFeedback,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import formValidation from '@core/comp-functions/forms/form-validation'
import { ref, watch } from '@vue/composition-api'
import store from '@/store'

export default {
  components: {
    BAlert,
    BButton,
    BForm,
    BFormGroup,
    BCard,
    BFormTextarea,
    BFormSelect,
    BFormInvalidFeedback,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  props: {
    currentPresenceData: {
      required: true,
      type: Object,
    },
  },
  setup(props, { emit }) {
    const blankPresenceData = {
      note: '',
      type: '',
      status: '',
    }

    const presenceData = ref(JSON.parse(JSON.stringify(blankPresenceData)))

    watch(() => props.currentPresenceData, selection => {
      presenceData.value = {
        id: selection.id ?? null,
        note: selection.note ?? null,
        type: selection.type ?? null,
        status: selection.status ?? null,
        date_in: selection.date_in ?? null,
        date_out: selection.date_out ?? null,
      }
    }, { deep: true })

    const resetPresenceData = () => {
      presenceData.value = JSON.parse(JSON.stringify(blankPresenceData))
    }

    const {
      refFormObserver,
      getValidationState,
      resetForm,
    } = formValidation(resetPresenceData)

    const onSubmit = () => {
      store.dispatch('app-presence/tapIn', presenceData.value)
        .then(() => {
          emit('refetch-presence')
        })
    }

    const onSubmitOut = () => {
      store.dispatch('app-presence/tapOut', presenceData.value)
        .then(() => {
          emit('refetch-presence')
        })
    }

    const onSubmitOverTime = () => {
      store.dispatch('app-presence/tapIn', {
        note: 'overtime',
        type: 'OVER_TIME',
      })
        .then(() => {
          emit('refetch-presence')
        })
    }

    return {
      presenceData,
      onSubmit,
      onSubmitOverTime,
      onSubmitOut,

      refFormObserver,
      getValidationState,
      resetForm,
    }
  },
}
</script>
