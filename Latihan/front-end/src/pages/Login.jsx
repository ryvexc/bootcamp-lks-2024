import axios from "axios";
import { useEffect, useState } from "react";
import { Navigate } from "react-router-dom";
import client from "../route/client";

export default function Login() {
  const [loginError, setLoginError] = useState(false);

  useEffect(() => setLoginError(false), []);

  const handleSubmit = (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const [id_card_number, password] = [formData.get("id_card_number"), formData.get("password")];

    client.post("auth/login", { id_card_number, password })
      .then(response => {
        localStorage.setItem("token", response.data.token);
        window.location.href = "/dashboard";
      }).catch(error => {
        setLoginError(true);
      })
  }

  return <>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/">Job Seekers Platform</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main>
      <header class="jumbotron">
        <div class="container text-center">
          <h1 class="display-4">Job Seekers Platform</h1>
        </div>
      </header>

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <form class="card card-default" onSubmit={handleSubmit}>
              <div class="card-header">
                <h4 class="mb-0">Login</h4>
              </div>
              <div class="card-body">
                <div class="form-group row align-items-center">
                  <div class="col-4 text-right">ID Card Number</div>
                  <div class="col-8"><input name="id_card_number" type="text" class="form-control" /></div>
                </div>
                <div class="form-group row align-items-center">
                  <div class="col-4 text-right">Password</div>
                  <div class="col-8"><input name="password" type="password" class="form-control" /></div>
                </div>
                {loginError && <p class="text-danger">ID Card Number or Password incorrect</p>}
                <div class="form-group row align-items-center mt-4">
                  <div class="col-4"></div>
                  <div class="col-8"><button class="btn btn-primary">Login</button></div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <div class="container">
        <div class="text-center py-4 text-muted">
          Copyright &copy; 2023 - Web Tech ID
        </div>
      </div>
    </footer>
  </>
}