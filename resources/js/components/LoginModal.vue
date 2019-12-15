<template>
    <modal name="login" @before-open="beforeOpen" transition="pop-out" :width="modalWidth" height="auto">
        <div class="text-center bg-dark">
            <h1 class="text-xl text-white font-bold px-8 py-3">{{title}}</h1>
        </div>
        <form class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    name="email"
                    type="email"
                    placeholder="Email"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.email ? 'border-red-500 border-2' : 'border'"
                    v-model="form.email"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="emailError in errors.email" v-bind:key="emailError" v-text="emailError"></span>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.password ? 'border-red-500 border-2' : 'border'"
                    v-model="form.password"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="passwordError in errors.password" v-bind:key="passwordError" v-text="passwordError"></span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button @click.prevent="submitForm()" type="submit" class="bg-dark hover:bg-darker text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Sign In
                </button>
                <a v-show="passwordReset" @click.prevent="showForgottenPasswordModal()" class="inline-block align-baseline font-bold text-sm text-dark hover:text-darker" href="/password/reset">
                    Forgot your password?
                </a>
            </div>
        </form>
    </modal>
</template>

<script>
const MODAL_WIDTH = 656

export default {
    name: 'LoginModal',
    data () {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: {},
            title: 'Login',
            passwordReset: true,
            modalWidth: MODAL_WIDTH,
        }
    },
    methods: {
        submitForm() {
            axios.post('login', this.form)
                .then(response => {
                    location = 'collection';
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        beforeOpen (event) {
            if (event.params) {
                this.title = "Demo Login";
                this.passwordReset = false;
                this.form.email = event.params.email;
                this.form.password = event.params.password;
            } else {
                this.title = "Login";
                this.passwordReset = true;
                this.form.email = '';
                this.form.password = '';
            }
        },
        showForgottenPasswordModal() {
            this.$modal.hide('login');
            this.$modal.show('forgotten-password');

        }
    },
    created () {
        this.modalWidth = window.innerWidth < MODAL_WIDTH
            ? MODAL_WIDTH / 2
            : MODAL_WIDTH;
    }
}
</script>

<style>
    .pop-out-enter-active,
    .pop-out-leave-active {
    transition: all 0.5s;
    }

    .pop-out-enter,
    .pop-out-leave-active {
    opacity: 0;
    transform: translateY(24px);
    }
</style>