<template>
    <div class="text-center mt-5 text-4xl">
        <p>Profile browser</p>
    </div>
    <div>
        <div class="flex h-96 m-5 border-2 border-solid">
            <div class="flex-none w-56 overflow-y-auto">
                <!-- StarList of star names -->
                <div
                    class="pl-2"
                    :class="{
                        'bg-gray-100 hover:bg-gray-200' : star.id !== selected_star?.id
                    }"
                    v-for="star in stars" @click="selectStar(star.id)"
                >
                    <p
                        class="font-medium text-medium p-1 text-left truncate"
                    > {{ star.first_name }} {{ star.last_name }}
                    </p>
                </div>
            </div>

            <div
                class="overflow-y-auto p-2"
            >
                Current selected star : {{ selected_star?.id }}
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

// The list of stars to display
let stars = ref([])

// The current star in detail
let selected_star = ref(null)

function selectStar(id) {
    selected_star.value = stars.value[stars.value.findIndex(star => star.id === id)]
}

function freshList() {
    axios.get('/api/stars').then(res => {
        stars.value = res.data.data;
    });
}

onMounted(() => freshList())
</script>

<style scoped>

</style>
