<template>
    <DataTable :value="tasks" paginator removableSort showGridlines scrollable scrollDirection="horizontal" :rows="5"
        :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem ">
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
                <Button class="!text-white w-[80px]" label="Edit" severity="info" raised @click="$emit('showEditModal', {
                    id: slotProps.data.id,
                    title: slotProps.data.title,
                    description: slotProps.data.description,
                    category: slotProps.data.category,
                    finished: slotProps.data.finished,
                })
                    " />
            </template>
        </Column>
        <Column field="delete" header="Delete" style="width: 25%">
            <template #body="slotProps">
                <Button label="Delete" class="!text-white w-[80px]" severity="danger" raised
                    @click="$emit('showDeleteModal', +slotProps.data.id)" />
            </template>
        </Column>
    </DataTable>
</template>

<script setup lang="ts">
// Inertia
import { Link } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
// Types import
import type { TaskSchema } from "@/types";

defineProps<{
    tasks: TaskSchema[]
}>()
</script>
