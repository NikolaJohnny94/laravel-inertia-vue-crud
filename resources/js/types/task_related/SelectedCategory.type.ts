import type { Ref } from "vue";
import type { Category } from "./Category.type";

export type SelectedCategory = Ref<
    {
        name: string;
        value: string;
    },
    | Category
    | {
          name: string;
          value: string;
      }
>;
