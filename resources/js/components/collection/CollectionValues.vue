<template>
    <div class="flex flex-col bg-white rounded shadow">
        <div class="flex justify-between items-center mb-2 p-4 bg-darker text-white">
            <h1 class="text-4xl">My Collection</h1>
            <a href="/collection/print" class="p-4 hover:text-highlight" target="_blank">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 32 32">
                    <path d="M8 2h16v4h-16v-4z"></path>
                    <path d="M30 8h-28c-1.1 0-2 0.9-2 2v10c0 1.1 0.9 2 2 2h6v8h16v-8h6c1.1 0 2-0.9 2-2v-10c0-1.1-0.9-2-2-2zM4 14c-1.105 0-2-0.895-2-2s0.895-2 2-2 2 0.895 2 2-0.895 2-2 2zM22 28h-12v-10h12v10z"></path>
                </svg>
            </a>
        </div>
        <div class="flex flex-col items-center py-2 px-4">
            <h3 class="text-3xl font-medium mb-3" v-text="'Your collection is worth £'+collectionTotal"></h3>
        </div>
        <div class="flex w-full justify-center flex-wrap">
            <div data-toggle="tooltip" title="Face Total Value" class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4 border-face text-face">
                <div class="flex flex-col items-center font-semibold">
                    <span v-text="'£'+collectionValues.face_total.toFixed(2)"></span>
                    <small>Face Total Value</small>
                </div>
            </div>
            <div data-toggle="tooltip" title="Mint Total Value" class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4 border-face text-face">
                <div class="flex flex-col items-center font-semibold">
                    <span v-text="'£'+collectionValues.mint_total.toFixed(2)"></span>
                    <small>Mint Total Value</small>
                </div>
            </div>
            <div data-toggle="tooltip" title="Used Total Value" class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4 border-face text-face">
                <div class="flex flex-col items-center font-semibold">
                    <span v-text="'£'+collectionValues.used_total.toFixed(2)"></span>
                    <small>Used Total Value</small>
                </div>
            </div>
            <div class="flex w-full justify-center flex-wrap">
                    <div
                        v-for="(value, abbreviation) in collectionValues.gradings"
                        :key="abbreviation"
                        data-toggle="tooltip"
                        :title="gradings[abbreviation].description"
                        class="ml-1 mr-1 mb-2 py-2 px-4 rounded-lg border-4"
                        :class="'border-'+abbreviation+' text-'+abbreviation"
                    >
                        <div class="flex flex-col items-center font-semibold">
                            <span v-text="'£'+value.toFixed(2)"></span>
                            <small v-text="gradings[abbreviation].grading"></small>
                        </div>
                    </div>
            </div>
        </div>
        <div class="text-2xl font-medium mb-3 text-center mt-2 mb-4">
            You have collected {{ collectedStampsCount }} stamps out of {{ stampsCount}} stamps in the catalogue.
        </div>
    </div>
</template>

<script>
export default {
    name: 'CollectionValues',
    props: ['collectionValues', 'gradings', 'collectedStamps', 'stampsCount'],
    computed: {
        collectionTotal() {
            return (this.collectionValues.mint_total + this.collectionValues.used_total).toFixed(2);
        },
        collectedStampsCount() {
            return Object.keys(this.collectedStamps).length;
        }
    },
    created() {
        console.log(this.collectedStamps)
    }
}
</script>

<style>

</style>