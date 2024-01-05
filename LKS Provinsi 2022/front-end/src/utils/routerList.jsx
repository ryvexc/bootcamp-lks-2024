import { createBrowserRouter } from "react-router-dom";
import { GuestSkin } from "../skin/guest";
import { GuardSkin } from "../skin/guard";
import { Login } from "../component/pages/Login";
import { Dashboard } from "../component/pages/dashboard/Dashboard";
import { StoreConsultation } from "../component/pages/consultation/StoreConsultation";
import { VacinationSpot } from "../component/pages/vaccination-spot/VacinationSpot";
import { VacinationSpotDetail } from "../component/pages/vaccination-spot/VacinationSpotDetail";

const routes = createBrowserRouter([
  {
    path: "/login",
    element: <GuestSkin />,
    children: [
      {
        path: "/login",
        element: <Login />,
      },
    ],
  },
  {
    path: "/",
    element: <GuardSkin />,
    children: [
      {
        path: "/",
        element: <Dashboard />,
      },
    ],
  },
  {
    path: "/store-consultation",
    element: <GuardSkin />,
    children: [
      {
        path: "/store-consultation",
        element: <StoreConsultation />,
      },
    ],
  },
  // Vacination Spot
  {
    path: "/vacination-spot",
    element: <GuardSkin />,
    children: [
      {
        path: "/vacination-spot",
        element: <VacinationSpot />,
      },
    ],
  },
  {
    path: "/vacination-spot/detail/:id",
    element: <GuardSkin />,
    children: [
      {
        path: "/vacination-spot/detail/:id",
        element: <VacinationSpotDetail />,
      },
    ],
  },
]);

export default routes;
