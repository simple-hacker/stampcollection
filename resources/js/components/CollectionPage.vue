<template>
    <div>
        <div class="mb-4">
            <collection-values
                :collection-values="collectionValuesData"
                :gradings="gradings"
            ></collection-values>
        </div>

        <div class="flex">
            <div class="mr-1 w-1/5">
                <collection-browse
                    :years="Object.keys(collection).reverse()"
                    :showYear="showYear"
                    v-on:change-year="changeYear"
                ></collection-browse>
            </div>
            <div class="flex-1 ml-1">
                <collection
                    :issues="collectionData[showYear]"
                    :collected-stamps="collectedStampsData"
                    :gradings="gradings"
                ></collection>
            </div>
        </div>

        <collection-modal
            :gradings="gradings"
            v-on:updated-collection="updatedCollection"
        ></collection-modal>
    </div>
</template>

<script>

import Collection from './collection/Collection.vue'
import CollectionValues from './collection/CollectionValues.vue'
import CollectionBrowse from './collection/CollectionBrowse.vue'
import CollectionModal from './CollectionModal.vue'

export default {
    data() {
        return {
            showYear: this.year,
            collectionData: this.collection,
            collectedStampsData: this.collectedStamps,
            collectionValuesData: this.collectionValues,
        }
    },
    props: ['collection', 'collectedStamps', 'collectionValues', 'gradings', 'year'],
    components: {
        'collection' : Collection,
        'collection-values' : CollectionValues,
        'collection-browse' : CollectionBrowse,
        'collection-modal' : CollectionModal,
    },
    methods: {
        changeYear(year) {
            this.showYear = year;
        },
        updatedCollection() {
            axios.get('/collection')
                .then(response => {
                    this.collectionData = response.data.collection;
                    this.collectedStampsData = response.data.collectedStamps;
                    this.collectionValuesData = response.data.collectionValues;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

<style>

</style>