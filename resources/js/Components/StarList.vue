<template>
    <div class="text-center mt-5 text-4xl">
        <p>Profile browser</p>
    </div>
    <div>
        <div class="flex m-5 border-2 border-solid h-96">
            <div
                class="flex-none relative overflow-y-auto border-solid"
                :class="{
                    'w-56 border-r-2' : !isMobile,
                    'w-full' : isMobile,
                }"
            >
                <!-- Search star input -->
                <input
                    class="p-2 mb-1 w-full border-solid border-b-2"
                    type="text"
                    v-model="search"
                    placeholder="Rechercher"
                />
                <div class="text-center m-2" v-if="search&&!filteredStars().length">
                    Aucun résultat
                </div>
                <!-- StarList of star names -->
                <div
                    class="pl-2"
                    v-for="star in filteredStars()"
                >
                    <p
                        @click="selectStar(star.id)"
                        class="font-medium text-medium p-1 text-left truncate"
                        :class="{
                        'bg-gray-100 hover:bg-gray-200' : star.id !== selected_star?.id
                    }"

                    > {{ star.first_name }} {{ star.last_name }}
                    </p>
                    <!-- Display star details for mobile windows-->
                    <div
                        v-if="selected_star?.id === star.id && isMobile"
                        class=""
                    >
                        <start-show
                            @deleted="starDeleted()"
                            @updated="freshList()"
                            :star="selected_star"
                        />
                    </div>
                </div>

                <!-- Add new item button and modal -->
                <div class="sticky bottom-2 w-full">
                    <div
                        @click="openCreateStarModal"
                        class="m-5 p-2 bg-blue-400 rounded-full text-center cursor-pointer">
                        Ajouter
                    </div>
                    <star-modal
                        v-if="create_new_star"
                        creating
                        @created="freshList"
                        @close="closeCreateStarModal"
                    />

                </div>
            </div>
            <!-- Display star details for non mobile windows -->
            <div
                v-if="!isMobile"
                class="overflow-y-auto p-2 w-full"
            >
                <start-show
                    @deleted="starDeleted()"
                    @updated="freshList()"
                    v-if="selected_star"
                    :star="selected_star"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import StartShow from "./StarShow.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import StarModal from "./StarModal.vue";

// The list of stars to display
let stars = ref([])

// The current star in detail
let selected_star = ref(null)

// Define if the modal to create a new star should be displayed
let create_new_star = ref(false)

// Filter data through search
let search = ref('')

function selectStar(id) {
    // We will update the current selected star with the
    // given id, if the given id is the same as the
    // current star we will unselect it
    selected_star.value?.id === id
        ? clearSelection()
        : selected_star.value = stars.value[stars.value.findIndex(star => star.id === id)]
}

function clearSelection() {
    selected_star.value = null
}

// handle the event when a star is deleted
function starDeleted() {
    clearSelection()
    freshList()
}

function freshList() {
    axios.get('/api/stars').then(res => {
        stars.value = res.data.data.reverse();
    });
}

// Return the list of stars filtered by search input
function filteredStars() {
    return stars.value.filter((star) =>
        (star.first_name + ' ' + star.last_name)
            .toLowerCase()
            .includes(search.value.toLowerCase())
    );
}

let isMobile = ref(false)

function updateIsMobile() {
    isMobile.value = window.innerWidth <= 760
}

function openCreateStarModal() {
    create_new_star.value = true
}

function closeCreateStarModal() {
    create_new_star.value = false
}

onMounted(() => {
    freshList()
    updateIsMobile()
    window.addEventListener("resize", () => {
        updateIsMobile()
    });
})
</script>

<style scoped>

</style>
