import { ref } from "vue";

export const useGetSortFieldAndSortOrder = () => {
    const sortField = ref<string>();
    const sortOrder = ref<number>();

    if (route().queryParams.sort) {
        // Setting sortField value
        sortField.value = route().queryParams.sort.split("-")[0];
        // Setting sortOrder value
        if (route().queryParams.sort.split("-")[1] === "asc") {
            sortOrder.value = 1;
        } else if (route().queryParams.sort.split("-")[1] === "desc") {
            sortOrder.value = -1;
        } else {
            sortOrder.value = undefined;
            sortField.value = undefined;
        }
    }

    return { sortField, sortOrder };
};
