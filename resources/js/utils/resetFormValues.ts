import type { TaskForm, SelectedCategory, Category } from "@/types";

export const resetFormValues = (
    form: TaskForm,
    selectedCategory: SelectedCategory
) => {
    // Resetting field values
    form.title = "";
    form.description = "";
    selectedCategory.value = {} as Category;
    form.finished = false;
    // Clear errors
    form.clearErrors();
};
