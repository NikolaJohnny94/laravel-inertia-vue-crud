<template>
    <div>
        <Paginator :rows="rowsPerPage" :first="startIndex" :totalRecords="tasksLength"
            :rowsPerPageOptions="[3, 5, 10, 20, 30, 50]">
            <template #start="slotProps">
                {{ $emit('setStartIndexRowsPerPageAndCurrentPage', {
                    startIdx: slotProps.state.first,
                    rowsPerPage: slotProps.state.rows,
                    pageNumber: slotProps.state.page + 1
                }) }}
                <span class="mr-2"><span class="font-bold">Page</span>: {{ slotProps.state.page + 1 }}</span>
                <span><span class="font-bold">Rows per page</span>: {{ slotProps.state.rows }}</span>
            </template>
        </Paginator>
    </div>
</template>

<script setup lang="ts">
// PrimeVue
import Paginator from "primevue/paginator";
// Type impots
import type { PaginationData } from "@/types";

// Props
defineProps<{
    startIndex: number | undefined,
    tasksLength: number,
    rowsPerPage: number | undefined
}>()

//Emits
defineEmits<{
    setStartIndexRowsPerPageAndCurrentPage: [data: PaginationData]
}>() 
</script>
