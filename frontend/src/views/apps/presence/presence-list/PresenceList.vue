<template>
  <b-card>
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
      </b-row>

    </div>

    <b-table
      ref="refPresenceListTable"
      class="position-relative"
      :items="fetchPresences"
      responsive
      :fields="tableColumns"
      primary-key="id"
      :sort-by.sync="sortBy"
      show-empty
      empty-text="No matching records found"
      :sort-desc.sync="isSortDirDesc"
    >
      <!-- Column: Actions -->
      <template #cell(user)="data">
        {{ data.item.user ? data.item.user.name : '' }}
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
            :total-rows="totalPresences"
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
</template>

<script>
import {
  BRow, BCol, BCard, BPagination, BTable,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref, watch } from '@vue/composition-api'
import vSelect from 'vue-select'
import usePresencesList from './usePresencesList'

export default {
  components: {
    BTable,
    BPagination,
    BRow,
    BCol,
    BCard,
    vSelect,
  },
  directives: {
    Ripple,
  },
  props: {
    generalData: {
      type: Object,
      default: () => {},
    },
    refresh: {
      type: Number,
      required: true,
    },
  },
  setup(props) {
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, previewEl)

    const {
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
    } = usePresencesList()

    watch(() => props.refresh, () => {
      if (props.refresh === 1) {
        refetchData()
      }
    })

    return {
      refInputEl,
      previewEl,
      inputImageRenderer,
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
  },
  data() {
    return {
      optionsLocal: JSON.parse(JSON.stringify(this.generalData)),
      profileFile: null,
    }
  },
  methods: {
    resetForm() {
      this.optionsLocal = JSON.parse(JSON.stringify(this.generalData))
    },
  },
}
</script>
