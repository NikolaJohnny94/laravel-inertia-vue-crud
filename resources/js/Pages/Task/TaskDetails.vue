<template>

    <Head title="Tasks Details" />
    <div>
        {{ task.title }}
    </div>
</template>

<script setup lang="ts">
import type { Task } from "@/types";

defineProps<{
    task: Task;
}>();
</script>

<style scoped></style>
