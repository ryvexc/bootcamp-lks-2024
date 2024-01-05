import { useEffect, useState } from "react"
import { useParams } from "react-router-dom";
import client from "../route/client";

export default function JobVacanciesShow() {
  const params = useParams();
  const [vacancy, setVacancy] = useState();

  useEffect(() => {
    client.get(`job_vacancies/${params.id}?token=${localStorage.getItem('token')}`)
      .then(response => {
        setVacancy(response.data.vacancy)
      })
  }, []);

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
              <a class="nav-link" href="#">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main>
      <header class="jumbotron">
        <div class="container text-center">
          <div>
            <h1 class="display-4">{vacancy?.company}</h1>
            <span class="text-muted">{vacancy?.address}</span>
          </div>
        </div>
      </header>

      <div class="container">

        <div class="row mb-3">
          <div class="col-md-12">
            <div class="form-group">
              <h3>Description</h3>
              {vacancy?.description}
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <div class="form-group">
              <h3>Select position</h3>
              <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th width="1">#</th>
                  <th>Position</th>
                  <th>Capacity</th>
                  <th>Application / Max</th>
                  <th rowspan="4" style={{ verticalAlign: "middle", whiteSpace: "nowrap" }} width="1">
                    <a href="" class="btn btn-primary btn-lg">Apply for this job</a>
                  </th>
                </tr>
                {vacancy?.available_position.map(available_position => {
                  return <tr className={available_position.apply_count == available_position.apply_capacity ? "table-warning" : ""}>
                    <td><input type="checkbox" disabled={available_position.apply_count == available_position.apply_capacity} /></td>
                    <td>{available_position.position}</td>
                    <td>{available_position.capacity}</td>
                    <td>{available_position.apply_count}/{available_position.apply_capacity}</td>
                  </tr>
                })}

                {/* <tr>
                      <td><input type="checkbox" /></td>
                      <td>Programmer</td>
                      <td>1</td>
                      <td>3/8</td>
                    </tr>
                    <tr class="table-warning">
                      <td><input type="checkbox" disabled /></td>
                      <td>Manager</td>
                      <td>1</td>
                      <td>22/22</td>
                    </tr> */}
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="d-flex align-items-center mb-3">
                <label class="mr-3 mb-0">Notes for Company</label>
              </div>
              <textarea class="form-control" cols="30" rows="6" placeholder="Explain why you should be accepted"></textarea>
            </div>
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