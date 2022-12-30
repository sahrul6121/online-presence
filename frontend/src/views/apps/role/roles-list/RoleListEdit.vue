<template>
  <b-sidebar
    id="edit-role-sidebar"
    :visible="isEditRoleSidebarActive"
    bg-variant="white"
    sidebar-class="sidebar-lg"
    shadow
    backdrop
    no-header
    right
    @hidden="resetForm; roleData = null"
    @change="(val) => $emit('update:is-edit-role-sidebar-active', val)"
  >
    <template #default="{ hide }">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
        <h5 class="mb-0">
          Edit Role
        </h5>

        <feather-icon
          class="ml-1 cursor-pointer"
          icon="XIcon"
          size="16"
          @click="hide"
        />

      </div>

      <!-- BODY -->
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

          <!-- Name -->
          <validation-provider
            #default="validationContext"
            name="Name"
            rules="required"
          >
            <b-form-group
              label="Name"
              label-for="name"
            >
              <b-form-input
                id="full-name"
                v-model="roleData.name"
                autofocus
                :state="getValidationState(validationContext)"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Code -->
          <validation-provider
            #default="validationContext"
            name="Code"
            rules="required|alpha-num"
          >
            <b-form-group
              label="Code"
              label-for="code"
            >
              <b-form-input
                id="code"
                v-model="roleData.code"
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
              variant="primary"
              class="mr-2"
              type="submit"
            >
              Update
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              type="button"
              variant="outline-secondary"
              @click="hide"
            >
              Cancel
            </b-button>
          </div>

        </b-form>
      </validation-observer>
    </template>
  </b-sidebar>
</template>

<script>
import {
  BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref, watch } from '@vue/composition-api'
import { required, alphaNum, email } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'

export default {
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  model: {
    prop: 'isEditRoleSidebarActive',
    event: 'update:is-edit-role-sidebar-active',
  },
  props: {
    isEditRoleSidebarActive: {
      type: Boolean,
      required: true,
    },
    role: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      required,
      alphaNum,
      email,
      countries,
    }
  },
  setup(props, { emit }) {
    const blankRoleData = {
      name: props.role.name ?? '',
      code: props.role.code ?? '',
    }

    const roleData = ref(JSON.parse(JSON.stringify(blankRoleData)))

    watch(() => props.role, selection => {
      roleData.value = {
        id: selection.id ?? '',
        name: selection.name ?? '',
        code: selection.code ?? '',
      }
    }, { deep: true })

    const resetRoleData = () => {
      roleData.value = JSON.parse(JSON.stringify(blankRoleData))
    }

    const onSubmit = () => {
      store.dispatch('app-role/updateRole', roleData.value)
        .then(() => {
          emit('refetch-data')
          emit('update:is-edit-role-sidebar-active', false)
        })
    }

    const {
      refFormObserver,
      getValidationState,
      resetForm,
    } = formValidation(resetRoleData)

    return {
      roleData,
      onSubmit,

      refFormObserver,
      getValidationState,
      resetForm,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';

#edit-role-sidebar {
  .vs__dropdown-menu {
    max-height: 200px !important;
  }
}
</style>
