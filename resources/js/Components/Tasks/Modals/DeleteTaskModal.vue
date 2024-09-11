<template>
    <div class="card flex justify-center">
        <Dialog v-model:visible="visibleRemoveModal" modal header="Edit Profile" :style="{ width: '25rem' }">
            <span class="text-surface-500 dark:text-surface-400 block mb-8">Are you sure you want to delete this
                task?</span>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visibleRemoveModal = false"></Button>
                <Button type="button" severity="danger" label="Delete" @click="deleteTask"></Button>
            </div>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
import Dialog from "primevue/dialog";
import Button from "primevue/button";

import { useForm } from "@inertiajs/vue3";

const visibleRemoveModal = defineModel();
const taskId = defineModel('taskId')

const form = useForm({});

const deleteTask = () => {
    form.delete(`tasks/${taskId.value}`);
    visibleRemoveModal.value = false;
};
</script>
