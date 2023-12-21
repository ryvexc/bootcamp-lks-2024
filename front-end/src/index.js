import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import "./bootstrap.css";
import { RouterProvider } from "react-router-dom";
import routes from "./route/list";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
	<React.StrictMode>
		<RouterProvider router={routes} />
	</React.StrictMode>,
);
