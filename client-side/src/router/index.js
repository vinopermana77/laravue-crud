import { createRouter, createWebHistory } from "vue-router";
import Index from "../views/employee/Index.vue";
import Create from "../views/employee/Create.vue";
import Edit from "../views/employee/Edit.vue";

const router = createRouter({
 history: createWebHistory(import.meta.env.BASE_URL),
 routes: [
  {
   path: "/",
   name: "employee.index",
   component: Index,
  },
  {
   path: "/create",
   name: "employee.create",
   component: Create,
  },
  {
   path: "/edit/:id",
   name: "employee.edit",
   component: Edit,
  },
 ],
});

export default router;
