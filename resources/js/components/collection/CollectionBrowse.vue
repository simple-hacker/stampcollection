<template>
    <div class="flex flex-col bg-white rounded shadow">
        <h3 class="mb-2 p-4 bg-darker text-white text-2xl font-bold text-center" v-text="showYear"></h3>
        <a
            v-for="year in years"
            :key="year"
            :href="'/collection/'+year"
            @click.prevent="$emit('change-year', year)"
            class="text-center py-2 px-4 border border-dark hover:text-highlight hover:border-highlight hover:bg-light mb-1"
            :class="(showYear == year) ? 'bg-highlight text-white' : 'text-dark'"
            v-text="year"
        >
            <!-- :class="(this.year == year) ? 'bg-dark text-white' : ''" -->
        </a>
    </div>
</template>

<script>
export default {
    name: 'CollectionBrowse',
    props: ['showYear', 'years'],
}
</script>

<style>

</style>