<template>
    <div class="card flex justify-center">
        <Dialog v-model:visible="visible" modal :header="header" :style="{ width: '25rem' }">
            <span class="text-surface-500 dark:text-surface-400 block mb-8">{{ subHeader }}</span>
            <!-- Title -->
            <div class="flex items-center gap-4 mb-4">
                <label for="title" class="font-semibold w-24">Title</label>
                <InputText id="title" class="flex-auto" autocomplete="off" v-model="form.title" />
            </div>
            <!-- Description -->
            <div class="flex items-center gap-4 mb-8">
                <label for="description" class="font-semibold w-24">Description</label>
                <InputText id="description" class="flex-auto" autocomplete="off" v-model="form.description" />
            </div>
            <!-- Category -->
            <div class="flex items-center gap-4 mb-8">
                <label for="category" class="font-semibold w-24">Category</label>
                <Select id="category" v-model="selectedCategory" :options="categories" optionLabel="name"
                    placeholder="Select category" checkmark :highlightOnSelect="false"
                    class="w-full md:w-56 flex-auto" />
            </div>
            <!-- Completed -->
            <div class="flex items-center gap-4 mb-8">
                <label class="font-semibold w-24">Completed</label>
                <div class="flex items-center">
                    <RadioButton v-model="form.finished" inputId="completed" name="completed_task" :value="true" />
                    <label for="completed" class="ml-2">Yes</label>
                </div>
                <div class="flex items-center">
                    <RadioButton v-model="form.finished" inputId="not_completed" name="not_completed_task"
                        :value="false" />
                    <label for="not_completed" class="ml-2">No</label>
                </div>
            </div>
            <div class="flex justify-center gap-2">
                <Button class="w-[100px]" type="button" :label="buttonText" @click="submit"></Button>
                <Button class="w-[100px]" type="button" label="Cancel" severity="secondary"
                    @click="visible = false"></Button>
            </div>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
// Core
import { computed, onMounted, ref, watch } from 'vue'
// PrimeVue
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Select from 'primevue/select';
import RadioButton from 'primevue/radiobutton';
// Inertia.js
import { useForm } from "@inertiajs/vue3";
import { Task } from '@/types';

// Type declarations
type Category = { name: string; value: string }

//Models
const visible = defineModel();
const task = defineModel<Task>('task')
const action = defineModel('action')

//Refs
const selectedCategory = ref({} as Category);

// Computed 
const header = computed(() => action.value === 'edit' ? 'Edit task' : 'Add new task')
const subHeader = computed(() => action.value === 'edit' ? 'Update task' : 'Create new task')
const buttonText = computed(() => action.value === 'edit' ? 'Update' : 'Create')

// Data
const categories = ref([
    { name: 'Work', value: 'work' },
    { name: 'Personal', value: 'personal' },
    { name: 'Other', value: 'other' },
]);

const form = useForm({
    title: '',
    description: '',
    category: '',
    finished: false,
});

// Methods
const submit = () => {
    // Performing adequate action based on the action value
    if (action.value === 'edit' && task.value) form.put(`/tasks/${task.value.id}`)
    if (action.value === 'create') form.post('/tasks')

    // Resetting modal's visible value
    visible.value = false;
};

// Watchers
watch([task, action], () => {
    /**
     * Edit action
     * Setting title, description and finished
    */
    if (action.value === 'edit') {
        if (task.value) {
            form.title = task.value.title
            form.description = task.value.description
            form.finished = task.value.finished
        }
        // Setting category
        const preselectedCategory = categories.value.find(cat => cat.value === task.value?.category);

        if (preselectedCategory) {
            selectedCategory.value = preselectedCategory;
        }
    }
    /**
     * Create action
     * Setting reseting form to it's initial state
    */
    if (action.value === 'create') {
        form.title = ''
        form.description = ''
        form.category = ''
        form.finished = false
    }
})

watch(selectedCategory, () => form.category = selectedCategory.value.value)
</script>
