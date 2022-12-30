import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchEmployees(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/employee', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateEmployee(ctx, employee) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/employee/${employee.id}`, { ...employee })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addEmployee(ctx, employeeData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/employee', { ...employeeData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    deleteEmployee(ctx, id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/employee/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchRoleList() {
      return new Promise((resolve, reject) => {
        axios
          .get('/role/list')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
