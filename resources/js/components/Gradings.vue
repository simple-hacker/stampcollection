<template>
    <div>
        <h1 class="text-4xl w-full border-b mb-2">Edit Gradings</h1>
        <div class="mb-4">
            <transition-group name="slide">
                <div
                    v-for="grading in gradings"
                    :key="grading.id"
                    class="flex mb-1 items-start"
                >
                    <div class="flex flex-col">
                        <input
                            type="text"
                            v-model="grading.abbreviation"
                            v-text="grading.abbreviation"
                            placeholder="Abbreviation"
                            class="p-2 m-1"
                            :class="updateGradingsErrors[`${grading.id}.abbreviation`] ? 'border-red-500 border-2' : 'border border-highlight'"
                        >
                        <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="updateGradingsErrors[`${grading.id}.abbreviation`]">{{ updateGradingsErrors[`${grading.id}.abbreviation`][0] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <input
                            type="text"
                            v-model="grading.grading"
                            v-text="grading.grading"
                            placeholder="Grading"
                            class="p-2 m-1"
                            :class="updateGradingsErrors[`${grading.id}.grading`] ? 'border-red-500 border-2' : 'border border-highlight'"
                        >
                        <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="updateGradingsErrors[`${grading.id}.grading`]">{{ updateGradingsErrors[`${grading.id}.grading`][0] }}</span>
                    </div>
                    <div class="flex flex-col w-full">
                        <input
                            type="text"
                            v-model="grading.description"
                            v-text="grading.description"
                            placeholder="Description"
                            class="p-2 m-1 w-full"
                            :class="updateGradingsErrors[`${grading.id}.description`] ? 'border-red-500 border-2' : 'border border-highlight'"
                        >
                        <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="updateGradingsErrors[`${grading.id}.description`]">{{ updateGradingsErrors[`${grading.id}.description`][0] }}</span>
                    </div>
                    <div class="flex items-start p-1 ml-1">
                        <button @click.prevent="removeGrading(grading, grading.id)" class="border rounded p-2 text-center bg-red-500 hover:bg-red-700 text-white">
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </transition-group>
            <div class="flex items-center">
                <button
                    v-text="'Save Changes'"
                    @click="updateGradings"
                    class="mt-3 py-2 px-4 rounded text-center border border-darker bg-dark text-white text-xl hover:bg-highlight"
                >                
                </button>
                <span v-if="showUpdatedMessage" class="flex tems-center ml-3 italic text-green-700">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                        <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                    </svg>
                    Saved Changes
                </span>
            </div>
        </div>
        <h1 class="text-4xl w-full border-b mt-5 mb-2">Add Gradings</h1>
        <div>
            <div
                v-for="(grading, index) in addGradings"
                :key="index"
                class="flex mb-1 items-start"
            >
                <div class="flex flex-col">
                    <input
                        type="text"
                        v-model="grading.abbreviation"
                        v-text="grading.abbreviation"
                        placeholder="Abbreviation"
                        class="p-2 m-1"
                        :class="addGradingsErrors[`${index}.abbreviation`] ? 'border-red-500 border-2' : 'border border-highlight'"
                    >
                    <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="addGradingsErrors[`${index}.abbreviation`]">{{ addGradingsErrors[`${index}.abbreviation`][0] }}</span>
                </div>
                <div class="flex flex-col">
                    <input
                        type="text"
                        v-model="grading.grading"
                        v-text="grading.grading"
                        placeholder="Grading"
                        class="p-2 m-1"
                        :class="addGradingsErrors[`${index}.grading`] ? 'border-red-500 border-2' : 'border border-highlight'"
                    >
                    <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="addGradingsErrors[`${index}.grading`]">{{ addGradingsErrors[`${index}.grading`][0] }}</span>
                </div>
                <div class="flex flex-col w-full">
                    <input
                        type="text"
                        v-model="grading.description"
                        v-text="grading.description"
                        placeholder="Description"
                        class="p-2 m-1 w-full"
                        :class="addGradingsErrors[`${index}.description`] ? 'border-red-500 border-2' : 'border border-highlight'"
                    >
                    <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="addGradingsErrors[`${index}.description`]">{{ addGradingsErrors[`${index}.description`][0] }}</span>
                </div>
                <div class="flex items-start p-2">
                    <button @click.prevent="addGradings.splice(index, 1)" class="ml-2">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M24 24.082v-1.649c2.203-1.241 4-4.337 4-7.432 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h28c0-4.030-5.216-7.364-12-7.918z"></path>
<path d="M10.225 24.854c1.728-1.13 3.877-1.989 6.243-2.513-0.47-0.556-0.897-1.176-1.265-1.844-0.95-1.726-1.453-3.627-1.453-5.497 0-2.689 0-5.228 0.956-7.305 0.928-2.016 2.598-3.265 4.976-3.734-0.529-2.39-1.936-3.961-5.682-3.961-6 0-6 4.029-6 9 0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h8.719c0.454-0.403 0.956-0.787 1.506-1.146z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button
                        v-text="'Add Gradings'"
                        @click="storeGradings"
                        class="mt-3 py-2 px-4 rounded text-center border border-darker bg-dark text-white text-xl hover:bg-highlight"
                    >                
                    </button>
                    <span v-if="showAddedMessage" class="flex tems-center ml-3 italic text-green-700">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                        </svg>
                        Added Gradings
                    </span>
                </div>
                <button @click.prevent="addRow()" class="flex border rounded p-2 text-center bg-green-500 hover:bg-green-600 text-white">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M11 9h4v2h-4v4h-2v-4h-4v-2h4v-4h2v4zM10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0z"></path>
                    </svg>
                    Another Row
                </button>
            </div>            
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            gradings: this.gradingsProp,
            addGradings: [
                {
                    abbreviation: '',
                    grading: '',
                    description: '',
                },
            ],
            showUpdatedMessage: false,
            showAddedMessage: false,
            updateGradingsErrors: {},
            addGradingsErrors: {},
        }
    },
    props: ['gradingsProp'],
    methods: {
        addRow() {
            this.addGradings.push({
                    abbreviation: '',
                    grading: '',
                    description: '',
                });
        },
        storeGradings() {
            axios.post('/admin/gradings', {gradings: this.addGradings})
                .then(response => {
                    this.gradings = response.data;

                    this.addGradings = [{
                        abbreviation: '',
                        grading: '',
                        description: '',
                    }];

                    this.addGradingsErrors = {};
                    this.showAddedMessage = true;
                })
                .catch(error => {
                    console.log(error);
                    this.addGradingsErrors = error.response.data.errors;
                });
        },
        updateGradings() {
            axios.post('/admin/gradings', {
                    _method: 'patch',
                    gradings: this.gradings
                })
                .then(response => {
                    this.updateGradingsErrors = {};
                    this.showUpdatedMessage = true;
                })
                .catch(error => {
                    console.log(error);
                    this.updateGradingsErrors = error.response.data.errors;
                });
        },
        removeGrading(grading, index) {
            if (confirm(`Are you sure you want to remove ${grading.grading}?`)) {
                axios.post('/admin/gradings/'+grading.id, {
                        _method: 'delete',
                        grading: grading
                    })
                    .then(response => {
                        Vue.delete(this.gradings, index);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
}
</script>

<style>
    .slide-enter-active, .slide-leave-active {
        transition: all 0.5s
    }

    .slide-enter {
        opacity: 0;
        transform: translateX(-30px);
    }

    .slide-leave-to {
        opacity: 0;
        transform: translateX(30px);
    }
</style>