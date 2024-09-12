<template>
    <div class="task-details">
        <!-- Head component with a dynamic title -->

        <Head :title="`Task Details: ${task.title}`" />
        <!-- Card component -->
        <Card>
            <!-- Custom card title -->
            <template #title>{{ task.title }}</template>

            <!-- Card content -->
            <template #content>
                <p class="m-0">Description: {{ task.description }}</p>
                <p class="m-0">Category: {{ task.category }}</p>
                <p class="m-0">Status: {{ task.finished ? 'Completed' : 'Pending' }}</p>
                <p class="m-0">Created at: {{ new Date(task.created_at).toLocaleDateString() }}</p>
                <p class="m-0">Last updated: {{ new Date(task.updated_at).toLocaleDateString() }}</p>
                <!-- Add any other relevant task properties here -->
            </template>
        </Card>
    </div>
</template>

<script setup lang="ts">
// Primevue
import Card from 'primevue/card';
// Types import 
import type { TaskSchema } from "@/types";

defineProps<{
    task: TaskSchema;
}>();
</script>

<style scoped></style>
