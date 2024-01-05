import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import "../src/component/pages/assets/css/bootstrap.css";
import "../src/component/pages/assets/css/custom.css";
import { RouterProvider } from "react-router-dom";
import routes from "./utils/routerList";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
	<React.StrictMode>
		<RouterProvider router={routes} />
	</React.StrictMode>,
);

reportWebVitals();
