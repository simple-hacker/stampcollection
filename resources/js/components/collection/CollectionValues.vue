<template>
    <div class="flex flex-col bg-white rounded shadow">
        <div class="flex justify-between items-center mb-2 p-4 bg-darker text-white">
            <h1 class="text-4xl">My Collection</h1>
            <div class="flex">
                <a href="/collection/print" class="p-4 hover:text-highlight mr-1" target="_blank" title="Print collection">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 32 32">
                        <path d="M8 2h16v4h-16v-4z"></path>
                        <path d="M30 8h-28c-1.1 0-2 0.9-2 2v10c0 1.1 0.9 2 2 2h6v8h16v-8h6c1.1 0 2-0.9 2-2v-10c0-1.1-0.9-2-2-2zM4 14c-1.105 0-2-0.895-2-2s0.895-2 2-2 2 0.895 2 2-0.895 2-2 2zM22 28h-12v-10h12v10z"></path>
                    </svg>
                </a>
                <a href="/collection/missing" class="p-4 hover:text-highlight" target="_blank" title="Stamps missing from collection">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 32 32">
                        <path d="M16 2.899l13.409 26.726h-26.819l13.409-26.726zM16 0c-0.69 0-1.379 0.465-1.903 1.395l-13.659 27.222c-1.046 1.86-0.156 3.383 1.978 3.383h27.166c2.134 0 3.025-1.522 1.978-3.383h0l-13.659-27.222c-0.523-0.93-1.213-1.395-1.903-1.395v0z"></path>
                        <path d="M18 26c0 1.105-0.895 2-2 2s-2-0.895-2-2c0-1.105 0.895-2 2-2s2 0.895 2 2z"></path>
                        <path d="M16 22c-1.105 0-2-0.895-2-2v-6c0-1.105 0.895-2 2-2s2 0.895 2 2v6c0 1.105-0.895 2-2 2z"></path>
                    </svg>
                </a>
            </div>
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
        <div class="text-2xl font-medium text-center mt-2 mb-4">
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
}
</script>

<style>

</style>