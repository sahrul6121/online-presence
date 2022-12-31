<template>
  <section class="invoice-add-wrapper">
    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="invoiceData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching invoice data
      </h4>
      <div class="alert-body">
        No invoice found with this invoice id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-invoice-list'}"
        >
          Invoice List
        </b-link>
        for other invoices.
      </div>
    </b-alert>

    <b-row
      v-if="invoiceData"
      class="invoice-add"
    >

      <!-- Col: Left (Invoice Container) -->
      <b-col
        cols="12"
        xl="9"
        md="8"
      >
        <b-form @submit.prevent>
          <b-card
            no-body
            class="invoice-preview-card"
          >
            <!-- Header -->
            <b-card-body class="invoice-padding pb-0">

              <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">

                <!-- Header: Left Content -->
                <div>
                  <div class="logo-wrapper">
                    <logo />
                    <h3 class="text-primary invoice-logo">
                      E-Presence
                    </h3>
                  </div>
                  <p class="card-text mb-25">
                    {{ invoiceData.company }}
                  </p>
                  <p class="card-text mb-25">
                    {{ invoiceData.company_address }}
                  </p>
                  <p class="card-text mb-0">
                    {{ invoiceData.company_phone }}
                  </p>
                </div>

                <!-- Header: Right Content -->
                <div class="invoice-number-date mt-md-0 mt-2">
                  <div class="d-flex align-items-center justify-content-md-end mb-1">
                    <h4 class="invoice-title">
                      Invoice
                    </h4>
                    <b-input-group class="input-group-merge invoice-edit-input-group disabled">
                      <b-input-group-prepend is-text>
                        <feather-icon icon="HashIcon" />
                      </b-input-group-prepend>
                      <b-form-input
                        id="invoice-data-id"
                        v-model="invoiceData.id"
                        disabled
                      />
                    </b-input-group>
                  </div>
                  <div class="d-flex align-items-center mb-1">
                    <span class="title">
                      Date:
                    </span>
                    <flat-pickr
                      v-model="invoiceData.date"
                      class="form-control invoice-edit-input"
                    />
                  </div>
                </div>
              </div>
            </b-card-body>

            <!-- Spacer -->
            <hr class="invoice-spacing">

            <!-- Invoice Client & Payment Details -->
            <b-card-body
              class="invoice-padding pt-0"
            >
              <b-row class="invoice-spacing">

                <!-- Col: Invoice To -->
                <b-col
                  cols="12"
                  xl="6"
                  class="mb-lg-1"
                >
                  <h6 class="mb-2">
                    Invoice To:
                  </h6>

                  <!-- Selected Client -->
                  <div
                    v-if="invoiceData.user"
                    class="mt-1"
                  >
                    <h6 class="mb-25">
                      {{ invoiceData.user.name }}
                    </h6>
                    <b-card-text class="mb-25">
                      {{ invoiceData.company }}
                    </b-card-text>
                    <b-card-text class="mb-25">
                      {{ invoiceData.user.address }}, {{ invoiceData.country }}
                    </b-card-text>
                    <b-card-text class="mb-25">
                      {{ invoiceData.user.email }}
                    </b-card-text>
                  </div>
                </b-col>

                <!-- Col: Payment Details -->
                <b-col
                  xl="6"
                  cols="12"
                  class="mt-xl-0 mt-2 justify-content-end d-xl-flex d-block"
                >
                  <div>
                    <h6 class="mb-2">
                      Payment Details:
                    </h6>
                    <table>
                      <tbody>
                        <tr>
                          <td class="pr-1">
                            Sub Total:
                          </td>
                          <td><span class="font-weight-bold">{{ invoiceData.sub_total }}</span></td>
                        </tr>
                        <tr>
                          <td class="pr-1">
                            Bank name:
                          </td>
                          <td>{{ invoiceData.bank }}</td>
                        </tr>
                        <tr>
                          <td class="pr-1">
                            Country:
                          </td>
                          <td>{{ invoiceData.country }}</td>
                        </tr>
                        <tr>
                          <td class="pr-1">
                            Account:
                          </td>
                          <td>{{ invoiceData.bank_account }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </b-col>
              </b-row>
            </b-card-body>

            <!-- Items Section -->
            <b-card-body class="invoice-padding form-item-section">
              <div
                ref="form"
                class="repeater-form"
                :style="{height: trHeight}"
              >
                <b-row
                  v-for="(item, index) in invoiceData.items"
                  :key="index"
                  ref="row"
                  class="pb-2"
                >

                  <!-- Item Form -->
                  <!-- ? This will be in loop => So consider below markup for single item -->
                  <b-col cols="12">

                    <!-- ? Flex to keep separate width for XIcon and SettingsIcon -->
                    <div class="d-none d-lg-flex">
                      <b-row class="flex-grow-1 px-1">
                        <!-- Single Item Form Headers -->
                        <b-col
                          cols="12"
                          lg="3"
                        >
                          Subject
                        </b-col>
                        <b-col
                          cols="12"
                          lg="3"
                        >
                          Rate
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          Day
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          Hour
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          Total
                        </b-col>
                      </b-row>
                      <div class="form-item-action-col" />
                    </div>

                    <!-- Form Input Fields OR content inside bordered area  -->
                    <!-- ? Flex to keep separate width for XIcon and SettingsIcon -->
                    <div class="d-flex border rounded">
                      <b-row class="flex-grow-1 p-2">
                        <!-- Single Item Form Headers -->
                        <b-col
                          cols="12"
                          lg="3"
                        >
                          <label class="d-inline d-lg-none">Subject</label>
                          <b-form-input
                            v-model="item.subject"
                            class="mb-2"
                          />
                        </b-col>
                        <b-col
                          cols="12"
                          lg="3"
                        >
                          <label class="d-inline d-lg-none">Rate</label>
                          <b-form-input
                            v-model="item.rate"
                            type="number"
                            class="mb-2"
                          />
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          <label class="d-inline d-lg-none">Day</label>
                          <b-form-input
                            v-model="item.day"
                            type="number"
                            class="mb-2"
                          />
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          <label class="d-inline d-lg-none">Hour</label>
                          <b-form-input
                            v-model="item.hour"
                            type="number"
                            class="mb-2"
                          />
                        </b-col>
                        <b-col
                          cols="12"
                          lg="2"
                        >
                          <label class="d-inline d-lg-none">Total</label>
                          <b-form-input
                            v-model="item.total"
                            type="number"
                            class="mb-2"
                          />
                        </b-col>
                        <b-col
                          cols="12"
                          lg="5"
                        >
                          <label class="d-inline d-lg-none">Description</label>
                          <b-form-textarea
                            v-model="item.description"
                            class="mb-2 mb-lg-0"
                          />
                        </b-col>
                      </b-row>
                      <div class="d-flex flex-column justify-content-between border-left py-50 px-25">
                        <feather-icon
                          size="16"
                          icon="XIcon"
                          class="cursor-pointer"
                          @click="removeItem(index)"
                        />
                      </div>
                    </div>
                  </b-col>
                </b-row>
              </div>
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                size="sm"
                variant="primary"
                @click="addNewItemInItemForm"
              >
                Add Item
              </b-button>
            </b-card-body>

            <!-- Spacer -->
            <hr class="invoice-spacing">

          </b-card>
        </b-form>
      </b-col>

      <!-- Right Col: Card -->
      <b-col
        cols="12"
        md="4"
        xl="3"
        class="invoice-actions"
      >

        <!-- Action Buttons -->
        <b-card>

          <!-- Button: Print -->
          <b-button
            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
            variant="outline-primary"
            block
            @click="save"
          >
            Save
          </b-button>

          <!-- Button: Print -->
          <b-button
            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
            variant="outline-danger"
            block
            @click="backToList"
          >
            Cancel
          </b-button>
        </b-card>
      </b-col>
    </b-row>

    <invoice-sidebar-send-invoice />
    <invoice-sidebar-add-payment />
  </section>
</template>

<script>
import Logo from '@core/layouts/components/Logo.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import { heightTransition } from '@core/mixins/ui/transition'
import Ripple from 'vue-ripple-directive'
import store from '@/store'
import router from '@/router'
import {
  BRow, BCol, BCard, BCardBody, BButton, BCardText, BForm, BFormInput, BInputGroup, BInputGroupPrepend, BFormTextarea, BAlert, BLink, VBToggle,
} from 'bootstrap-vue'
import flatPickr from 'vue-flatpickr-component'
import invoiceStoreModule from '../invoiceStoreModule'
import InvoiceSidebarSendInvoice from '../InvoiceSidebarSendInvoice.vue'
import InvoiceSidebarAddPayment from '../InvoiceSidebarAddPayment.vue'

export default {
  components: {
    BRow,
    BCol,
    BCard,
    BCardBody,
    BButton,
    BCardText,
    BForm,
    BFormInput,
    BInputGroup,
    BInputGroupPrepend,
    BFormTextarea,
    BAlert,
    BLink,
    flatPickr,
    Logo,
    InvoiceSidebarSendInvoice,
    InvoiceSidebarAddPayment,
  },
  directives: {
    Ripple,
    'b-toggle': VBToggle,
  },
  mixins: [heightTransition],

  // Reset Tr Height if data changes
  watch: {
    // eslint-disable-next-line func-names
    'invoiceData.items': function () {
      this.initTrHeight()
    },
  },
  mounted() {
    this.initTrHeight()
  },
  created() {
    window.addEventListener('resize', this.initTrHeight)
  },
  destroyed() {
    window.removeEventListener('resize', this.initTrHeight)
  },
  methods: {
    addNewItemInItemForm() {
      this.$refs.form.style.overflow = 'hidden'
      this.invoiceData.items.push(JSON.parse(JSON.stringify(this.itemFormBlankItem)))

      this.$nextTick(() => {
        this.trAddHeight(this.$refs.row[0].offsetHeight)
        setTimeout(() => {
          this.$refs.form.style.overflow = null
        }, 350)
      })
    },
    removeItem(index) {
      this.invoiceData.items.splice(index, 1)
      this.trTrimHeight(this.$refs.row[0].offsetHeight)
    },
    initTrHeight() {
      this.trSetHeight(null)
      this.$nextTick(() => {
        this.trSetHeight(this.$refs.form ? this.$refs.form.scrollHeight : 0)
      })
    },
    save() {
      console.log(this.invoiceData)
      store.dispatch('app-invoice/updateInvoice', this.invoiceData)
        .then(() => {
          this.$router.push({ name: 'apps-invoice-list' })
        })
    },
    backToList() {
      this.$router.push({ name: 'apps-invoice-list' })
    },
  },
  setup() {
    const INVOICE_APP_STORE_MODULE_NAME = 'app-invoice'

    // Register module
    if (!store.hasModule(INVOICE_APP_STORE_MODULE_NAME)) store.registerModule(INVOICE_APP_STORE_MODULE_NAME, invoiceStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(INVOICE_APP_STORE_MODULE_NAME)) store.unregisterModule(INVOICE_APP_STORE_MODULE_NAME)
    })

    const invoiceData = ref(null)
    const paymentDetails = ref({})

    store.dispatch('app-invoice/fetchInvoice', { id: router.currentRoute.params.id })
      .then(response => {
        invoiceData.value = response.data.data
        paymentDetails.value = null

        // ? We are adding some extra data in response for data purpose
        // * Your response will contain this extra data
        // ? [Purpose is to make it more API friendly and less static as possible]
        invoiceData.value.items = response.data.data.items
        invoiceData.value.note = 'It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!'
        invoiceData.value.paymentMethod = 'Bank Account'
      })
      .catch(error => {
        if (error.response.status === 404) {
          invoiceData.value = undefined
        }
      })

    const itemFormBlankItem = {
      item: null,
      cost: 0,
      qty: 0,
      description: '',
    }

    const itemsOptions = [
      {
        itemTitle: 'App Design',
        cost: 24,
        qty: 1,
        description: 'Designed UI kit & app pages.',
      },
      {
        itemTitle: 'App Customization',
        cost: 26,
        qty: 1,
        description: 'Customization & Bug Fixes.',
      },
      {
        itemTitle: 'ABC Template',
        cost: 28,
        qty: 1,
        description: 'Bootstrap 4 admin template.',
      },
      {
        itemTitle: 'App Development',
        cost: 32,
        qty: 1,
        description: 'Native App Development.',
      },
    ]

    const updateItemForm = (index, val) => {
      const { cost, qty, description } = val
      invoiceData.value.items[index].cost = cost
      invoiceData.value.items[index].qty = qty
      invoiceData.value.items[index].description = description
    }

    const paymentMethods = [
      'Bank Account',
      'PayPal',
      'UPI Transfer',
    ]

    return {
      invoiceData,
      itemsOptions,
      updateItemForm,
      itemFormBlankItem,
      paymentMethods,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>

<style lang="scss" scoped>
@import "~@core/scss/base/pages/app-invoice.scss";

.form-item-section {
background-color:$product-details-bg;
}

.form-item-action-col {
  width: 27px;
}

.repeater-form {
  // overflow: hidden;
  transition: .35s height;
}

.v-select {
  &.item-selector-title,
  &.payment-selector {
    background-color: #fff;

    .dark-layout & {
      background-color: unset;
    }
  }
}

.dark-layout {
  .form-item-section {
    background-color: $theme-dark-body-bg;

    .row .border {
      background-color: $theme-dark-card-bg;
    }

  }
}
</style>
