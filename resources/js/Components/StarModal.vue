<template>
    <div
        class="bg-white rounded-lg pt-6 shadow-lg fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <div class="px-6 pb-6 text-center">
            <div class="mb-6">
                <div class="block mb-2 text-sm font-medium">
                    Prénom
                </div>
                <input
                    class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="star.first_name"
                    placeholder="John"
                    required
                >
            </div>
            <div class="mb-6">
                <div class="block mb-2 text-sm font-medium">
                    Nom
                </div>
                <input
                    class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="star.last_name"
                    placeholder="Doe"
                    required
                />
            </div>
            <div class="mb-6">
                <div class="block mb-2 text-sm font-medium">
                    Description
                </div>
                <textarea
                    rows="10"
                    class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Description de la star"
                    v-model="star.description"
                ></textarea>
            </div>
        </div>
        <ul class="cursor-pointer border-t border-gray-100 w-25 text-center flex">
            <li
                @click="resetForm(); close();"
                class="border-b text-gray-500 border-gray-100 w-full px-6 py-3 hover:bg-gray-100"
            >
                Annuler
            </li>
            <li
                @click="save(star)"
                class="border-b text-blue-800 border-gray-100 w-full px-6 py-3 hover:bg-gray-100"
            >
                Sauvegarder
            </li>
        </ul>
    </div>
</template>

<script setup>

import axios from "axios";

const props = defineProps(['star'])
const emit = defineEmits(['close'])

const original_data = {
    first_name: props.star?.first_name,
    last_name: props.star?.last_name,
    profil_url: props.star?.profil_url,
    description: props.star?.description
}

// Reset the form by re-instating the orignal values to each value
function resetForm() {
    props.star.first_name = original_data.first_name
    props.star.last_name = original_data.last_name
    props.star.profil_url = original_data.profil_url
    props.star.description = original_data.description
}

function close() {
    emit('close')
}

// Push the new data to the api
function save(star) {
    axios.put('api/stars/' + star.id, {
        'first_name': star.first_name,
        'last_name': star.last_name,
        'profil_url': star.profil_url,
        'description': star.description,
    })
        .then(() => {
            close()
        });
}

</script>

<style scoped>
</style>
