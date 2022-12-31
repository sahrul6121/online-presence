import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function usePresencesList() {
  // Use toast
  const toast = useToast()

  const refPresenceListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', sortable: true },
    { key: 'user', sortable: true },
    { key: 'date_in', sortable: true },
    { key: 'date_out', sortable: true },
    { key: 'status', sortable: true },
    { key: 'type', sortable: true },
  ]
  const perPage = ref(10)
  const totalPresences = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const PresenceFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refPresenceListTable.value ? refPresenceListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalPresences.value,
    }
  })

  const refetchData = () => {
    refPresenceListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, PresenceFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchPresences = (ctx, callback) => {
    store
      .dispatch('app-presence/fetchPresences', {
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
      })
      .then(response => {
        const responseData = response.data

        callback(responseData.data)

        totalPresences.value = responseData.meta.total
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

  const fetchCurrentPresence = () => new Promise(resolve => {
    store
      .dispatch('app-presence/getCurrentAttendance')
      .then(response => resolve(response))
  })

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  return {
    fetchPresences,
    fetchCurrentPresence,
    tableColumns,
    perPage,
    currentPage,
    totalPresences,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refPresenceListTable,

    refetchData,

    // Extra Filters
    PresenceFilter,
    planFilter,
    statusFilter,
  }
}
