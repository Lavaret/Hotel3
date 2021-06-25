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

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form method="get" :action="route('result.rooms')">
                            <input type="hidden" name="_token" :value="csrf_token">
                            <p class="text-gray-800 font-medium">Znajdź pokój</p>
                            <div class="inline-block mt-2 w-1/2 pr-1">
                                <label class="hidden block text-sm text-gray-600" for="check_in_date">Data zameldowania</label>
                                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="check_in_date" name="check_in_date" type="date" required placeholder="Check In" aria-label="Check In">
                                <div class="font-semibold text-red-600" v-if="errors.check_in_date">{{ errors.check_in_date }}</div>
                            </div>
                            <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                                <label class="hidden block text-sm text-gray-600" for="check_out_date">Data wymeldowania</label>
                                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="check_out_date"  name="check_out_date" type="date" required placeholder="Check Out" aria-label="Check Out">
                                <div class="font-semibold text-red-600" v-if="errors.check_out_date">{{ errors.check_out_date }}</div>
                            </div>
                            <div class="">
                                <label class="block text-sm text-gray-00" for="beds">Ilość łóżek</label>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="beds" name="beds" type="number" max="5" required placeholder="Beds" aria-label="Beds">
                                <div class="font-semibold text-red-600" v-if="errors.beds">{{ errors.beds }}</div>
                            </div>

                            <div class="flex items-baseline space-x-2 mt-2">
                                <input type="checkbox" name="has_bathroom" id="bathroom" class="inline-block">
                                <p class="text-gray-600 text-sm">Ma łazienkę</p>
                            </div>

                            <div class="flex items-baseline space-x-2 mt-2">
                                <input type="checkbox" name="has_balcony" id="balcony" class="inline-block">
                                <p class="text-gray-600 text-sm">Ma balkon</p>
                            </div>

                            <div class="flex items-baseline space-x-2 mt-2">
                                <input type="checkbox" name="has_wifi" id="wifi" class="inline-block">
                                <p class="text-gray-600 text-sm">Ma wifi</p>
                            </div>

                            <div class="mt-4">
                                <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Search</button>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        errors: Array,
    },
    data() {
        return {
            csrf_token: document.querySelector('meta[name="csrf-token"]').content,
        }
    },
}
</script>
