<template>
    <div
        class="bg-white rounded-lg shadow-lg pt-3 w-2/3 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20"
    >
        <div class="px-6 text-center">
            <div class="my-3">
                <div class="block mb-2 text-sm font-medium">
                    Prénom
                </div>
                <input
                    class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="star.first_name"
                    placeholder="John"
                    required
                >
                <div
                    class="text-left text-red-700"
                    v-if="errors"
                    v-for="message in errors.first_name"
                >
                    {{message}}
                </div>
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
                <div
                    class="text-left text-red-700"
                    v-if="errors"
                    v-for="message in errors.last_name"
                >
                    {{message}}
                </div>
            </div>
            <div class="mb-6">
                <div class="block mb-2 text-sm font-medium">
                    Photo de profile (url)
                </div>
                <input
                    class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="star.profil_url"
                    placeholder="https://www.example.com/profile1_png"
                    required
                />
                <div
                    class="text-left text-red-700"
                    v-if="errors"
                    v-for="message in errors.profil_url"
                >
                    {{message}}
                </div>
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
                <div
                    class="text-left text-red-700"
                    v-if="errors"
                    v-for="message in errors.description"
                >
                    {{message}}
                </div>
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
                v-if="creating"
                @click="create(star)"
                class="border-b text-blue-800 border-gray-100 w-full px-6 py-3 hover:bg-gray-100"
            >
                Créer
            </li>
            <li
                v-else
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
import {ref} from "vue";

const emit = defineEmits(['close', 'created', 'updated'])
const props = defineProps({
    // Inputs will be pre-refilled with the data of the star, if given
    star: {
        type: Object,
        required: false,
        default: {
            first_name: null,
            last_name: null,
            profil_url: null,
            description: null,
        }
    },
    // Determine if the modal is used to create a new start
    creating: {
        type: Boolean,
        required: false,
        default: false
    }
})

let errors = ref([])

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

// Remove errors display on form
function resetErrors() {
    errors.value = []
}

function close() {
    emit('close')
}

// Push the new data to the api
function save(star) {
    resetErrors()
    axios.put('api/stars/' + star.id, {
        'first_name': star.first_name,
        'last_name': star.last_name,
        'profil_url': star.profil_url,
        'description': star.description,
    })
        .then(() => {
            close()
        })
        .catch(error => {
            errors.value = error.response.data.errors
        });
}

// Add a new star
function create(star) {
    resetErrors()
    axios.post('api/stars', {
        'first_name': star.first_name,
        'last_name': star.last_name,
        'profil_url': star.profil_url,
        'description': star.description,
    })
        .then(() => {
            resetForm()
            emit('created')
            close()
        })
        .catch(error => {
            errors.value = error.response.data.errors
        });
}

</script>

<style scoped>
</style>
