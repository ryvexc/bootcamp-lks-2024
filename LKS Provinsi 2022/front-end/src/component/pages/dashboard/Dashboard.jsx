import React, { useState, useEffect } from "react";
import client from "../../../utils/router";

export const Dashboard = () => {
  const [consultationData, setConsultationData] = useState([]);
  const [vaccinationData, setVaccinationData] = useState([]);

  const fetchConsultation = async () => {
    try {
      const response = await client.get("/v1/consultations");
      setConsultationData([response?.data]);
    } catch (err) {
      console.log(err);
    }
  };

  const fetchVaccination = async () => {
    try {
      const response = await client.get("v1/vaccinations");
      setVaccinationData(response?.data);
    } catch (err) {
      console.log(err);
    }
  };

  useEffect(() => {
    fetchConsultation();
    fetchVaccination();
  }, []);

  console.log("Consultation Data : ", consultationData);
  console.log("Vaccination Data : ", vaccinationData);

  const consultationStatus = consultationData[0]?.status;
  const vaccinationDoseFirst = vaccinationData[0]?.dose;

  console.log(consultationStatus);
  console.log(vaccinationDoseFirst);

  const formatDate = (inputDate) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(inputDate).toLocaleDateString("en-US", options);
  };

  return (
    <main>
      <header class="jumbotron">
        <div class="container">
          <h1 class="display-4">Dashboard</h1>
        </div>
      </header>

      <div class="container">
        <section class="consultation-section mb-5">
          <div class="section-header mb-3">
            <h4 class="section-title text-muted">My Consultation</h4>
          </div>
          <div class="row">
            {consultationData.length === 0 && (
              <div class="col-md-4">
                <div class="card card-default">
                  <div class="card-header">
                    <h5 class="mb-0">Consultation</h5>
                  </div>
                  <div class="card-body">
                    <a href="/store-consultation">+ Request consultation</a>
                  </div>
                </div>
              </div>
            )}

            {consultationData.length > 0
              ? consultationData.map((consultation, index) => (
                <div key={index} class="col-md-4">
                  <div class="card card-default">
                    <div class="card-header border-0">
                      <h5 class="mb-0">Consultation</h5>
                    </div>
                    <div class="card-body p-0">
                      <table class="table table-striped mb-0">
                        <tr>
                          <th>Status</th>
                          <td>
                            {consultation?.status === "accepted" ? (
                              <span className="badge badge-success">
                                {consultation?.status ?? "-"}
                              </span>
                            ) : consultation?.status === "declined" ? (
                              <span className="badge badge-danger">
                                {consultation?.status ?? "-"}
                              </span>
                            ) : (
                              <span className="badge badge-primary">
                                {consultation?.status ?? "-"}
                              </span>
                            )}
                          </td>
                        </tr>
                        <tr>
                          <th>Disease History</th>
                          <td class="text-muted">
                            {consultation?.disease_history ?? "-"}
                          </td>
                        </tr>
                        <tr>
                          <th>Current Symptoms</th>
                          <td class="text-muted">
                            {consultation?.current_symptoms ?? "-"}
                          </td>
                        </tr>
                        <tr>
                          <th>Doctor Name</th>
                          <td class="text-muted">
                            {consultation?.doctor?.name ?? "-"}
                          </td>
                        </tr>
                        <tr>
                          <th>Doctor Notes</th>
                          <td class="text-muted">
                            {consultation?.doctor_notes ?? "-"}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              ))
              : "Please Request Consultation First!"}
          </div>
        </section>

        <section class="consultation-section mb-5">
          <div class="section-header mb-3">
            <h4 class="section-title text-muted">My Vaccinations</h4>
          </div>
          <div class="section-body">
            <div class="row mb-4">
              {/* Handle banner show*/}
              {consultationStatus === undefined && (
                <div class="col-md-12">
                  <div class="alert alert-warning">
                    Your consultation must be approved by the doctor to get the
                    vaccine.
                  </div>
                </div>
              )}

              {/* Handle banner show*/}
              {consultationStatus === "pending" && (
                <div class="col-md-12">
                  <div class="alert alert-warning">
                    Your consultation must be approved by the doctor to get the
                    vaccine.
                  </div>
                </div>
              )}

              {consultationStatus === "accepted" && (
                <>
                  {vaccinationData.length === 0 && (
                    <div class="col-md-4">
                      <div class="card card-default">
                        <div class="card-header border-0">
                          <h5 class="mb-0">First Vaccination</h5>
                        </div>
                        <div class="card-body">
                          <a href="/vacination-spot">+ Register vaccination</a>
                        </div>
                      </div>
                    </div>
                  )}

                  {vaccinationData.length === 0 ||
                    vaccinationData.length === 2 ? (
                    ""
                  ) : (
                    <div class="col-md-4">
                      <div class="card card-default">
                        <div class="card-header border-0">
                          <h5 class="mb-0">Second Vaccination</h5>
                        </div>
                        <div class="card-body">
                          <a href="/vacination-spot">+ Register vaccination</a>
                        </div>
                      </div>
                    </div>
                  )}

                  {vaccinationData.length > 0 &&
                    vaccinationData.map((vaccination, index) => (
                      <div class="col-md-4" key={index}>
                        <div class="card card-default">
                          <div class="card-header border-0">
                            <h5 class="mb-0">
                              {vaccination?.dose === 1
                                ? "First Vaccination"
                                : "Second Vaccination"}
                            </h5>
                          </div>
                          <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                              <tr>
                                <th>Status</th>
                                <td class="text-muted">
                                  <span class="badge badge-info">
                                    Registered
                                  </span>
                                </td>
                              </tr>
                              <tr>
                                <th>Date</th>
                                <td class="text-muted">
                                  {formatDate(vaccination?.date)}
                                </td>
                              </tr>
                              <tr>
                                <th>Spot</th>
                                <td class="text-muted">
                                  {vaccination?.spot?.name}
                                </td>
                              </tr>
                              <tr>
                                <th>Vaccine</th>
                                <td class="text-muted">
                                  {vaccination?.vaccine?.name}
                                </td>
                              </tr>
                              <tr>
                                <th>Vaccinator</th>
                                <td class="text-muted">
                                  {vaccination?.medicals?.name}
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    ))}
                </>
              )}
            </div>
          </div>
        </section>
      </div>
    </main>
  );
};
