import { createBrowserRouter } from "react-router-dom";
import Login from "./pages/public/Login";

const Router = createBrowserRouter([
  {
    path: "/login",
    element: <Login />,
  },
]);

export default Router;
