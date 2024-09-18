<template>
    <template v-if="tasks.length > 0">
        <DataTable :value="paginatedTasks" removableSort showGridlines scrollable scrollDirection="horizontal"
            tableStyle="min-width: 50rem ">
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
                    <Link @click="setCurrentPage"
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
        <Paginator :rows="2" :first="startIndex" :totalRecords="tasks.length" :rowsPerPageOptions="[2, 5, 10, 20, 30]">
            <template #start="slotProps">
                {{
                    setStartIndexAndRowsPerPage(
                        slotProps.state.first,
                        slotProps.state.rows,
                        slotProps.state.page + 1
                    )
                }}
                <span class="mr-2"><span class="font-bold">Page</span>: {{ slotProps.state.page + 1 }}</span>
                <span><span class="font-bold">Rows per page</span>: {{ slotProps.state.rows }}</span>
            </template>
        </Paginator>
    </template>
    <template v-else>
        <div class="text-white text-3xl text-center italic mt-20 p-20 bg-gray-800 w-[50%] m-auto rounded-xl shadow-xl">
            You currently don't have any tasks.
        </div>
    </template>
</template>

<script setup lang="ts">
//Core
import { ref, computed, onMounted } from "vue";
// Inertia
import { Link, router } from "@inertiajs/vue3";
// Primevue
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Paginator from "primevue/paginator";
// Types import
import type { TaskSchema } from "@/types";


// Props
const { tasks } = defineProps<{
    tasks: TaskSchema[];
}>();

// Refs
const rowsPerPage = ref(5);
const startIndex = ref(0);

// Computed
const paginatedTasks = computed(() =>
    tasks.slice(startIndex.value, startIndex.value + rowsPerPage.value)
);

//Methods

// Update URL with current pageQuery
const updateUrlWithCurrentPageQuery = (page: number) => router.visit(route("tasks", { page }), { preserveState: true, });

// Set startIndex and rowsPerPage
const setStartIndexAndRowsPerPage = (
    startIdx: number,
    rowsSelected: number,
    page: number
) => {
    startIndex.value = startIdx;
    rowsPerPage.value = rowsSelected;
    // Update URL with current pageQuery
    updateUrlWithCurrentPageQuery(page);
};

// Set currentPage value in localStorage
const setCurrentPage = () => localStorage.setItem("currentPage", route().queryParams.page);

//Hooks
onMounted(() => {
    // Check if there is query param 'page' 
    if (route().queryParams.page) {
        const page = +route().queryParams.page;
        const totalPages = Math.ceil(tasks.length / rowsPerPage.value);

        // Handle if page is less then 1, greater then total number of pags and setStartIndex
        if (page < 1) {
            updateUrlWithCurrentPageQuery(1)
            startIndex.value = 0
        } else if (page > totalPages) {
            updateUrlWithCurrentPageQuery(totalPages)
            startIndex.value = (totalPages - 1) * rowsPerPage.value
        } else {
            startIndex.value = (page - 1) * rowsPerPage.value;
        }
    }

    // Otherwise set the default page query to 1
    router.visit(route("tasks", { page: 1 }), { preserveState: true });

    // Remove item currentPage from localStorage
    localStorage.removeItem("currentPage");
});
</script>
