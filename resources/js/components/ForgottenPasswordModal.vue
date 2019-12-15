<template>
    <modal name="forgotten-password" transition="pop-out" :width="modalWidth" height="auto">
        <div class="text-center bg-dark">
            <h1 class="text-xl text-white font-bold px-8 py-3">Reset Password</h1>
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
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.email"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="emailError in errors.email" v-bind:key="emailError" v-text="emailError"></span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button @click.prevent="submitForm()" class="bg-dark hover:bg-darker text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
const MODAL_WIDTH = 656

export default {
    name: 'ForgottenPasswordModal',
    data () {
        return {
            form: {
                email: '',
            },
            errors: {},
            modalWidth: MODAL_WIDTH,
        }
    },
    methods: {
        submitForm() {
            axios.post('password/email', this.form)
                .then(response => {
                    this.$modal.hide('forgotten-password');
                    this.$modal.show('dialog', {
                        title: 'Reset Password',
                        text: 'We have sent you a password reset link to your email.',
                        buttons: [
                            {
                            title: 'Okay',
                            class: 'py-3 hover:bg-gray-200',
                            }
                        ]
                        });
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
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