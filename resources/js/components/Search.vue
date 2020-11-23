<template>
        <div id="search" class="row component">
            <input @input="search($event.target.value)" placeholder="Search...">
        </div>
</template>

<script>
export default {
    props: ["search"]
}
</script>
