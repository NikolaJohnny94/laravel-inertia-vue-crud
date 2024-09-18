import type { InertiaForm } from "@inertiajs/vue3";

export type TaskForm = InertiaForm<{
    title: string;
    description: string;
    category: string;
    finished: boolean;
}>;
