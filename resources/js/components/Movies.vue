<template>
    <div id="movies" class="container component">
        <search :search="search"></search>
        <filter-buttons :changeFilter="changeFilter"></filter-buttons>
        <div class="row" v-if="this.movies !== false">
            <div class="movie d-flex flex-column align-items-center justify-content-between col-md-3 col-xs-12" v-for="movie in this.movies.results" :key="movie.id">
                <img v-if="movie.poster_path != null" class="movie__poster" :src="`https://image.tmdb.org/t/p/w200/${movie.poster_path}`">
                <h2 v-else class="text-center">No poster</h2>
                <div class="movie__title">
                    <h5>{{ movie.title }}</h5>
                    <p>({{ movie.release_date === '' ? 'No release date' : movie.release_date }})</p>
                </div>
                <button class="movie__add" v-on:click="pickMovie(movie.id)" v-if="!matched(movie.id)" type="button">+</button>
                <button class="movie__remove" v-on:click="removeMovie(movie.id)" v-else type="button">-</button>
            </div>
            <div v-if="this.movies.total_pages > 1" class="pagination d-flex w-100 justify-content-center">
                <span class="pagination__prev" v-if="currentPage != 1" v-on:click="changePage(-1)">Previous</span>
                <span class="pagination__page">{{ this.currentPage }}</span>
                <span class="pagination__next" v-if="this.currentPage < this.movies.total_pages" v-on:click="changePage(1)">Next</span>
            </div>
        </div>
        <div v-else class="spinner-border d-flex" role="status" style="margin: 0 auto">
            <span class="sr-only">Loading...</span>
        </div>
        <picked-list></picked-list>
    </div>
</template>

<script>
export default {
    props: ['link'],
    data: () => ({
        movies: false,
        currentPage: 1,
        filter: 'popular',
        searchQuery: ''
    }),
    mounted() {
        this.getMovies()

        if (this.link != '') {
            window.axios.get(`/api/link/get?link=${this.link}`)
            .then((response) => {
                const movies = response.data.movies
                movies.forEach(movie => {
                    this.pickMovie(movie.movie_id)
                })
            })
        }
    },
    methods: {
        getMovies() {
            window.axios.get(`/api/movies/get?filter=${this.filter}&page=${this.currentPage}`)
            .then((response) => {
                this.movies = this.filter === 'latest' ? {results: [response.data.movies]} : response.data.movies
            })
            .catch((error) => {
                console.log(error)
            })
        },

        matched(id) {
            return this.$store.state.pickedMovies.includes(id)
        },

        pickMovie(id) {
            this.$store.commit('addMovieToList', id)
        },

        removeMovie(id) {
            this.$store.commit('removeMovieFromList', id)
        },

        changePage(page) {
            this.currentPage += page
            if (this.filter === 'search') {
                this.search(this.searchQuery)
            } else {
                this.getMovies()
            }
        },

        changeFilter(filter) {
            this.filter = filter
            this.getMovies()
        },

        search(query) {
            this.filter = 'search'
            this.searchQuery = query

            window.axios.get(`/api/movies/search?page=${this.currentPage}&query=${this.searchQuery}`)
            .then((response) => {
                this.movies = response.data.movies
            })
            .catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>
