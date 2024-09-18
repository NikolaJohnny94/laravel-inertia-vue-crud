<template>
    <div class="card flex justify-center">
        <Dialog v-model:visible="visible" modal :header="header" :style="{ width: '25rem' }">
            <span class="text-surface-500 dark:text-surface-400 block mb-8">{{ subHeader }}</span>
            <form @submit.prevent="submit">
                <template v-if="action !== 'delete'">
                    <!-- Title -->
                    <div class="flex items-center gap-4 my-4">
                        <label for="title" class="font-semibold w-24">Title</label>
                        <InputText id="title" class="flex-auto" autocomplete="off" v-model="form.title" />
                    </div>
                    <Message v-if="form.errors.title" severity="error">{{ form.errors.title }}</Message>
                    <!-- Description -->
                    <div class="flex items-center gap-4 my-8">
                        <label for="description" class="font-semibold w-24">Description</label>
                        <InputText id="description" class="flex-auto" autocomplete="off" v-model="form.description" />
                    </div>
                    <Message v-if="form.errors.description" severity="error">{{ form.errors.description }}</Message>
                    <!-- Category -->
                    <div class="flex items-center gap-4 my-8">
                        <label for="category" class="font-semibold w-24">Category</label>
                        <Select id="category" v-model="selectedCategory" :options="categories" optionLabel="name"
                            placeholder="Select category" checkmark :highlightOnSelect="false"
                            class="w-full md:w-56 flex-auto" />
                    </div>
                    <Message v-if="form.errors.category" severity="error">{{ form.errors.category }}</Message>
                    <!-- Completed -->
                    <div class="flex items-center gap-4 my-8">
                        <label class="font-semibold w-24">Completed</label>
                        <div class="flex items-center">
                            <RadioButton v-model="form.finished" inputId="completed" name="completed_task"
                                :value="true" />
                            <label for="completed" class="ml-2">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <RadioButton v-model="form.finished" inputId="not_completed" name="not_completed_task"
                                :value="false" />
                            <label for="not_completed" class="ml-2">No</label>
                        </div>
                    </div>
                </template>
                <div class="flex justify-center gap-2">
                    <Button class="w-[100px] !text-white" type="submit" :label="buttonText"
                        :severity="buttonColor"></Button>
                    <Button class="w-[100px]" type="button" label="Cancel" severity="secondary"
                        @click="visible = false"></Button>
                </div>
            </form>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
// Core
import { computed, ref, watch } from 'vue'
// PrimeVue
import { useToast } from "primevue/usetoast";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Select from 'primevue/select';
import RadioButton from 'primevue/radiobutton';
import Message from 'primevue/message';
// Inertia.js
import { router, useForm } from "@inertiajs/vue3";
// Utils
import { resetFormValues } from '@/utils';
// Types
import type { Task, Category, ModalAction } from '@/types';

// Services
const toast = useToast();

// Props
const { deletingFromDetailspage } = defineProps<{
    deletingFromDetailspage: boolean
}>()


//Models
const visible = defineModel();
const task = defineModel<Task>('task')
const action = defineModel('action')
const taskIdToDelete = defineModel('taskIdToDelete')

//Refs
const selectedCategory = ref({} as Category);
const categories = ref([
    { name: 'Work', value: 'work' },
    { name: 'Personal', value: 'personal' },
    { name: 'Other', value: 'other' },
]);

// Computed 
const header = computed(() => action.value === 'edit' ? 'Edit task' : action.value === 'create' ? 'Add new task task' : 'Delete')
const subHeader = computed(() => action.value === 'edit' ? 'Update task' : action.value === 'create' ? 'Create new task' : 'Are you sure you want to delete this task?')
const buttonText = computed(() => action.value === 'edit' ? 'Update' : action.value === 'create' ? 'Create' : 'Delete')
const buttonColor = computed(() => (action.value === 'edit' || action.value === 'create') ? 'success' : 'danger')

// Data
const form = useForm({
    title: '',
    description: '',
    category: '',
    finished: false,
});

// Methods

// Submit method performing adequate action based on the passed action value to the modal
const submit = () => {
    // Create
    if (action.value === 'create') {
        form.post('/tasks', {
            onSuccess: () => {
                // Calling showToast method with 'create' action value
                showToast('create')
                // Resetting form to it's initial value
                resetFormValues(form, selectedCategory)
                // Setting modal visible to false
                visible.value = false
            }
        })
    }
    // Edit
    if (action.value === 'edit' && task.value) {
        form.put(`/tasks/${task.value.id}`, {
            onSuccess: () => {
                // Calling showToast method with 'edit' action value
                showToast('edit')
                // Setting modal visible to false
                visible.value = false
            }
        })
    }
    // Delete
    if (action.value === 'delete') {
        // If delete action is performed from details page navigate to tasks page and after one second perform delete aciton
        if (deletingFromDetailspage) {
            router.visit(route('tasks'))

            setTimeout(() => {
                form.delete(`/tasks/${taskIdToDelete.value}`, {
                    onSuccess: () => {
                        // Calling showToast method with 'delete' action value
                        showToast('delete')
                        visible.value = false
                    }
                });
            }, 1000)
        } else {
            // If delete action is performed on tasks page then there is no need for setTimer 
            form.delete(`/tasks/${taskIdToDelete.value}`, {
                onSuccess: () => {
                    // Calling showToast method with 'delete' action value
                    showToast('delete')
                    visible.value = false
                }
            });
        }
    }
};

// Show adequate toast based on the action performed
function showToast(action: ModalAction) {
    switch (action) {
        case 'create':
            toast.add({ severity: 'success', summary: 'New task created', detail: 'Task successfully created!', life: 3000 });
            break;
        case 'edit':
            toast.add({ severity: 'info', summary: 'Task updated', detail: 'Task successfully updated!', life: 3000 });
            break;
        case 'delete':
            toast.add({ severity: 'error', summary: 'Task deleted', detail: 'Task successfully deleted!', life: 3000 });
            break;
    }
}

// Watchers

//Setting selectedCategory value
watch(selectedCategory, () => form.category = selectedCategory.value.value)

// Handling form values based on adequate action
watch(visible, () => {

    // If action is 'Create' than resete form values
    if (action.value === 'create') resetFormValues(form, selectedCategory)

    // If action is 'Edit' than set title, description and finished

    if (action.value === 'edit') {
        if (task.value) {
            form.title = task.value.title
            form.description = task.value.description
            form.finished = task.value.finished
        }

        // Setting category
        const preselectedCategory = categories.value.find(category => category.value === task.value?.category);

        if (preselectedCategory) selectedCategory.value = preselectedCategory;
    }
})
</script>
