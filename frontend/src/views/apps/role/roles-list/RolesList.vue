<template>

  <div>

    <role-list-add-new
      :is-add-new-role-sidebar-active.sync="isAddNewRoleSidebarActive"
      :role-options="roleOptions"
      :plan-options="planOptions"
      @refetch-data="refetchData"
    />

    <role-list-edit
      :is-edit-role-sidebar-active.sync="isEditRoleSidebarActive"
      :role="currentRole"
      @refetch-data="refetchData"
    />

    <!-- Filters -->
    <!--    <roles-list-filters-->
    <!--      :role-filter.sync="roleFilter"-->
    <!--      :plan-filter.sync="planFilter"-->
    <!--      :status-filter.sync="statusFilter"-->
    <!--      :role-options="roleOptions"-->
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
                @click="isAddNewRoleSidebarActive = true"
              >
                <span class="text-nowrap">Add Role</span>
              </b-button>
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refRoleListTable"
        class="position-relative"
        :items="fetchRoles"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >
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
              :total-rows="totalRoles"
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
// import RolesListFilters from './RolesListFilters.vue'
// eslint-disable-next-line import/no-cycle
import useRolesList from './useRolesList'
import roleStoreModule from '../roleStoreModule'
import RoleListAddNew from './RoleListAddNew.vue'
import RoleListEdit from './RoleListEdit.vue'

export default {
  components: {
    // RolesListFilters,
    RoleListAddNew,
    RoleListEdit,

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
    const USER_APP_STORE_MODULE_NAME = 'app-role'

    const currentRole = {
      id: null,
      name: null,
      code: null,
    }

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, roleStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const isAddNewRoleSidebarActive = ref(false)

    const isEditRoleSidebarActive = ref(false)

    const roleOptions = [
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
      fetchRoles,
      tableColumns,
      perPage,
      currentPage,
      totalRoles,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refRoleListTable,
      refetchData,

      // UI
      resolveRoleRoleVariant,
      resolveRoleRoleIcon,
      resolveRoleStatusVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    } = useRolesList()

    const onDelete = id => {
      store.dispatch('app-role/deleteRole', id)
        .then(() => {
          refetchData()
        })
    }

    return {

      // Sidebar
      isAddNewRoleSidebarActive,

      fetchRoles,
      tableColumns,
      perPage,
      currentPage,
      totalRoles,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refRoleListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveRoleRoleVariant,
      resolveRoleRoleIcon,
      resolveRoleStatusVariant,

      roleOptions,
      planOptions,
      statusOptions,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
      onDelete,
      isEditRoleSidebarActive,
      currentRole,
    }
  },
  methods: {
    onUpdate(role) {
      this.currentRole = role

      this.isEditRoleSidebarActive = true
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
