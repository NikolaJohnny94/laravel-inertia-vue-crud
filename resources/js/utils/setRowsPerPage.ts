import type { Ref } from "vue";

export const setRowsPerPage = (rowsPerPage: Ref<number, number>) => {
    if (route().queryParams.rows) {
        rowsPerPage.value = +route().queryParams.rows;
    }
};
