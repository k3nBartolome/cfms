import {
  createRouter,
  createWebHashHistory
} from "vue-router";
import store from "../store";
import AppLogin from "@/views/AppLogin";
import ContactUs from "@/views/ContactUs";
import AppUserLayout from "@/components/AppUserLayout";
import AppAdminLayout from "@/components/AppAdminLayout";
import AuthLayout from "@/components/AuthLayout";
import AppAdminDashboard from "@/views/Dashboard/AppAdminDashboard";
import UserManagement from "@/views/DashboardNavItems/Admin/UserManagement";
import SiteManagement from '@/views//Dashboard/AppSiteDashboard.vue';
import capacityFile from "@/views/DashboardNavItems/User/CapacityFile.vue";
import addCapacityFile from "@/views/DashboardNavItems/User/Capfile/AddCapfile.vue";
import ProgramManagement from '@/views/Dashboard/AppProgramDashboard.vue';
import pushbackCapacityFile from "@/views/DashboardNavItems/User/Capfile/PushedBackCapacityFile.vue";
import cancelCapacityFile from "@/views/DashboardNavItems/User/Capfile/CancelCapacityFile.vue";
import editCapFile from "@/views/DashboardNavItems/User/Capfile/EditCapfile.vue";
import powerBi from "@/views/DashboardNavItems/User/powerBi.vue";

const routes = [{
    path: "/",
    component: AppUserLayout,
    meta: { requiresAuth: true, requiresRole: "user" },
    children: [
      {
        path: "/capfile",
        name: "capacityFile",
        component: capacityFile,
      },
      {
        path: "/powerbi",
        name: "powerBi",
        component: powerBi,
      },
      {
        path: "/pushbackcapfile/:id",
        name: "pushbackCapacityFile",
        component: pushbackCapacityFile,
      },
      {
        path: "/cancelcapfile/:id",
        name: "cancelCapacityFile",
        component: cancelCapacityFile,
      },
      {
        path: "/editcapfile/:id",
        name: "editCapFile",
        component: editCapFile,
      },
      {
        path: "/addcapfile/:id",
        name: "addCapacityFile",
        component: addCapacityFile,
      },
      {
        path: "/site_management",
        name: "sitemanagement",
        component: SiteManagement,
      },
      {
        path: "/program_management",
        name: "programmanagement",
        component: ProgramManagement,
      },
    ],
  },
  {
    path: "/",
    component: AppAdminLayout,
    meta: {
      requiresAuth: true,
      requiresRole: "admin"
    },
    children: [{
        path: "/admin_dashboard",
        name: "adminDashboard",
        component: AppAdminDashboard,
      },
      {
        path: "/user_management",
        name: "usermanagement",
        component: UserManagement,
      },
      
    ],
  },
  {
    path: "/auth",
    name: "Auth",
    component: AuthLayout,
    meta: {
      isGuest: true
    },
    children: [{
        path: "/login",
        name: "login",
        component: AppLogin,
      },
      {
        path: "/contact",
        name: "contact",
        component: ContactUs,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    if (store.getters.isLoggedIn) {
      if (to.meta.requiresRole === store.getters.returnRole) {
        next();
      } else {
        next({
          query: {
            returnUrl: to.path
          }
        });
      }
    } else {
      next({
        name: "login"
      });
    }
  } else if (to.meta.isGuest && !store.getters.isLoggedIn) {
    next();
  } else {
    next();
  }
});

export default router;
