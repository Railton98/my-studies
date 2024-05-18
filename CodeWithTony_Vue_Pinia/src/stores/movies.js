import { defineStore } from 'pinia'

export const useMoviesStore = defineStore('movies', {
  state: () => ({
    movies: [],
    isLoading: false,
    query: '',
    singleMovie: {},
    year: 2000,
  }),
  getters: {
    totalMovies() {
      return this.filterMovies.length
    },
    filterMovies() {
      return this.movies.filter((movie) => movie.year >= this.year)
    },
  },
  actions: {
    async getMovies() {
      this.isLoading = true

      this.movies = await (
        await fetch(`http://localhost:8000/movies?q=${this.query}`)
      ).json()

      this.isLoading = false
    },

    async getSingleMovie(id) {
      this.isLoading = true

      const result = await fetch(`http://localhost:8000/movies/${parseInt(id)}`)
      if (result.status === 404) {
        this.router.push({ name: 'NotFound' })
      }

      this.singleMovie = await result.json()
      this.isLoading = false
    },
  },
})
