const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["./chunks/DashboardList.lite-BL7qMxVc.js","./chunks/TheAppHeader-DwkuWF7I.js","./chunks/_plugin-vue_export-helper-mTbh_c-s.js","../css/main-monsterinsights-BlALUF99.css","./chunks/useSampleData-BiWaq8xR.js","./chunks/Icon-sXMuhVZk.js","../css/main-monsterinsights-DdCOUrGJ.css","./chunks/useFeatureGate-DmPZpq6t.js","../css/main-monsterinsights-tn0RQdqM.css","./chunks/DashboardCreate-Br1m1XpS.js","./chunks/useAuthGate-9uV7oSSd.js","./chunks/ReAuthModal-CvR62RjO.js","../css/main-monsterinsights-Du5DxmSn.css","./chunks/html2pdf-mm61NHHM.js","../css/main-monsterinsights-DWkQp-s6.css","../css/main-monsterinsights-CATPSyIj.css","../css/main-monsterinsights-CWJgQk98.css","./chunks/DashboardEdit-DpPncCYw.js","./chunks/DashboardView-BbCkTrLf.js","../css/main-monsterinsights-eUZh7hRe.css"])))=>i.map(i=>d[i]);
import { _ as _sfc_main$1, a as __vitePreload, c as createRouter, b as createWebHashHistory, s as setupPinia } from "./chunks/TheAppHeader-DwkuWF7I.js";
import { c as createElementBlock, a as createBaseVNode, b as createVNode, r as resolveComponent, o as openBlock, d as createApp } from "./chunks/_plugin-vue_export-helper-mTbh_c-s.js";
const _hoisted_1 = { class: "mi-custom-dashboard-app" };
const _hoisted_2 = { id: "monsterinsights-app" };
const _hoisted_3 = { class: "monsterinsights-dashboard-content" };
const _hoisted_4 = { class: "monsterinsights-container" };
const _sfc_main = {
  __name: "App",
  setup(__props) {
    return (_ctx, _cache) => {
      const _component_RouterView = resolveComponent("RouterView");
      return openBlock(), createElementBlock("div", _hoisted_1, [
        createBaseVNode("div", _hoisted_2, [
          createBaseVNode("div", _hoisted_3, [
            createVNode(_sfc_main$1),
            createBaseVNode("div", _hoisted_4, [
              createVNode(_component_RouterView)
            ])
          ])
        ])
      ]);
    };
  }
};
const DashboardList = () => __vitePreload(() => import("./chunks/DashboardList.lite-BL7qMxVc.js"), true ? __vite__mapDeps([0,1,2,3,4,5,6,7,8]) : void 0, import.meta.url);
const DashboardCreate = () => __vitePreload(() => import("./chunks/DashboardCreate-Br1m1XpS.js"), true ? __vite__mapDeps([9,1,2,3,10,5,6,7,11,12,13,14,15,4,8,16]) : void 0, import.meta.url);
const DashboardEdit = () => __vitePreload(() => import("./chunks/DashboardEdit-DpPncCYw.js"), true ? __vite__mapDeps([17,9,1,2,3,10,5,6,7,11,12,13,14,15,4,8,16]) : void 0, import.meta.url);
const DashboardView = () => __vitePreload(() => import("./chunks/DashboardView-BbCkTrLf.js"), true ? __vite__mapDeps([18,1,2,3,10,5,6,7,11,12,13,14,15,4,8]) : void 0, import.meta.url);
const routes = [
  {
    path: "/",
    redirect: "/dashboards"
  },
  {
    path: "/dashboards",
    name: "dashboard-list",
    component: DashboardList,
    meta: {
      title: "Custom Views",
      requiresAuth: true
    }
  },
  {
    path: "/dashboards/add",
    name: "dashboard-add",
    component: DashboardList,
    meta: {
      title: "Add Custom View",
      requiresAuth: true,
      requiresEdit: true,
      showTemplateSelector: true
    }
  },
  {
    path: "/dashboards/new",
    name: "dashboard-create",
    component: DashboardCreate,
    meta: {
      title: "Create View",
      requiresAuth: true,
      requiresEdit: true
    }
  },
  {
    path: "/dashboards/:id/edit",
    name: "dashboard-edit",
    component: DashboardEdit,
    props: true,
    meta: {
      title: "Edit View",
      requiresAuth: true,
      requiresEdit: true
    }
  },
  {
    path: "/dashboards/:id/view",
    name: "dashboard-view",
    component: DashboardView,
    props: true,
    meta: {
      title: "View",
      requiresAuth: true
    }
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/dashboards"
  }
];
function hasCustomViewsAccess() {
  return false;
}
const stylePromise = __vitePreload(() => Promise.resolve({}), true ? __vite__mapDeps([19]) : void 0, import.meta.url);
const router = createRouter({
  history: createWebHashHistory(),
  routes
});
router.beforeEach((to, _from, next) => {
  if (!hasCustomViewsAccess() && (to.name === "dashboard-list" || to.path === "/dashboards")) {
    next({ name: "dashboard-view", params: { id: "sample" } });
    return;
  }
  next();
});
const app = createApp(_sfc_main);
app.use(router);
setupPinia(app);
app.config.errorHandler = (err, _vm, info) => {
  console.error("Custom View Error:", err, info);
};
stylePromise.then(() => {
  app.mount("#monsterinsights-custom-dashboard-app");
});
