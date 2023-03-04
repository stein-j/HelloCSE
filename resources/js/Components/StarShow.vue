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
    </div>
</template>

<script setup>
const props = defineProps(['star'])
</script>

<style scoped>

</style>
