<template>
    <template v-if="noTasksInDatabase">
        <div class="text-white text-3xl text-center italic mt-20 p-20 bg-gray-800 w-[50%] m-auto rounded-xl shadow-xl">
            You currently don't have any tasks.
        </div>
    </template>
    <template v-else>
        <div class="text-white text-3xl text-center italic mt-20 p-20 bg-gray-800 w-[50%] m-auto rounded-xl shadow-xl">
            There are no tasks that match term "{{ searchedTerm }}".
        </div>
    </template>
</template>

<script setup lang="ts">
// Props
defineProps<{
    noTasksInDatabase: boolean,
    searchedTerm: string
}>();
</script>
