<template>

    <Head title="Tasks Dashboard" />
    <AuthenticatedLayout>
        <h1 class="text-3xl text-center my-6 italic">My tasks
        </h1>
        <!-- Add task button -->
        <div class="flex justify-between m-6">
            <InputText type="text" v-model="searchQuery" placeholder="Search through tasks" />
            <Button class="!text-white" raised @click="showCreateModal" severity="success">
                <i class="pi pi-file-check"></i> Add new task
            </Button>
        </div>
        <!-- Tasks table -->
        <Table :searchQuery="searchQuery" :noTasksInDatabase="noTasksInDatabase" :tasks="filteredTasks"
            @showDeleteModal="showDeleteModal" @showEditModal="showEditModal" v-model:page="page"
            v-model:startIndex="startIndex" v-model:rowsPerPage="rowsPerPage" v-model:sortOrder="sortOrder"
            v-model:sortField="sortField" />
        <!-- Modal -->
        <Modal v-model:action="action" v-model="visible" v-model:task="taskToUpdate"
            v-model:taskIdToDelete="taskIdToDelete" :deletingFromDetailspage="false" />
        <!-- Toast Message -->
        <Toast />
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
// Core
import { ref, computed, watch, onMounted, watchEffect, onUpdated } from "vue";
// VueUse
import { useStorage } from "@vueuse/core";
// Inertia
import { Head, router, } from "@inertiajs/vue3";
// PrimeVue
import Button from "primevue/button";
import Toast from 'primevue/toast';
import InputText from 'primevue/inputtext'
// Layout and components
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Tasks/Modal.vue";
import Table from "@/Components/Tasks/Table/Table.vue";
// Composables
import { useGetSortFieldAndSortOrder } from "@/composables/useGetSortFieldAndSortOrder";
// Utils
import { setPageDataFromLocalStorage, setRowsPerPage, setSearchQuery, setSortFieldAndSortOrder } from "@/utils";
// Types 
import type { TaskSchema, Task, ModalAction } from "@/types";

//Props
const { tasks } = defineProps<{
    tasks: TaskSchema[];
}>();

// Refs
const visible = ref(false);
const searchQuery = ref<string>("");
const page = ref<number>(1)
const rowsPerPage = ref(5);
const startIndex = ref(0)
const action = ref("create" as ModalAction);
const taskToUpdate = ref({} as Task);
const taskIdToDelete = ref<number>()
const sortOrder = ref<number>()
const sortField = ref<string>()

// Data
const validRowsPerPageValues = [3, 5, 10, 20, 50];

// Composables
const deletedFromDetailsPage = useStorage('deletedFromDetailsPage', false)

const { sortField: sortFieldValue, sortOrder: sortOrderValue } = useGetSortFieldAndSortOrder()

// Computed
// Return filtered data based on title and description search
const filteredTasks = computed(() => {
    if (!searchQuery.value) { return tasks; }

    return tasks.filter(task =>
        task.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        task.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Check if 'rowsPerPage' value is in 'validRowsPerPageValues' array, if not 'rowsPerPage' values is set to 5
const checkAndSetRowsPerPage = computed(() => {
    if (!validRowsPerPageValues.includes(rowsPerPage.value)) {
        return rowsPerPage.value = 5;
    }
    return rowsPerPage.value
})

// Check if there are tasks in the database and display boolean value
const noTasksInDatabase = computed(() => tasks.length === 0 ? true : false)

//Return converted int sortOrder value to 'asc' (Ascending) and 'desc' (descending) based on the sortOrder value (1 and -1)
const getSortOrderValue = computed(() => {
    if (sortOrder.value === 1) return 'asc'
    if (sortOrder.value === -1) return 'desc'
})

// Get tasks
const getTasks = computed(() => tasks)

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

const updateUrlWithQueryValues = () => {
    const params = {
        page: page.value,
        rows: checkAndSetRowsPerPage.value,
        ...((searchQuery.value && tasks.length !== 0) && { search: searchQuery.value }),
        ...((sortOrder.value && tasks.length !== 0) && { sort: `${sortField.value}-${getSortOrderValue.value}` })
    };
    router.visit(route("tasks", params), { preserveState: true });
};

// Hooks
onMounted(() => {
    // Set rowsPerPage value
    setRowsPerPage(rowsPerPage)
    // Set page data (page, rowsPerPage, searchQuery, sortField, sortOrder, startIndex) if there is 'previousPage' value in localStorage
    setPageDataFromLocalStorage(page, rowsPerPage, searchQuery, sortField, sortOrder, startIndex, filteredTasks, deletedFromDetailsPage)
    //Set searchQuery value
    setSearchQuery(searchQuery)
    // Set sortField and sortOrder values
    setSortFieldAndSortOrder(sortField, sortOrder, sortFieldValue, sortOrderValue)
})

// Watchers
// Watching updateUrlWithQueryValues method
watchEffect(updateUrlWithQueryValues)
// Watching tasks length is equal '0' and set values to initial values 
watch(getTasks, (newValue) => {
    if (newValue.length === 0) {
        page.value = 1
        rowsPerPage.value = 5
        startIndex.value = 0
        searchQuery.value = ''
        sortField.value = undefined
        sortOrder.value = undefined
    }
})
</script>
