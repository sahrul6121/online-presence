import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchInvoices(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/payroll', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchInvoice(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/payroll/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateInvoice(ctx, data) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/payroll/${data.id}`, {
            ...data,
            user_id: data.user.id,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    generateInvoice() {
      return new Promise((resolve, reject) => {
        axios
          .post('/payroll')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchClients() {
      return new Promise((resolve, reject) => {
        axios
          .get('/apps/invoice/clients')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    // addUser(ctx, userData) {
    //   return new Promise((resolve, reject) => {
    //     axios
    //       .post('/apps/user/users', { user: userData })
    //       .then(response => resolve(response))
    //       .catch(error => reject(error))
    //   })
    // },
  },
}
