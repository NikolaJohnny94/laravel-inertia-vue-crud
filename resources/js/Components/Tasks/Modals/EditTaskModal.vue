<template>
    <div class="card flex justify-center">
        <Dialog v-model:visible="visibleEdit" modal header="Edit task" :style="{ width: '25rem' }">
            <span class="text-surface-500 dark:text-surface-400 block mb-8">Update task</span>
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
                <Button class="w-[100px]" type="button" label="Create" @click="editTask"></Button>
                <Button class="w-[100px]" type="button" label="Cancel" severity="secondary"
                    @click="visibleEdit = false"></Button>
            </div>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
// Core
import { ref, watch } from 'vue'
// PrimeVue
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Select from 'primevue/select';
import RadioButton from 'primevue/radiobutton';
// Inertia.js
import { useForm } from "@inertiajs/vue3";

// Type declarations
type Category = { name: string; value: string }

//Models
const visibleEdit = defineModel();
const task: any = defineModel('task')

//Refs
const selectedCategory = ref({} as Category);

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
const editTask = () => {
    form.put(`/tasks/${task.value.id}`)
    visibleEdit.value = false;
    console.log(form.title, form.description, form.category, form.finished);
};

// Watchers
watch(task, () => {
    // Setting title, description and finished
    form.title = task.value.title
    form.description = task.value.description
    form.finished = task.value.finished

    //Setting category
    const preselectedCategory = categories.value.find(cat => cat.value === task.value.category);
    if (preselectedCategory) selectedCategory.value = preselectedCategory;
})

watch(selectedCategory, () => {
    form.category = selectedCategory.value.value
})
</script>
