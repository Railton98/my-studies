import { defineStore } from 'pinia'

export const useMoviesStore = defineStore('movies', {
  state: () => ({
    movies: [],
    isLoading: false,
    query: '',
  }),
  getters: {},
  actions: {
    async getMovies() {
      this.isLoading = true

      this.movies = await (
        await fetch(`http://localhost:8000/movies?q=${this.query}`)
      ).json()

      this.isLoading = false
    },
  },
})
