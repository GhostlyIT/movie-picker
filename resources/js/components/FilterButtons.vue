<template>
    <div id="filter" class="row">
        <button @click="changeFilter('popular')">Popular</button>
        <button @click="changeFilter('latest')">Latest</button>
        <button @click="changeFilter('top_rated')">Top Rated</button>
    </div>
</template>

<script>
export default {
    props: ["changeFilter"]
}
</script>
