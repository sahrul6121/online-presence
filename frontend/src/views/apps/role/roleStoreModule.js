import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchRoles(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/role', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateRole(ctx, role) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/role/${role.id}`, { ...role })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addRole(ctx, roleData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/role', { ...roleData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    deleteRole(ctx, id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/role/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
