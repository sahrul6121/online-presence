import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import log from 'echarts/src/scale/Log'

export default function useEmployeesList() {
  // Use toast
  const toast = useToast()

  const refEmployeeListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', sortable: true },
    { key: 'name', sortable: true },
    { key: 'code', sortable: true },
    { key: 'role', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalEmployees = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const EmployeeFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refEmployeeListTable.value ? refEmployeeListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalEmployees.value,
    }
  })

  const refetchData = () => {
    refEmployeeListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, EmployeeFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchEmployees = (ctx, callback) => {
    store
      .dispatch('app-employee/fetchEmployees', {
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
      })
      .then(response => {
        const responseData = response.data

        callback(responseData.data)

        totalEmployees.value = responseData.meta.total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching users list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  const roleOptions = []

  const fetchRoleList = () => {
    return new Promise(resolve => {
      store
        .dispatch('app-employee/fetchRoleList')
        .then(response => resolve(response))
    })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveEmployeeEmployeeVariant = Employee => {
    if (Employee === 'subscriber') return 'primary'
    if (Employee === 'author') return 'warning'
    if (Employee === 'maintainer') return 'success'
    if (Employee === 'editor') return 'info'
    if (Employee === 'admin') return 'danger'
    return 'primary'
  }

  const resolveEmployeeEmployeeIcon = Employee => {
    if (Employee === 'subscriber') return 'UserIcon'
    if (Employee === 'author') return 'SettingsIcon'
    if (Employee === 'maintainer') return 'DatabaseIcon'
    if (Employee === 'editor') return 'Edit2Icon'
    if (Employee === 'admin') return 'ServerIcon'
    return 'UserIcon'
  }

  const resolveEmployeeStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }

  return {
    fetchEmployees,
    fetchRoleList,
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

    resolveEmployeeEmployeeVariant,
    resolveEmployeeEmployeeIcon,
    resolveEmployeeStatusVariant,
    refetchData,

    // Extra Filters
    EmployeeFilter,
    planFilter,
    statusFilter,
  }
}
