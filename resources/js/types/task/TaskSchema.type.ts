export type TaskSchema = {
    id: number;
    title: string;
    slug: string;
    description: string;
    category: "work" | "personal" | "other";
    finished: boolean;
    user_id: number;
    created_at: Date;
    updated_at: Date;
};
