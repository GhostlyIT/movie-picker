<template>
    <div id="picked-list" v-bind:class="{open: this.isOpen}">
        <div class="picked-list__label" >
            <button v-on:click="toggleList" type="button">My List</button>
        </div>
        <div class="picked-list__container">
            <div v-if="this.movies.length > 0">
                <div v-for="movie in this.movies" :key="movie.id" class="picked-list__movie d-flex align-items-center">
                    <img v-if="movie.poster_path != null" class="movie__poster" :src="`https://image.tmdb.org/t/p/w200/${movie.poster_path}`">
                    <h2 v-else class="text-center movie__poster">No poster</h2>
                    <div class="picked-list__movie--info">
                            <h5>{{ movie.title }} ({{ movie.release_date === '' ? 'No release date' : movie.release_date }})</h5>
                            <p>{{ movie.overview }}</p>
                            <p>Rating: {{ movie.vote_average }}</p>
                    </div>
                </div>
                <div class="picked-list__actions d-flex">
                    <button v-on:click="reset" type="button">Reset</button>
                    <button v-on:click="save" type="button">Save</button>
                    <button v-on:click="share" type="button">Share</button>
                    <input v-if="this.linkToShare" type="text" disabled v-bind:value="this.linkToShare">
                </div>
            </div>
            <h1 class="text-center" v-else>You haven't picked any movie</h1>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        movies: [],
        isOpen: false,
        linkToShare: false
    }),
    methods: {
        getPickedMovies() {
            this.movies = []
            this.$store.state.pickedMovies.forEach(movieId => {
                window.axios.get(`https://api.themoviedb.org/3/movie/${movieId}?api_key=${process.env.MIX_TMDB_KEY}`)
                .then((response) => {
                    this.movies.push(response.data)
                })
                .catch((error) => {
                    console.log(error)
                })
            })
        },

        toggleList() {
            this.isOpen = !this.isOpen
            if (this.isOpen) {
                this.getPickedMovies()
            }
        },

        save() {
            this.$store.dispatch('savePickedMovies')
        },

        reset() {
            this.$store.dispatch('resetPickedMovies')
        },

        share() {
            let shareLink = location.protocol + '//' + location.hostname + '/?movie_list=';
            this.$store.state.pickedMovies.forEach((el, i, arr) => {
                shareLink += el
                if (i + 1 < arr.length) {
                    shareLink += ','
                }
            })
            this.linkToShare = shareLink
        }
    },
    computed: {
        moviesStore() {
            return this.$store.state.pickedMovies
        }
    },
    watch: {
        moviesStore(newM, old) {
            this.getPickedMovies()
        }
    }
}
</script>
