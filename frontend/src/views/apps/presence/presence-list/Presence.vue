<template>
  <b-tabs
    vertical
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >

    <!-- general tab -->
    <b-tab
      active
      @click="refresh = 1"
    >

      <!-- title -->
      <template #title>
        <feather-icon
          icon="AlignJustifyIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Presence List</span>
      </template>

      <presence-list
        v-if="options.general"
        :general-data="options.general"
        :refresh="refresh"
      />
    </b-tab>
    <!--/ general tab -->

    <!-- change password tab -->
    <b-tab @click="refresh = 0">

      <!-- title -->
      <template #title>
        <feather-icon
          icon="CheckIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Tap In / Out</span>
      </template>

      <presence-tap
        :current-presence-data="currentPresenceData"
        @refetch-presence="fetchPresence"
      />
    </b-tab>
  </b-tabs>
</template>

<script>
import { BTabs, BTab } from 'bootstrap-vue'
import store from '@/store'
import { onUnmounted } from '@vue/composition-api'
import usePresencesList from '@/views/apps/presence/presence-list/usePresencesList'
import PresenceList from './PresenceList.vue'
import PresenceTap from './PresenceTap.vue'
import presenceStoreModule from '../presenceStoreModule'

export default {
  components: {
    BTabs,
    BTab,
    PresenceList,
    PresenceTap,
  },
  setup() {
    const USER_APP_STORE_MODULE_NAME = 'app-presence'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, presenceStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    const {
      fetchCurrentPresence,
      refetchData,
    } = usePresencesList()

    return {
      fetchCurrentPresence,
      refetchData,
    }
  },
  data() {
    return {
      options: {},
      currentPresenceData: {},
      refresh: 0,
    }
  },
  beforeCreate() {
    this.$http.get('/account-setting/data').then(res => { this.options = res.data })
  },
  mounted() {
    this.fetchPresence()
  },
  methods: {
    fetchPresence() {
      this.currentPresenceData = {}

      this.fetchCurrentPresence().then(response => {
        this.currentPresenceData = response.data.data ?? {}
      })
    },
  },
}
</script>
