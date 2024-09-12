<template>

    <Head title="Tasks Dashboard" />
    <AuthenticatedLayout>
        <h1 class="text-3xl text-center my-6 italic">Your tasks</h1>
        <!-- Add task button -->
        <div class="flex justify-end m-6">
            <Button class="!text-white" label="Add new task" raised @click="showCreateModal" severity="success" />
        </div>
        <!-- Tasks table -->
        <Table :tasks="tasks" @showDeleteModal="showDeleteModal" @showEditModal="showEditModal" />
        <!-- Modal -->
        <Modal v-model:action="action" v-model="visible" v-model:task="taskToUpdate"
            v-model:taskIdToDelete="taskIdToDelete" />
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref } from "vue";
// Inertia
import { Head } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
// Layout and components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Tasks/Modal.vue";
import Table from "@/Components/Tasks/Table.vue";
// Types import
import type { TaskSchema, Task } from "@/types";

// Type declarations
type ModalAction = "edit" | "create" | 'delete';

// Refs
const visible = ref(false);
const action = ref("create" as ModalAction);
const taskToUpdate = ref({} as Task);
const taskIdToDelete = ref<number>()

//Props
defineProps<{
    tasks: TaskSchema[];
}>();

// Methods

const showCreateModal = () => {
    action.value = "create";
    visible.value = true;
};

const showEditModal = (task: Task) => {
    action.value = "edit";
    visible.value = true;
    taskToUpdate.value = task;
};

const showDeleteModal = (id: number) => {
    action.value = "delete";
    taskIdToDelete.value = id;
    visible.value = true;
}

</script>
