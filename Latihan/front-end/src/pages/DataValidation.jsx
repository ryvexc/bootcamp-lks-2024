import { useRef, useState } from "react";
import client from "../route/client";

export default function DataValidation() {
  const [haveExperience, setHaveExperience] = useState();

  const handleSubmit = e => {
    e.preventDefault();

    const formData = new FormData(e.target);

    const [job_category_id, job_position, work_experience, reason_accepted] = [formData.get("job_category_id"), formData.get("job_position"), formData.get("work_experience"), formData.get("reason_accepted")];

    client.post(`/validation?token=${localStorage.getItem("token")}`, { job_category_id, job_position, work_experience, reason_accepted })
      .then(response => {
        if (response.status == 200) {
          window.location.href = "/dashboard";
        }
      })
  }

  return <>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
      <div class="container">
        <a class="navbar-brand" href="/">Job Seeker Platform</a>
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
        <div class="container">
          <h1 class="display-4">Request Data Validation</h1>
        </div>
      </header>

      <div class="container">
        <form onSubmit={handleSubmit}>
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-group">
                <div class="d-flex align-items-center mb-3">
                  <label class="mr-3 mb-0">Job Category</label>
                  <select class="form-control-sm" name="job_category_id">
                    <option value="1">Computing and ICT</option>
                    <option value="2">Construction and building</option>
                    <option value="3">Animals, land and environment</option>
                    <option value="4">Design, arts and crafts</option>
                    <option value="5">Education and training</option>
                  </select>
                </div>
                <textarea name="job_position" class="form-control" cols="30" rows="5" placeholder="Job position sparate with , (comma)"></textarea>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <div class="d-flex align-items-center mb-3">
                  <label class="mr-3 mb-0">Work Experiences ?</label>
                  <select class="form-control-sm" onChange={e => setHaveExperience(e.target.value == "true")}>
                    <option value={true}>Yes, I have</option>
                    <option value={false} selected>No</option>
                  </select>
                </div>
                <textarea disabled={!haveExperience} name="work_experience" class="form-control" cols="30" rows="5" placeholder="Describe your work experiences"></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="d-flex align-items-center mb-3">
                  <label class="mr-3 mb-0">Reason Accepted</label>
                </div>
                <textarea name="reason_accepted" class="form-control" cols="30" rows="6" placeholder="Explain why you should be accepted"></textarea>
              </div>
            </div>
          </div>

          <button class="btn btn-primary">Send Request</button>
        </form>
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