<template>
  <b-sidebar
    id="add-new-employee-sidebar"
    :visible="isAddNewEmployeeSidebarActive"
    bg-variant="white"
    sidebar-class="sidebar-lg"
    shadow
    backdrop
    no-header
    right
    @hidden="resetForm"
    @change="(val) => $emit('update:is-add-new-employee-sidebar-active', val)"
  >
    <template #default="{ hide }">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
        <h5 class="mb-0">
          Add New Employee
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
          <!-- Join Date -->
          <validation-provider
            #default="validationContext"
            name="Join Date"
            rules="required"
          >
            <b-form-group
              label="Join Date"
              label-for="join_date"
            >
              <b-form-datepicker
                id="join_date"
                v-model="employeeData.join_date"
                class="mb-1"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

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
                v-model="employeeData.name"
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
            rules="required"
          >
            <b-form-group
              label="Code"
              label-for="code"
            >
              <b-form-input
                id="code"
                v-model="employeeData.code"
                :state="getValidationState(validationContext)"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Gender -->
          <validation-provider
            #default="validationContext"
            name="gender"
            rules="required"
          >
            <b-form-group
              label="Gender"
              label-for="gender"
            >
              <b-form-select
                v-model="employeeData.gender"
                :options="[
                  { text: 'Male', value: 'MALE' },
                  { text: 'Female', value: 'FEMALE' },
                ]"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Role -->
          <validation-provider
            #default="validationContext"
            name="Role"
            rules="required"
          >
            <b-form-group
              label="Role"
              label-for="role"
            >
              <b-form-select
                v-model="employeeData.role_id"
                :options="roleOptions"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Email -->
          <validation-provider
            #default="validationContext"
            name="Email"
            rules="required"
          >
            <b-form-group
              label="Email"
              label-for="email"
            >
              <b-form-input
                id="email"
                v-model="employeeData.email"
                type="email"
                autofocus
                :state="getValidationState(validationContext)"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Address -->
          <validation-provider
            #default="validationContext"
            name="Address"
            rules="required"
          >
            <b-form-group
              label="Address"
              label-for="address"
            >
              <b-form-textarea
                id="address"
                v-model="employeeData.address"
                autofocus
                :state="getValidationState(validationContext)"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Salary -->
          <validation-provider
            #default="validationContext"
            name="Salary"
            rules="required"
          >
            <b-form-group
              label="Salary"
              label-for="salary"
            >
              <b-form-input
                id="salary"
                v-model="employeeData.base_salary"
                type="number"
                autofocus
                :state="getValidationState(validationContext)"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Password -->
          <validation-provider
            #default="validationContext"
            name="Password"
            rules="required"
          >
            <b-form-group
              label="Password"
              label-for="password"
            >
              <b-form-input
                id="password"
                v-model="employeeData.password"
                type="password"
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
              variant="primary"
              class="mr-2"
              type="submit"
            >
              Add
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
  BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BFormTextarea, BFormSelect, BFormDatepicker,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref } from '@vue/composition-api'
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
    BFormTextarea,
    BFormSelect,
    BFormDatepicker,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  model: {
    prop: 'isAddNewEmployeeSidebarActive',
    event: 'update:is-add-new-employee-sidebar-active',
  },
  props: {
    isAddNewEmployeeSidebarActive: {
      type: Boolean,
      required: true,
    },
    employeeOptions: {
      type: Array,
      required: true,
    },
    roleOptions: {
      type: Array,
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
    const blankEmployeeData = {
      name: '',
      code: '',
      email: '',
      role_id: '',
      address: '',
      join_date: '',
      base_salary: '',
      gender: '',
      password: '',
    }

    const employeeData = ref(JSON.parse(JSON.stringify(blankEmployeeData)))
    const resetEmployeeData = () => {
      employeeData.value = JSON.parse(JSON.stringify(blankEmployeeData))
    }

    const onSubmit = () => {
      store.dispatch('app-employee/addEmployee', employeeData.value)
        .then(() => {
          emit('refetch-data')
          emit('update:is-add-new-employee-sidebar-active', false)
        })
    }

    const {
      refFormObserver,
      getValidationState,
      resetForm,
    } = formValidation(resetEmployeeData)

    return {
      employeeData,
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

#add-new-employee-sidebar {
  .vs__dropdown-menu {
    max-height: 200px !important;
  }
}
</style>
