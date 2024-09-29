import type { Ref } from "vue";

export const setSortFieldAndSortOrder = (
    sortField: Ref<string | undefined, string | undefined>,
    sortOrder: Ref<number | undefined, number | undefined>,
    sortFieldValue: Ref<string | undefined, string | undefined>,
    sortOrderValue: Ref<number | undefined, number | undefined>
) => {
    // If there is query param 'sort' then set it sortField and sortOrder values
    if (route().queryParams.sort) {
        sortField.value = sortFieldValue.value;
        sortOrder.value = sortOrderValue.value;
    }
};
