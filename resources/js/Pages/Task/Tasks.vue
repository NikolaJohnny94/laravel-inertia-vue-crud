<template>

    <Head title="Tasks Dashboard" />
    <AuthenticatedLayout>
        <h1 class="text-3xl text-center my-6 italic">Your tasks</h1>
        <!-- Add task button -->
        <div class="flex justify-end m-6">
            <Button class="!text-white" label="Add new task" raised @click="showCreateModal" />
        </div>
        <!-- Tasks table -->
        <DataTable :value="tasks" paginator removableSort showGridlines scrollable scrollDirection="horizontal"
            :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem ">
            <Column field="id" header="Id" sortable style="width: 25%"> </Column>
            <Column field="title" header="Title" sortable style="width: 25%"></Column>
            <Column field="description" header="Description" sortable style="width: 25%"></Column>
            <Column field="category" header="Category" sortable style="width: 25%"></Column>
            <Column field="finished" header="Completed" sortable style="width: 25%"></Column>
            <Column field="details" header="Details" style="width: 25%">
                <template #body="slotProps">
                    <Link :href="route('tasks.show', slotProps.data.id)">
                    <Button class="!text-white w-[80px]" label="Details" severity="success" raised /></Link>
                </template>
            </Column>
            <Column field="edit" header="Edit" style="width: 25%">
                <template #body="slotProps">
                    <Button class="!text-white w-[80px]" label="Edit" severity="info" raised @click="
                        showEditModal({
                            id: slotProps.data.id,
                            title: slotProps.data.title,
                            description: slotProps.data.description,
                            category: slotProps.data.category,
                            finished: slotProps.data.finished,
                        })
                        " />
                    <!-- Edit Modal -->
                    <!-- <EditTaskModal action="edit" v-model="visible" v-model:task="taskToUpdate" /> -->
                </template>
            </Column>
            <Column field="delete" header="Delete" style="width: 25%">
                <template #body="slotProps">
                    <Button label="Delete" class="!text-white w-[80px]" severity="danger" raised
                        @click="showDeleteModal(+slotProps.data.id)" />
                    <!-- Delete task Modal -->
                    <DeleteTaskModal v-model="visibleRemoveModal" v-model:taskId="taskIdToDelete" />
                </template>
            </Column>
        </DataTable>
        <!-- Add Modal -->
        <UniversalModal v-model:action="action" v-model="visible" v-model:task="taskToUpdate" />
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
// Inertia
import { Head, Link } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
// Layout and components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteTaskModal from "@/Components/Tasks/Modals/DeleteTaskModal.vue";
// import EditTaskModal from "@/Components/Tasks/Modals/EditTaskModal.vue";
import UniversalModal from "@/Components/Tasks/Modals/UniversalModal.vue";
// Types
import type { TaskSchema, Task } from "@/types";

// Type declarations
type ModalAction = "edit" | "create" | 'delete';

// Refs
const visible = ref(false);
const visibleRemoveModal = ref(false);
const action = ref("create" as ModalAction);
const taskToUpdate = ref({} as Task);
const taskIdToDelete = ref<number>()

//Props
defineProps<{
    tasks: TaskSchema[];
}>();

// Methods
const showEditModal = (task: Task) => {
    action.value = "edit";
    visible.value = true;
    taskToUpdate.value = task;
};

const showCreateModal = () => {
    action.value = "create";
    visible.value = true;
};

const showDeleteModal = (id: number) => {
    visibleRemoveModal.value = true
    taskIdToDelete.value = id;
}

//Watchers
// watch(taskToUpdate, (newVal) => (taskToUpdate.value = newVal));
// watch(taskIdToDelete, (newVal) => (taskIdToDelete.value = newVal));
</script>

<style scoped>
/* .p-datatable .p-paginator {
    background-color: #1a202c !important;
} */

/* background-color: #1a202c */
</style>
