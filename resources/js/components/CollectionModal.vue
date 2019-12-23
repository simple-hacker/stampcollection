<template>
    <transition name="fade-slide-in">
        <modal name="collection" @before-open="beforeOpen" @closed="closed" :width="modalWidth" height="auto" :scrollable="true" class="relative">
            <div class="absolute top-0 right-0 mt-3 mr-3">
                <button @click="$modal.hide('collection')" class="rounded-full p-2 bg-white border-darker border-4 text-darker hover:bg-darker hover:text-white">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32">
                        <path d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
                    </svg>
                </button>
            </div>
            <div class="bg-dark p-2">
                <!-- Stamp Details -->
                <div class="mb-2 p-4 bg-white rounded shadow">
                    <h1 class="text-4xl border-b mb-3" v-text="stamp.title"></h1>
                    <div class="flex">
                        <div class="flex flex-col items-center w-1/3 mr-1">
                            <img :src="'/'+stamp.image_src" :alt="stamp.title" class="object-contain">
                            <p class="my-2" v-text="stamp.prefixedSgNumber"></p>
                        </div>
                        <div class="w-2/3 ml-1">
                            <div class="mb-3">
                                Part of <a :href="'/catalogue/'+issue.id+'/'+issue.slug" class="text-highlight font-bold hover:underline" v-text="`${issue.title} (${issue.year})`"></a>
                            </div>
                            <p v-text="stamp.description"></p>
                        </div>
                    </div>
                </div>
                <!-- Add To Collection -->
                <div class="p-4 bg-white rounded shadow">
                    <h2 class="text-3xl border-b mb-4">Add To Collection</h2>
                    <div class="flex mb-1 items-start" v-for="(stampToAdd, index) in stampsToAdd" :key="index">
                        <div class="flex flex-1 flex-col">
                            <select
                                name="grading_id"
                                v-model="stampToAdd.grading_id"
                                class="p-2 w-full rounded bg-white"
                                :class="stampsToAddErrors[`${index}.grading_id`] ? 'border-red-500 border-2' : 'border'"
                                placeholder="Grading Type"
                                required>
                                    <option v-for="grading in gradings" :key="grading.id" :value="grading.id" :title="grading.description">{{grading.type}}</option>
                            </select>
                            <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="stampsToAddErrors[`${index}.grading_id`]">{{ stampsToAddErrors[`${index}.grading_id`][0] }}</span>
                        </div>
                        <!-- <div class="flex flex-col">
                            <input
                                type="number"
                                name="value"
                                class="p-2 rounded ml-2"
                                :class="stampsToAddErrors[`${index}.value`] ? 'border-red-500 border-2' : 'border'"
                                step="0.01"
                                min="0"
                                placeholder="Value"
                                v-model="stampToAdd.value"
                                required>
                            <span class="p-2 italic text-xs font-bold text-red-500" v-if="stampsToAddErrors[`${index}.value`]">{{ stampsToAddErrors[`${index}.value`][0] }}</span>
                        </div> -->
                        <div class="flex pt-2">
                            <button @click.prevent="removeRow(index)" class="ml-2">
                                <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path d="M10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0zM15 9v2h-10v-2h10z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between mt-5">
                        <button @click.prevent="addRow()" class="flex border rounded p-2 text-center bg-green-500 hover:bg-green-600 text-white">
                            <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                <path d="M11 9h4v2h-4v4h-2v-4h-4v-2h4v-4h2v4zM10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0z"></path>
                            </svg>
                            Another Row
                        </button>
                        <button @click.prevent="saveToCollection()" class="flex border rounded p-2 text-center bg-blue-500 hover:bg-blue-600 text-white">
                            <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                <path d="M28 0h-28v32h32v-28l-4-4zM16 4h4v8h-4v-8zM28 28h-24v-24h2v10h18v-10h2.343l1.657 1.657v22.343z"></path>
                            </svg>
                            Save To Collection
                        </button>
                    </div>
                </div>
                <!-- Manage Collection -->
                <div class="mt-2 p-4 bg-white rounded shadow" v-show="collection.length > 0">
                    <h2 class="text-3xl border-b mb-4">Manage Collection</h2>
                    <transition-group name="collection">
                        <div class="flex items-center" v-for="(collectedStamp, index) in collection" :key="collectedStamp.id">
                            <div class="flex flex-1 justify-between">
                                <p>{{ collectedStamp.grading.grading }}</p>
                                <p v-if="collectedStamp.grading.type === 'mint'">£{{ collectedStamp.stamp.mint_value.toFixed(2) }}</p>
                                <p v-if="collectedStamp.grading.type === 'used'">£{{ collectedStamp.stamp.used_value.toFixed(2) }}</p>
                            </div>
                            <div class="flex justify-end ml-4">
                                <button @click.prevent="removeFromCollection(collectedStamp.id, index)" class="border rounded p-2 text-center w-full bg-red-500 hover:bg-red-700 text-white">
                                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                        <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </transition-group>
                </div>
            </div>
        </modal>
    </transition>
</template>

<script>
    const MODAL_WIDTH = 656

    export default {
        name: 'CollectionModel',
        data() {
            return {
                stamp: {},
                issue: {},
                stampsToAdd: [{
                    grading_id: null,
                    value: ''
                }],
                stampsToAddErrors: {},
                gradings: [],
                collection: [],
                modalWidth: MODAL_WIDTH,
            }
        } ,
        methods: {
            beforeOpen (event) {
                this.stamp = event.params.stamp;
                this.issue = event.params.stamp.issue;

                axios.get('/collection/'+event.params.stamp.id)
                    .then(response => {
                        this.gradings = response.data.gradings;
                        this.collection = response.data.stampsInCollection;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            closed() {
                // Clear out all data so we don't see it briefly when opening up another collection modal.
                this.stamp = {};
                this.issue = {};
                this.stampsToAdd = [{
                    grading_id: null,
                    value: ''
                }];
                this.stampsToAddErrors = {};
                this.collection = [];
            },
            addRow() {
                this.stampsToAdd.push({
                    grading_id: null,
                    value: ''
                });
            },
            removeRow(index) {
                this.stampsToAdd.splice(index, 1);
            },
            saveToCollection() {
                axios.post('/collection', {
                        stamp: this.stamp,
                        stampsToAdd: this.stampsToAdd
                    })
                    .then(response => {
                        this.collection = response.data;

                        this.stampsToAdd = [{
                            grading_id: null,
                            value: ''
                        }];

                        this.stampsToAddErrors = {};

                        // Maybe emit a updatedCollection to update the collection data behind the modal.
                        // Especially on the /collection page.
                        // Could update the total value of collection in background too.
                    })
                    .catch(error => {
                        this.stampsToAddErrors = error.response.data.errors;
                    });
            },
            removeFromCollection(collection, index) {

                // TODO: Add nicer confirmation dialog.
                if (confirm('Are you sure you want to remove this stamp from your collection?')) {
                    axios.post('/collection/'+collection, {
                            _method: 'delete',
                            collection: collection
                        })
                        .then(response => {
                            this.collection.splice(index, 1);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }

            }
        },
    }
</script>


<style>
    .fade-slide-in-enter-active,
    .fade-slide-in-leave-active {
        transition: all 0.5s;
    }

    .fade-slide-in-enter,
    .fade-slide-in-leave-active {
        opacity: 0;
        transform: translateY(24px);
    }

    .collection-enter-active, .collection-leave-active {
        transition: all 0.5s
    }

    .collection-enter {
        opacity: 0;
        transform: translateX(-30px);
    }

    .collection-leave-to {
        opacity: 0;
        transform: translateX(30px);
    }
</style>