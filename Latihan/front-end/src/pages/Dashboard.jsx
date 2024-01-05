import axios from "axios";
import { useEffect, useState } from "react";
import client from "../route/client";
import { Navigate } from "react-router-dom";

export function DataValidationCard({ status, jobCategory, jobPosition, reasonAccepted, validator, validatorNotes }) {
  const badgeColor = status == "accepted" ? "badge-success" : status == "declined" ? "badge-danger" : "badge-info";

  return <div class="col-md-4">
    <div class="card card-default">
      <div class="card-header border-0">
        <h5 class="mb-0">Data Validation</h5>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <tr>
            <th>Status</th>
            <td><span class={"badge " + badgeColor}>{status.charAt(0).toUpperCase() + status.slice(1)}</span></td>
          </tr>
          <tr>
            <th>Job Category</th>
            <td class="text-muted">{jobCategory}</td>
          </tr>
          <tr>
            <th>Job Position</th>
            <td class="text-muted">{jobPosition}</td>
          </tr>
          <tr>
            <th>Reason Accepted</th>
            <td class="text-muted">{reasonAccepted}</td>
          </tr>
          <tr>
            <th>Validator</th>
            <td class="text-muted">{validator}</td>
          </tr>
          <tr>
            <th>Validator Notes</th>
            <td class="text-muted">{validatorNotes}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
}

export function JobApplicationsCard({ company, address, positions, applyDate, notes }) {
  return <div class="col-md-6">
    <div class="card card-default">
      <div class="card-header border-0">
        <h5 class="mb-0">{company}</h5>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <tr>
            <th>Address</th>
            <td class="text-muted">{address}</td>
          </tr>
          <tr>
            <th>Position</th>
            <td class="text-muted">
              <ul>
                {positions?.map(position => {
                  const badgeColor = position.apply_status == "accepted" ? "badge-success" : position.apply_status == "rejected" ? "badge-danger" : "badge-info";
                  return <li>{position.position} <span class={"badge " + badgeColor}>{position.apply_status.charAt(0).toUpperCase() + position.apply_status.slice(1)}</span></li>
                })}
              </ul>
            </td>
          </tr>
          <tr>
            <th>Apply Date</th>
            <td class="text-muted">{applyDate}</td>
          </tr>
          <tr>
            <th>Notes</th>
            <td class="text-muted">{notes}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
}

export default function Dashboard() {
  const [dataValidation, setDataValidation] = useState([]);
  const [dataJobApplication, setDataJobApplication] = useState([]);
  const [canApplyJob, setCanApplyJob] = useState(false);

  useEffect(() => {
    client.get(`validations?token=${localStorage.getItem("token")}`)
      .then(response => {
        setDataValidation(response.data.validation)
        setCanApplyJob(response.data.validation.filter(_validation => _validation.status == 'accepted').length > 0);
      })

    client.get(`applications?token=${localStorage.getItem("token")}`)
      .then(response => {
        setDataJobApplication(response.data.vacancies)
      })
  }, []);

  const handleLogout = (e) => {
    e.preventDefault();

    client.post(`/auth/logout?token=${localStorage.getItem('token')}`)
      .then(response => {
        if (response.status == 200) {
          localStorage.removeItem('token');
          window.location.href = "/";
        }
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
              <a class="nav-link" href="#">Marsito Kusmawati</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onClick={handleLogout} href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main>
      <header class="jumbotron">
        <div class="container">
          <h1 class="display-4">Dashboard</h1>
        </div>
      </header>

      <div class="container">
        <section class="validation-section mb-5">
          <div class="section-header mb-3">
            <h4 class="section-title text-muted">My Data Validation</h4>
          </div>
          <div class="row">
            {!canApplyJob &&
              <div class="col-md-4">
                <div class="card card-default">
                  <div class="card-header">
                    <h5 class="mb-0">Data Validation</h5>
                  </div>

                  <div class="card-body">
                    <a href="datavalidation" class="btn btn-primary btn-block">+ Request validation</a>
                  </div>
                </div>
              </div>
            }

            {dataValidation.map(_dataValidation => {
              return <DataValidationCard status={_dataValidation.status} jobCategory={_dataValidation.job_category.job_category} jobPosition={_dataValidation.job_position} reasonAccepted={_dataValidation.reason_accepted} validator={_dataValidation.validator} validatorNotes={_dataValidation.validator_notes} />
            })}
          </div>
        </section>

        <section class="validation-section mb-5">
          <div class="section-header mb-3">
            <div class="row">
              <div class="col-md-8">
                <h4 class="section-title text-muted">My Job Applications</h4>
              </div>
              <div class="col-md-4">
                {canApplyJob &&
                  <a href="jobvacancies" class="btn btn-primary btn-lg btn-block">+ Add Job Applications</a>
                }
              </div>
            </div>
          </div>
          <div class="section-body">
            <div class="row mb-4">
              {
                !canApplyJob &&
                <div class="col-md-12">
                  <div class="alert alert-warning">
                    Your validation must be approved by validator to applying job.
                  </div>
                </div>
              }

              {dataJobApplication.length > 0 ?
                dataJobApplication.map((data, i) => {
                  return <JobApplicationsCard address={data.address} applyDate={data.apply_date} company={data.company} notes={data.notes} positions={data.position} key={i} />
                })
                : <></>
              }
            </div>
          </div>
        </section>
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