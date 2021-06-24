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

        <div :class="{hidden: !showModal}" class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-75">
            <div class="bg-white rounded-lg w-1/2">
                <div class="flex flex-col items-start p-4">
                <div class="flex items-center w-full">
                    <div class="text-gray-900 font-medium text-lg">Pokój {{room.beds}} osobowy</div>
                    <svg @click="showModal = !showModal" class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                    </svg>
                </div>
                <hr>
                    <form method="post" class="w-full" @submit.prevent="submit">
                        <div class="flex">
                            <a @click="form.client = 'choose'" class="bg-black p-3 m-1 block cursor-pointer w-28 rounded text-white">Wybierz</a>
                            <a @click="form.client = 'new'" class="bg-black p-3 block m-1 cursor-pointer  w-28 rounded text-white">Nowy klient</a>
                        </div>

                        <div v-if="form.client === 'choose'">
                            Wybierz klienta
                            <select class="text-gray-900" v-model="form.client_id">
                                <option v-for="(client, index) in clients" :key="index" :value="client.id">{{client.firstname}} {{client.lastname}}</option>
                            </select>
                        </div>

                        <div v-if="form.client === 'new'">
                            Dodaj klienta
                            <div class="flex flex-col">
                                Imię
                                <input class="border" v-model="form.clientData.firstname" required>
                                Nazwisko
                                <input class="border" v-model="form.clientData.lastname" required>
                                Telefon
                                <input class="border" v-model="form.clientData.phone" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="bg-black p-3 ml-auto mr-0 block w-28 rounded text-white" type="submit">Zarezerwuj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-5xl w-screen mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mx-3 my-2 rounded">
                        <div v-for="(room, index) in rooms" :key="index" class="mb-1 w-full shadow border p-3">
                            <p class="text-2xl">Pokój {{room.beds}} osobowy</p>
                            <p class="text-xl text-gray-700">Cena: {{room.price}} zł</p>
                            <p v-if="room.has_bathroom">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Łazienka
                            </p>
                            <p v-if="room.has_wifi">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                </svg>
                                Wi-Fi
                            </p>
                            <p v-if="room.has_balcony">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Balkon
                            </p>
                            <button @click="makeReservation(room)" class="bg-black p-3 ml-auto mr-0 block w-28 rounded text-white">Zarezerwuj</button>
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

export default {
    components: {Input, Inertia},
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        errors: Object,
        rooms: Array,
        dates: Object,
        clients: Array
    },
    data() {
        return {
            csrf_token: document.querySelector('meta[name="csrf-token"]').content,
            room: {
                beds: null,
                id: null
            },
            form: {
                check_in: this.dates['check_in'],
                check_out: this.dates['check_out'],
                _token: this.csrf_token,
                room_id: null,
                client: 'choose',
                client_id: null,
                clientData: {
                    firstname: null,
                    lastname: null,
                    phone: null
                }
            },
            showModal: false
        }
    },
    methods: {
        makeReservation(room) {
            this.room = room;
            this.showModal = true;
        },
        submit() {
            this.form.room_id = this.room.id;
            Inertia.post('/make/reservation', this.form, {
                onSuccess: () => location.reload(true),
            });
        }
    }
}
</script>

