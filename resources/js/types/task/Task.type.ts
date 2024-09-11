import type { TaskSchema } from "./TaskSchema.type";

export type Task = Pick<
    TaskSchema,
    "id" | "title" | "description" | "category" | "finished"
>;
