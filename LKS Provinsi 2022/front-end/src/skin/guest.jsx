import React from "react";
import { Navigate, Outlet } from "react-router-dom";

export const GuestSkin = () => {
  return (
    <>
      {" "}
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <div class="container">
          <a class="navbar-brand" href="/">
            Vaccination Platform
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  Login
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <Outlet />
    </>
  );
};
