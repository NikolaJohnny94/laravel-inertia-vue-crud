//Core
import type { Ref, ComputedRef } from "vue";
// VueUse
import type { RemovableRef } from "@vueuse/core";
// Custom
import type { TaskSchema } from "@/types";

export const setPageDataFromLocalStorage = (
    page: Ref<number, number>,
    rowsPerPage: Ref<number, number>,
    searchQuery: Ref<string, string>,
    sortField: Ref<string | undefined, string | undefined>,
    sortOrder: Ref<number | undefined, number | undefined>,
    startIndex: Ref<number>,
    filteredTasks: ComputedRef<TaskSchema[]>,
    deletedFromDetailsPage: RemovableRef<boolean>
) => {
    if (localStorage.getItem("previousPageData")) {
        setTimeout(
            () => {
                const previousPageData = JSON.parse(
                    localStorage.getItem("previousPageData") as string
                );
                // Populating page, rowsPerPage, searchQuery, sortField and sortOrder value with data from previousPageData
                page.value = previousPageData.page;
                rowsPerPage.value = previousPageData.rowsPerPage;
                searchQuery.value = previousPageData.searchQuery;
                sortField.value = previousPageData.sortField;
                sortOrder.value = previousPageData.sortOrder;
                // Setting the startIndex
                startIndex.value = (page.value - 1) * rowsPerPage.value;
                // Remove 'previousPageData' and 'deletedFromDetailsPage' from localStorage
                localStorage.removeItem("previousPageData");
                localStorage.removeItem("deletedFromDetailsPage");
            },
            deletedFromDetailsPage.value ? 500 : 0
        );
    } else if (route().queryParams.page) {
        const currentPage = +route().queryParams.page;
        const totalPages = Math.ceil(
            filteredTasks.value.length / rowsPerPage.value
        );
        if (currentPage < 1) {
            page.value = 1;
            startIndex.value = 0;
        } else if (totalPages > 0 && currentPage > totalPages) {
            startIndex.value = (totalPages - 1) * rowsPerPage.value;
        } else {
            startIndex.value = (currentPage - 1) * rowsPerPage.value;
        }
    }
};
