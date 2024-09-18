<template>

    <Head title="Tasks Dashboard" />
    <AuthenticatedLayout>
        <h1 class="text-3xl text-center my-6 italic">My tasks
        </h1>
        <!-- Add task button -->
        <div class="flex justify-end m-6">
            <Button class="!text-white" raised @click="showCreateModal" severity="success">
                <i class="pi pi-file-check"></i> Add new task
            </Button>
        </div>
        <!-- Tasks table -->
        <Table :tasks="tasks" @showDeleteModal="showDeleteModal" @showEditModal="showEditModal" />
        <!-- Modal -->
        <Modal v-model:action="action" v-model="visible" v-model:task="taskToUpdate"
            v-model:taskIdToDelete="taskIdToDelete" :deletingFromDetailspage="false" />
        <!-- Toast Message -->
        <Toast />
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
// Core
import { ref } from "vue";
// Inertia
import { Head } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
import Toast from 'primevue/toast';
// Layout and components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Tasks/Modal.vue";
import Table from "@/Components/Tasks/Table.vue";
// Types 
import type { TaskSchema, Task, ModalAction } from "@/types";

//Props
defineProps<{
    tasks: TaskSchema[];
}>();

// Refs
const visible = ref(false);
const action = ref("create" as ModalAction);
const taskToUpdate = ref({} as Task);
const taskIdToDelete = ref<number>()

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
