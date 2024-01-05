import { createBrowserRouter } from "react-router-dom";
import Login, { LoginPage } from "../pages/Login";
import Dashboard, { DashboardPage } from "../pages/Dashboard";
import { Navigate, Outlet } from "react-router-dom";
import DataValidation from "../pages/DataValidation";
import JobVacancies from "../pages/JobVacancies";
import JobVacanciesShow from "../pages/JobVacanciesShow";

function Authorized() {
	if (localStorage.getItem("token") == null) {
		return <Navigate to={"/"} />;
	}

	return (
		<div>
			<Outlet />
		</div>
	);
}

function Unauthorized() {
	if (localStorage.getItem("token") != null) {
		return <Navigate to={"/dashboard"} />;
	}

	return (
		<div>
			<Outlet />
		</div>
	);
}

const routes = createBrowserRouter([
	{
		path: "/",
		element: <Unauthorized />,
		children: [
			{
				path: "/",
				element: <Login />,
			},
		],
	},
	{
		path: "/",
		element: <Authorized />,
		children: [
			{
				path: "/dashboard",
				element: <Dashboard />,
			},
		],
	},
	{
		path: "/",
		element: <Authorized />,
		children: [
			{
				path: "/datavalidation",
				element: <DataValidation />,
			},
		],
	},
	{
		path: "/",
		element: <Authorized />,
		children: [
			{
				path: "/jobvacancies",
				element: <JobVacancies />,
			},
		],
	},
	{
		path: "/",
		element: <Authorized />,
		children: [
			{
				path: "/jobvacancies/:id",
				element: <JobVacanciesShow />,
			},
		],
	},
]);

export default routes;
