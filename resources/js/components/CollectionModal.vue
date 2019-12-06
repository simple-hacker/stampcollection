<template>
    <modal name="collection" @before-open="beforeOpen" transition="pop-out" :width="modalWidth" height="auto">
        <div class="bg-blue-800 p-2">
            <!-- Stamp Details -->
            <div class="mb-2 p-4 bg-white rounded shadow">
                <h1 class="text-4xl border-b mb-3" v-text="stamp.title"></h1>
                <div class="flex">
                    <div class="w-1/3 mr-1">
                        <img :src="'/'+stamp.image_src" alt="Title" class="h-40">
                    </div>
                    <div class="w-2/3 ml-1">
                        <div class="mb-3">
                            Part of <a :href="'/catalogue/'+issue.id+'/'+issue.slug" class="hover:underline" v-text="issue.title"></a>
                        </div>
                            <p class="mb-2" v-text="stamp.prefixedSgNumber"></p>
                            <p v-text="stamp.description"></p>
                    </div>
                </div>
            </div>
            <!-- Add To Collection -->
            <div class="p-4 bg-white rounded shadow">
                <h2 class="text-3xl border-b mb-4">Add To Collection</h2>
                <div class="flex flex-1 mb-1 items-center" v-for="(collection, index) in addToCollection" v-bind:key="index">
                    <select name="grading_id" v-model="collection.gradingId" class="p-2 border rounded flex-1 bg-white" placeholder="Grading Type" required>
                            <option v-for="(grading, gradingId) in gradings" v-bind:key="gradingId" :value="gradingId">{{grading}}</option>
                    </select>
                    <input type="number" name="value" class="p-2 border rounded ml-2" step="0.01" min="0" placeholder="Value" v-model="collection.value" required>
                    <button @click.prevent="removeRow(index)" class="ml-2">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0zM15 9v2h-10v-2h10z"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between mt-5">
                    <button @click.prevent="addRow()" class="flex border rounded p-2 text-center bg-green-500 hover:bg-green-600 text-white">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M11 9h4v2h-4v4h-2v-4h-4v-2h4v-4h2v4zM10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0z"></path>
                        </svg>
                        Another Row
                    </button>
                    <button class="flex border rounded p-2 text-center bg-blue-500 hover:bg-blue-600 text-white">
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
                <div class="flex items-center" v-for="(collectedStamp, index) in collection" v-bind:key="index">
                    <div class="flex flex-1 justify-between">
                        <p>{{ collectedStamp.grading.type }}</p>
                        <p>£{{ collectedStamp.value.toFixed(2) }}</p>
                    </div>
                    <div class="flex justify-end ml-4">
                        <form method="POST" action="">
                            <button type="submit" class="border rounded p-2 text-center w-full bg-red-500 hover:bg-red-600 text-white">
                                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                    <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    const MODAL_WIDTH = 656

    export default {
        name: 'CollectionModel',
        data() {
            return {
                stamp: {},
                issue: {},
                addToCollection: [{
                    gradingId: null,
                    value: ''
                }],
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
            addRow() {
                this.addToCollection.push({ gradingId: null, value: '' });
            },
            removeRow(index) {
                this.addToCollection.splice(index, 1);
            }
        },
    }
</script>