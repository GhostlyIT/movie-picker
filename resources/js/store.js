import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        pickedMovies: window.localStorage.getItem('movies') ? window.localStorage.getItem('movies').split(',').map(el => +el) : [],
    },
    mutations: {
        addMovieToList(state, id) {
            state.pickedMovies.push(id)
        },

        removeMovieFromList(state, id) {
            state.pickedMovies.splice(state.pickedMovies.indexOf(id), 1)
        }
    },
    actions: {
        savePickedMovies() {
            window.localStorage.setItem('movies', this.state.pickedMovies)
            console.log('Work')
        },

        resetPickedMovies() {
            window.localStorage.removeItem('movies')
            this.state.pickedMovies = []
        }
    }
})
