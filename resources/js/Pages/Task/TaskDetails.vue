<template>
    <div class="task-details">

        <Head :title="`Task Details for ${task.title}`" />
        <AuthenticatedLayout>
            <div class="m-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-4xl mb-6">{{ task.title }}</div>
                        <p class="m-0 py-1 text-2xl">Description: {{ task.description }}</p>
                        <p class="m-0 py-1 text-2xl">Category: {{ task.category }}</p>
                        <p class="m-0 py-1 text-2xl">Status: {{ task.finished ? 'Completed' : 'Not Completed' }}</p>
                        <p class="m-0 py-1 text-2xl">Created at: {{ formattedDate(task.created_at) }}
                        </p>
                        <p class="m-0 py-1 text-2xl">Last updated: {{ formattedDate(task.updated_at) }}
                        </p>
                    </div>
                    <div>
                        <Button class="!text-white w-[110px] mr-8  !p-3 flex justify-center items-center"
                            severity="success" @click="showEditModal"> <i class="pi pi-pencil"></i>Update</Button>
                        <Button class="!text-white w-[110px] mr-8 mt-8 !p-3 flex justify-center items-center"
                            severity="danger" @click="showDeleteModal"> <i class="pi pi-trash"></i>Delete</Button>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <Modal v-model:action="action" v-model="visible" v-model:task="taskToUpdate"
                v-model:taskIdToDelete="taskIdToDelete" :deletingFromDetailspage="true" />
            <Link :href="route('tasks', { page: previousPageData.page })"
                class="w-[100px] !text-white mt-3 ml-6 !bg-blue-400 p-3 rounded-md flex justify-center items-center">
            <i class="pi pi-arrow-left mr-1"></i>Back
            </Link>
            <!-- Toast Message -->
            <Toast />
        </AuthenticatedLayout>
    </div>
</template>

<script setup lang="ts">
//Core
import { onUpdated, ref } from "vue";
// VueUse
import { useStorage } from '@vueuse/core'
// Inertia.js
import { Head, Link, router } from "@inertiajs/vue3";
// PrimeVue
import Button from 'primevue/button';
import Toast from 'primevue/toast';
// Layout and components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Tasks/Modal.vue";
// Types  
import type { TaskSchema, ModalAction, Task } from "@/types";

//Props
const { task } = defineProps<{
    task: TaskSchema
}>();

// Refs
const visible = ref(false);
const action = ref("edit" as ModalAction);
const taskIdToDelete = ref<number>()
const taskToUpdate = ref({} as Task);
const hasRunOnce = ref(false);

// Composables
const previousPageData = useStorage('previousPageData', { page: 1, rowsPerPage: 5, })

// Methods
const showEditModal = () => {
    action.value = "edit";
    visible.value = true;
    // Setting taskToUpdate value
    taskToUpdate.value.id = task.id;
    taskToUpdate.value.title = task.title;
    taskToUpdate.value.description = task.description;
    taskToUpdate.value.category = task.category;
    taskToUpdate.value.finished = task.finished;
    // Set hasRunOnce value to false
    hasRunOnce.value = false
};

const showDeleteModal = () => {
    action.value = "delete";
    visible.value = true;
    //Setting taskIdToDelete
    taskIdToDelete.value = task.id
}

// Convertting a date to a string by using the current or specified locale.
const formattedDate = (date: Date) => new Date(date).toLocaleDateString()

// Hooks
onUpdated(() => {
    if (!hasRunOnce.value) router.visit(route('tasks.show', { id: task.id, slug: task.slug }), { preserveState: true });
    hasRunOnce.value = true
})
</script>
