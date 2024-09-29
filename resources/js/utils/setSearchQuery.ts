import type { Ref } from "vue";

export const setSearchQuery = (searchQuery: Ref<string, string>) => {
    // If there is query param 'search' then set it as searchQuery value
    if (route().queryParams.search) {
        searchQuery.value = route().queryParams.search;
    }
};
