<template>

  <div>

    <employee-list-add-new
      :is-add-new-employee-sidebar-active.sync="isAddNewEmployeeSidebarActive"
      :employee-options="employeeOptions"
      :role-options="roleOptions"
      @refetch-data="refetchData"
    />

    <employee-list-edit
      :is-edit-employee-sidebar-active.sync="isEditEmployeeSidebarActive"
      :employee="currentEmployee"
      :role-options="roleOptions"
      @refetch-data="refetchData"
    />

    <!-- Filters -->
    <!--    <employees-list-filters-->
    <!--      :employee-filter.sync="employeeFilter"-->
    <!--      :plan-filter.sync="planFilter"-->
    <!--      :status-filter.sync="statusFilter"-->
    <!--      :employee-options="employeeOptions"-->
    <!--      :plan-options="planOptions"-->
    <!--      :status-options="statusOptions"-->
    <!--    />-->

    <!-- Table Container Card -->
    <b-card
      no-body
      class="mb-0"
    >

      <div class="m-2">

        <!-- Table Top -->
        <b-row>

          <!-- Per Page -->
          <b-col
            cols="12"
            md="6"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>Show</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
            <label>entries</label>
          </b-col>

          <!-- Search -->
          <b-col
            cols="12"
            md="6"
          >
            <div class="d-flex align-items-center justify-content-end">
              <b-button
                variant="primary"
                @click="isAddNewEmployeeSidebarActive = true"
              >
                <span class="text-nowrap">Add Employee</span>
              </b-button>
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refEmployeeListTable"
        class="position-relative"
        :items="fetchEmployees"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >
        <template #cell(role)="data">
          {{ data.item.role? data.item.role.name : '' }}
        </template>

        <!-- Column: Actions -->
        <template #cell(actions)="data">
          <b-dropdown
            variant="link"
            no-caret
            :right="$store.state.appConfig.isRTL"
          >

            <template #button-content>
              <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
              />
            </template>

            <b-dropdown-item @click="onUpdate(data.item)">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item @click="onDelete(data.item.id)">
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">Delete</span>
            </b-dropdown-item>
          </b-dropdown>
        </template>

      </b-table>
      <div class="mx-2 mb-2">
        <b-row>

          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-start"
          >
            <span class="text-muted">Showing {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} entries</span>
          </b-col>
          <!-- Pagination -->
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-end"
          >

            <b-pagination
              v-model="currentPage"
              :total-rows="totalEmployees"
              :per-page="perPage"
              first-number
              last-number
              class="mb-0 mt-1 mt-sm-0"
              prev-class="prev-item"
              next-class="next-item"
            >
              <template #prev-text>
                <feather-icon
                  icon="ChevronLeftIcon"
                  size="18"
                />
              </template>
              <template #next-text>
                <feather-icon
                  icon="ChevronRightIcon"
                  size="18"
                />
              </template>
            </b-pagination>

          </b-col>

        </b-row>
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  BCard, BRow, BCol, BButton, BTable, BDropdown, BDropdownItem, BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { ref, onUnmounted } from '@vue/composition-api'
// eslint-disable-next-line import/no-cycle
import { avatarText } from '@core/utils/filter'
// import EmployeesListFilters from './EmployeesListFilters.vue'
// eslint-disable-next-line import/no-cycle
import useEmployeesList from './useEmployeesList'
import employeeStoreModule from '../employeeStoreModule'
import EmployeeListAddNew from './EmployeeListAddNew.vue'
import EmployeeListEdit from './EmployeeListEdit.vue'

export default {
  components: {
    // EmployeesListFilters,
    EmployeeListAddNew,
    EmployeeListEdit,

    BCard,
    BRow,
    BCol,
    // BFormInput,
    BButton,
    BTable,
    // BMedia,
    // BAvatar,
    // BLink,
    // BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,

    vSelect,
  },
  setup() {
    const USER_APP_STORE_MODULE_NAME = 'app-employee'

    const currentEmployee = {
      id: null,
      name: null,
      code: null,
    }

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, employeeStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const isAddNewEmployeeSidebarActive = ref(false)

    const isEditEmployeeSidebarActive = ref(false)

    const employeeOptions = [
      { label: 'Admin', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]

    const planOptions = [
      { label: 'Basic', value: 'basic' },
      { label: 'Company', value: 'company' },
      { label: 'Enterprise', value: 'enterprise' },
      { label: 'Team', value: 'team' },
    ]

    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]

    const {
      fetchEmployees,
      roleOptions,
      tableColumns,
      perPage,
      currentPage,
      totalEmployees,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refEmployeeListTable,
      refetchData,
      fetchRoleList,

      // UI
      resolveEmployeeEmployeeVariant,
      resolveEmployeeEmployeeIcon,
      resolveEmployeeStatusVariant,

      // Extra Filters
      employeeFilter,
      planFilter,
      statusFilter,
    } = useEmployeesList()

    const onDelete = id => {
      store.dispatch('app-employee/deleteEmployee', id)
        .then(() => {
          refetchData()
        })
    }

    return {

      // Sidebar
      isAddNewEmployeeSidebarActive,

      fetchEmployees,
      tableColumns,
      perPage,
      currentPage,
      totalEmployees,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refEmployeeListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveEmployeeEmployeeVariant,
      resolveEmployeeEmployeeIcon,
      resolveEmployeeStatusVariant,

      employeeOptions,
      planOptions,
      statusOptions,

      // Extra Filters
      employeeFilter,
      planFilter,
      statusFilter,
      onDelete,
      isEditEmployeeSidebarActive,
      currentEmployee,
      roleOptions,
      fetchRoleList,
    }
  },
  mounted() {
    this.fetchRoleList().then(response => {
      this.roleOptions = response.data.data?.map(role => ({
        text: role.name,
        value: role.id,
      }))
    })
  },
  methods: {
    onUpdate(employee) {
      this.currentEmployee = employee

      this.isEditEmployeeSidebarActive = true
    },
  },
}
</script>

<style lang="scss" scoped>
.per-page-selector {
  width: 90px;
}
</style>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
