import { BrowserRouter, Route, Routes } from "react-router";
import { env } from "./configs/env.ts";
import { page_routes } from "./utils/routes/page_routes.ts";
import { lazy } from "react";
import SuspenseOutlet from "./components/SuspenseOutlet/index.tsx";

const AuthPageLayout = lazy(() => import("@/layouts/AuthPageLayout/index.tsx"));
const DashboardLayout = lazy(
  () => import("@/layouts/DashboardLayout/index.tsx"),
);
const DeleteProvider = lazy(() => import("./contexts/DeleteProvider.tsx"));
const AuthPersistLayout = lazy(
  () => import("@/layouts/AuthPermittedLayout/AuthPersistLayout.tsx"),
);
const GuestLayout = lazy(
  () => import("@/layouts/AuthPermittedLayout/GuestLayout.tsx"),
);
const ProtectedLayout = lazy(
  () => import("@/layouts/AuthPermittedLayout/ProtectedLayout.tsx"),
);

const LoginWithPhone = lazy(
  () => import("@/pages/Auth/LoginWithPhone/index.tsx"),
);
const LoginWithPhonePassword = lazy(
  () => import("@/pages/Auth/LoginWithPhonePassword/index.tsx"),
);
const LoginWithEmail = lazy(
  () => import("@/pages/Auth/LoginWithEmail/index.tsx"),
);
const ResetWithEmail = lazy(
  () => import("@/pages/Auth/ResetWithEmail/index.tsx"),
);
const ResetWithPhone = lazy(
  () => import("@/pages/Auth/ResetWithPhone/index.tsx"),
);
const Register = lazy(() => import("@/pages/Auth/Register/index.tsx"));
const PageNotFound = lazy(() => import("@/pages/PageNotFound/index.tsx"));
const Dashboard = lazy(() => import("@/pages/Dashboard/index.tsx"));
const Charge = lazy(() => import("@/pages/Charge/index.tsx"));

function App() {
  return (
    <BrowserRouter basename={env.BASE_PREFIX}>
      <Routes>
        <Route element={<SuspenseOutlet />}>
          <Route element={<AuthPersistLayout />}>
            <Route element={<ProtectedLayout />}>
              <Route element={<DeleteProvider />}>
                <Route element={<DashboardLayout />}>
                  <Route
                    path={page_routes.dashboard.link}
                    element={<Dashboard />}
                  />
                  <Route path={page_routes.charges.link} element={<Charge />} />
                </Route>
              </Route>
            </Route>
            <Route element={<GuestLayout />}>
              <Route element={<AuthPageLayout />}>
                <Route
                  path={page_routes.login_with_phone.link}
                  element={<LoginWithPhone />}
                />
                <Route
                  path={page_routes.login_with_phone_password.link}
                  element={<LoginWithPhonePassword />}
                />
                <Route
                  path={page_routes.login_with_email.link}
                  element={<LoginWithEmail />}
                />
                <Route
                  path={page_routes.reset_with_email.link}
                  element={<ResetWithEmail />}
                />
                <Route
                  path={page_routes.reset_with_phone.link}
                  element={<ResetWithPhone />}
                />
                <Route path={page_routes.sign_up.link} element={<Register />} />
              </Route>
            </Route>
          </Route>
          <Route path="*" element={<PageNotFound />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
