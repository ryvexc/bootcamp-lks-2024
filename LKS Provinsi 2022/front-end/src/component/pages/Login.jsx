import React, { useState, useEffect } from "react";
import client from "../../utils/router";
import { useNavigate } from "react-router-dom";

export const Login = () => {
  const navigate = useNavigate();
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const [formData, setFormData] = useState({
    id_card_number: "",
    password: "",
  });

  const handleFileInputChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value,
    }));
  };

  const fetchLogin = async () => {
    try {
      const { id_card_number, password } = formData;

      const payload = {
        id_card_number: id_card_number,
        password: password,
      };

      const { data } = await client.post("v1/auth/login", payload);
      console.log(data);

      localStorage.setItem("token", data.token);
      localStorage.setItem("name", data.name);

      setSuccessMessage("Login Success");

      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    } catch (err) {
      console.error("Login failed:", err?.response.data.error);
      setErrorMessage(err?.response?.data?.error);
    }
  };

  const { id_card_number, password } = formData;

  const handleLogin = (e) => {
    e.preventDefault();
    fetchLogin();
  };

  return (
    <div>
      <main>
        <header class="jumbotron">
          <div class="container text-center">
            <h1 class="display-4">Vaccination Platform</h1>
          </div>
        </header>

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              {successMessage && (
                <div className="alert alert-success">{successMessage}</div>
              )}

              {errorMessage && (
                <div className="alert alert-danger">{errorMessage}</div>
              )}

              <form class="card card-default" onSubmit={handleLogin}>
                <div class="card-header">
                  <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                  <div class="form-group row align-items-center">
                    <div class="col-4 text-right">ID Card Number</div>
                    <div class="col-8">
                      <input
                        type="text"
                        class="form-control"
                        name="id_card_number"
                        value={id_card_number}
                        onChange={handleFileInputChange}
                      />
                    </div>
                  </div>
                  <div class="form-group row align-items-center">
                    <div class="col-4 text-right">Password</div>
                    <div class="col-8">
                      <input
                        type="password"
                        class="form-control"
                        name="password"
                        value={password}
                        onChange={handleFileInputChange}
                      />
                    </div>
                  </div>
                  <div class="form-group row align-items-center mt-4">
                    <div class="col-4"></div>
                    <div class="col-8">
                      <button class="btn btn-primary">Login</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
};
