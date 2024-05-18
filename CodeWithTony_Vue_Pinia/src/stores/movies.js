import { defineStore } from 'pinia'

export const useMoviesStore = defineStore('movies', {
  state: () => ({
    movies: [],
    isLoading: false,
  }),
  getters: {},
  actions: {
    async getMovies() {
      this.isLoading = true

      this.movies = await (await fetch('http://localhost:8000/movies')).json()

      this.isLoading = false
    },
  },
})
