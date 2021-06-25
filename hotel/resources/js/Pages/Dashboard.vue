<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <inertia-link :href="route('search.rooms')" class="ml-4 text-sm text-white bg-black p-3 rounded shadow">
                            Znajdź pokój
                        </inertia-link>

                        <inertia-link :href="route('reservations')" class="ml-4 text-sm text-white bg-black p-3 rounded shadow">
                            Zobacz rezerwacje
                        </inertia-link>

                        <inertia-link :href="''" class="ml-4 text-sm text-white bg-black p-3 rounded shadow">
                            Zobacz klientów
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        props: ['errors'],
        components: {
            BreezeAuthenticatedLayout,
        },
        data() {
            return {
                csrf_token: document.querySelector('meta[name="csrf-token"]').content,
            }
        },
    }
</script>
