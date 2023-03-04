<template>
    <div v-if="props.star" class="relative">
        <img
            class="w-36 h-36 float-left mr-3"
            :src="star.profil_url"
            alt=""/>
        <div
            class="text-2xl pt-2 pb-2 text-center"
        >{{ star.first_name }} {{ star.last_name }}
        </div>
        <div
            class="mt-2 text-justify"
        >{{ star.description }}
        </div>
        <div
            @click="remove"
            class="bg-red-400 hover:bg-red-600 border rounded-full absolute top-0 right-0 w-9 h-9 grid place-content-center">
            <img src="/assets/icons8-delete-trash-50.png" class="w-5 h-5" alt="delete"/>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";

const emit = defineEmits(['deleted'])

const props = defineProps(['star'])

// Remove the current selected star
function remove() {
    axios.delete('api/stars/' + props.star.id)
        .then(() => {
            emit('deleted')
        });
}
</script>

<style scoped>

</style>
