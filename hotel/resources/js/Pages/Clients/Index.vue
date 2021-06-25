<template>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <inertia-link v-if="$page.props.auth.user" href="/dashboard" class="text-sm text-gray-700 underline">
                Dashboard
            </inertia-link>

            <template v-else>
                <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </inertia-link>
            </template>
        </div>

        <div :class="{hidden: !modal}" class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-75">
            <div class="bg-white rounded-lg w-1/2">
                <div class="flex flex-col items-start p-4">
                    <div class="flex items-center w-full">
                        <div class="text-gray-900 font-medium text-lg">Edycja klienta</div>
                        <svg @click="modal = null" class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                        </svg>
                    </div>
                    <hr>
                    <form method="post" class="w-full" @submit.prevent="submit">

                        <div class="flex flex-col">
                            Imię
                            <input class="border" v-model="form.firstname" required>
                            Nazwisko
                            <input class="border" v-model="form.lastname" required>
                            Telefon
                            <input class="border" v-model="form.phone" required>
                        </div>

                        <div class="mt-4">
                            <button class="bg-black p-3 ml-auto mr-0 block w-28 rounded text-white" type="submit">Zapisz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-5xl w-screen mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mx-3 my-2 rounded">
                        <div v-for="(client, index) in clients" :key="index" class="mb-1 w-full shadow border p-3">
                            <p class="text-2xl">{{client.firstname}} {{client.lastnmae}}</p>
                            <p class="text-xl text-gray-700">Telefon: {{client.phone}}</p>


                            <button @cick="openModal(client)" class="bg-black p-3 ml-auto mr-0 block w-28 rounded text-white">Edytuj</button>
                            <inertia-link :href="route('delete.client', client.id)"  class="bg-red-600 p-3 ml-auto mr-0 block w-28 rounded text-white">Usuń</inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>




<script>
import Input from "@/Components/Input";
import { Inertia } from '@inertiajs/inertia'
import Button from "@/Components/Button";

export default {
    components: {Button, Input, Inertia},
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        errors: Object,
        clients: Array
    },
    data() {
        return {
            csrf_token: document.querySelector('meta[name="csrf-token"]').content,
            modal: null,
            form: {
                firstname: null,
                lastname: null,
                phone: null
            }

        }

    },
    methods: {
        openModal(client) {
            this.modal = client;
            this.form.firstname = client.firstname;
            this.form.lastname = client.lastname;
            this.form.phone = client.phone;
        },
        submit() {
            Inertia.post('/edit/client/' + this.modal.id, this.form, {
                onSuccess: () => location.reload(true),
            });
        }
    }
}
</script>

