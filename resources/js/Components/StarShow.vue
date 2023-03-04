<template>
    <div v-if="props.star">
        <div
            @click="remove"
            class="bg-red-400 hover:bg-red-600 rounded-full w-8 h-8 float-right flex flex-row justify-center items-center">
            <img src="/assets/icons8-delete-trash-50.png" class="w-5 h-5" alt="supprimer"/>
        </div>
        <div
            @click="openEditor"
            class="bg-blue-400 hover:bg-blue-600 rounded-full w-8 h-8 float-right flex flex-row justify-center items-center">
            <img src="/assets/icons8-pencil-drawing-30.png" class="w-5 h-5" alt="modifier"/>
        </div>
        <img
            class="w-36 h-36 float-left mr-3"
            :src="star.profil_url"
            alt=""/>
        <div
            class="text-2xl pt-2 pb-2 text-center break-all"
        >{{ star.first_name }} {{ star.last_name }}
        </div>
        <div
            class="mt-2 text-justify whitespace-pre-line"
        >{{ star.description }}
        </div>
    </div>
    <StarModal
        v-if="editing"
        :star="star"
        @close="closeEditor"
    ></StarModal>
</template>

<script setup>
import axios from "axios";
import {ref} from "vue";
import StarModal from "./StarModal.vue";

const props = defineProps(['star'])
const emit = defineEmits(['updated', 'deleted'])

let editing = ref(false)

function openEditor() {
    editing.value = true
}

function closeEditor() {
    editing.value = false
}

// Remove the current star
function remove() {
    axios.delete('api/stars/' + props.star.id)
        .then(() => {
            emit('deleted')
        });
}
</script>

<style scoped>

</style>
