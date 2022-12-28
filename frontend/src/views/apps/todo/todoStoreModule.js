import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchTasks(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/time-sheet-activity', { params: payload })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addTask(ctx, taskData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/time-sheet-activity', { ...taskData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateTask(ctx, { task }) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/time-sheet-activity/${task.id}`, { ...task })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    removeTask(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/time-sheet-activity/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    approveTask(ctx, taskData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/time-sheet-activity/approve/${taskData.id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    rejectTask(ctx, taskData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/time-sheet-activity/reject/${taskData.id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
