<template>
    <template v-if="tasks.length > 0">
        <DataTable :value="paginatedTasks" removableSort showGridlines scrollable scrollDirection="horizontal"
            tableStyle="min-width: 50rem" v-model:sort-field="sortField" v-model:sort-order="sortOrder">
            <Column field="id" header="Id" sortable style="width: 25%"> </Column>
            <Column field="title" header="Title" sortable style="width: 25%"></Column>
            <Column field="description" header="Description" sortable style="width: 25%"></Column>
            <Column field="category" header="Category" sortable style="width: 25%"></Column>
            <Column field="finished" header="Completed" sortable style="width: 25%">
                <template #body="slotProps">
                    <template v-if="slotProps.data.finished">
                        <i
                            class="pi pi-check flex justify-center items-center text-white bg-green-500 w-[35px] h-[35px] m-auto p-1 rounded-full"></i>
                    </template>
                    <template v-else>
                        <i
                            class="pi pi-times flex justify-center items-center text-white bg-red-500 w-[35px] h-[35px] m-auto p-1 rounded-full"></i>
                    </template>
                </template>
            </Column>
            <Column field="details" header="Details" style="width: 25%">
                <template #body="slotProps">
                    <Link @click="setPreviousPageData"
                        class="!text-white w-[100px] bg-green-500 p-2 rounded-md flex items-center justify-center"
                        :href="route('tasks.show', { id: slotProps.data.id, slug: slotProps.data.slug })
                            ">
                    <i class="pi pi-info-circle mr-1"></i> Details</Link>
                </template>
            </Column>
            <Column field="edit" header="Edit" style="width: 25%">
                <template #body="slotProps">
                    <Button class="!text-white w-[100px] flex items-center justify-center" label="Edit" severity="info"
                        raised @click="
                            $emit('showEditModal', {
                                id: slotProps.data.id,
                                title: slotProps.data.title,
                                description: slotProps.data.description,
                                category: slotProps.data.category,
                                finished: slotProps.data.finished,
                            })
                            ">
                        <i class="pi pi-pencil"></i> Edit
                    </Button>
                </template>
            </Column>
            <Column field="delete" header="Delete" style="width: 25%">
                <template #body="slotProps">
                    <Button label="Delete" class="!text-white w-[100px] flex items-center justify-center"
                        severity="danger" raised @click="$emit('showDeleteModal', +slotProps.data.id)">
                        <i class="pi pi-trash"></i> Delete</Button>
                </template>
            </Column>
        </DataTable>
        <Pagination :rowsPerPage='rowsPerPage' :startIndex="startIndex" :tasksLength="tasks.length"
            @setStartIndexRowsPerPageAndCurrentPage="setStartIndexRowsPerPageAndCurrentPage" />
    </template>
    <template v-else>
        <NoTasksMessage :noTasksInDatabase="noTasksInDatabase" :searchedTerm="route().queryParams.search" />
    </template>
</template>

<script setup lang="ts">
//Core
import { computed } from "vue";
// Inertia
import { Link } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
// Components
import Pagination from "./Partials/Pagination.vue";
import NoTasksMessage from "../NoTasksMessage.vue";
// Types import
import type { Task, TaskSchema, PaginationData } from "@/types";

// Props
const { tasks, searchQuery } = defineProps<{
    tasks: TaskSchema[],
    noTasksInDatabase: boolean,
    searchQuery: string
}>();

// Emits
defineEmits<{
    showEditModal: [task: Task],
    showDeleteModal: [id: number]
}>()

// Models
const page = defineModel<number>('page')
const startIndex = defineModel<number>('startIndex')
const rowsPerPage = defineModel<number>('rowsPerPage')
const sortOrder = defineModel('sortOrder')
const sortField = defineModel('sortField')

// Computed
const paginatedTasks = computed(() => {
    if (startIndex.value !== undefined && rowsPerPage.value !== undefined) {
        return tasks.slice(startIndex.value, startIndex.value + rowsPerPage.value)
    }
});

//Methods

// Set startIndex, rowsPerPage and currentPage
const setStartIndexRowsPerPageAndCurrentPage = (data: PaginationData) => {
    startIndex.value = data.startIdx;
    rowsPerPage.value = data.rowsPerPage;
    page.value = data.pageNumber
};

// Set previousPageData value in localStorage
const setPreviousPageData = () => {
    localStorage.setItem("previousPageData", JSON.stringify({
        page: page.value,
        rowsPerPage: rowsPerPage.value,
        searchQuery,
        sortField: sortField.value,
        sortOrder: sortOrder.value
    }))
};

</script>
