import React, { useState, useEffect } from "react";
import { useNavigate, Outlet } from "react-router-dom";

export const GuardSkin = () => {
  const navigate = useNavigate();

  const [isLoggedIn, setIsLoggedIn] = useState(!!localStorage.getItem("token")); // If token exists, user is logged in true
  const society_name = localStorage.getItem("name");

  const handleLogout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("name");

    setIsLoggedIn(false);
    window.location.href = "/login";
  };

  useEffect(() => {
    if (!isLoggedIn) {
      window.location.href = '/login';
    }
  }, [isLoggedIn, navigate]);

  return (
    <>
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
              {isLoggedIn ? (
                <>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      {society_name}
                    </a>
                  </li>
                  <li class="nav-item" onClick={handleLogout}>
                    <a class="nav-link" href="#">
                      Logout
                    </a>
                  </li>
                </>
              ) : (
                <li class="nav-item">
                  <a class="nav-link" href="/login">
                    Login
                  </a>
                </li>
              )}
            </ul>
          </div>
        </div>
      </nav>

      <Outlet />
    </>
  );
};
