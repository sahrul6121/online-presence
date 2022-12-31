import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchPresences(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/attendance', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    tapIn(ctx, attendanceData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/attendance/tap-in', { ...attendanceData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    tapOut() {
      return new Promise((resolve, reject) => {
        axios
          .post('/attendance/tap-out')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    getCurrentAttendance() {
      return new Promise((resolve, reject) => {
        axios
          .post('/attendance/current-attendance')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
