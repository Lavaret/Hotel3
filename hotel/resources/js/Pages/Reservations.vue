<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">   
                Rezerwacje
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl w-screen mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mx-3 my-2 rounded">
                        <div v-for="(reservation, index) in reservations" :key="index" class="mb-1 w-full shadow border p-3">
                            <p class="text-2xl">Pokój {{reservation.room.beds}} osobowy</p>
                            <p class="text-xl text-gray-700">Cena: {{reservation.room.price}} zł</p>
                            <p class="text-lg">{{reservation.check_in}} - {{reservation.check_out}}</p>
                            <p class="text-sm">{{reservation.client.firstname}} {{reservation.client.lastname}} {{reservation.client.phone}}</p>
                            <div class="flex w-full justify-end">
                                <button @click="deleteReservation(reservation.id)" class="bg-red-600 p-3 m-1 block w-28 rounded text-white">Usuń</button>
                                <button class="bg-black p-3 m-1 block w-28 rounded text-white">Zamelduj klienta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        props: ['errors', 'reservations'],
        components: {
            BreezeAuthenticatedLayout,
        },
        data() {
            return {
                csrf_token: document.querySelector('meta[name="csrf-token"]').content,
            }
        },
        methods: {
            deleteReservation(id) {
                this.$inertia.post('/delete/reservation/' + id, null, {
                    onSuccess: () => location.reload(true)
                });
            }
        }
    }
</script>
