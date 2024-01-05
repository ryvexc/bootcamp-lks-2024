import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import client from "../../../utils/router";

export const VacinationSpotDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [spotDetailData, setSpotDetailData] = useState({});
  const [vaccinationDate, setVaccinationDate] = useState("");
  const [vacinationCount, setVacinationCount] = useState({});
  const [vacinationCountList, setVacinationCountList] = useState([]);
  const [vacinationListByDate, setVacinationListByDate] = useState([]);

  // Handle Message
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  const fetchSpotDetail = async (selectedDate) => {
    try {
      const response = await client.get(`v1/spots/${id}?date=${selectedDate}`);
      setVacinationListByDate(response?.data.vaccination_list_date);
      setVacinationCountList(response?.data.vaccinations_count_list);
      setVacinationCount(response?.data.vaccinations_count);
      setSpotDetailData(response?.data.spot);
    } catch (err) {
      console.log(err);
    }
  };

  // Handle store vaccination
  const handleRegisterVaccination = async (e) => {
    e.preventDefault();

    try {
      const payload = {
        date: vaccinationDate,
        spot_id: String(id),
        vaccine_id: String(spotDetailData?.spot_vaccine.vaccine_id),
        doctor_id: "4",
      };

      const response = await client.post("v1/vaccinations", payload);
      console.log(response);

      setSuccessMessage("Success Register Vaccination!");
      setTimeout(() => {
        navigate("/");
      }, 2000);
    } catch (err) {
      console.log(err);
      setErrorMessage(err?.response.data);
    }
  };

  // Handle filter by date
  const handleDateChange = (e) => {
    // console.log(String(e.target.value));
    setVaccinationDate(String(e.target.value));
    fetchSpotDetail(String(e.target.value));
  };

  useEffect(() => {
    fetchSpotDetail(vaccinationDate);
    console.log({ vaccinationDate })
  }, [vaccinationDate]);

  // For generating session card
  const generateSessions = () => {
    const sessions = [];
    const sessionsCount = Math.ceil(spotDetailData.capacity / 5);

    for (let i = 1; i <= sessionsCount; i++) {
      sessions.push(
        <div key={i} className="col-md-4">
          <div className="card card-default">
            <div className="card-body">
              <div className="d-flex align-items-center justify-content-between mb-3">
                <h4>Session {i}</h4>
                <span className="text-muted">
                  {i === 2
                    ? "13:00 - 15:00"
                    : i === 3
                      ? "15:00 - 17:00"
                      : "09:00 - 11:00"}
                </span>
              </div>
              {generateSlots(i)}
            </div>
          </div>
        </div>
      );
    }

    return sessions;
  };

  // For generating slots card (inside session)
  const generateSlots = (session) => {
    const slots = [];
    const startSlot = (session - 1) * 5 + 1;
    const endSlot = Math.min(session * 5, spotDetailData.capacity);

    const mySocietyId = localStorage.getItem("society_id");
    const totalVaccinations = vacinationCountList.length;
    console.log("Total Vaccinations : ", totalVaccinations);

    for (let i = startSlot; i <= endSlot; i++) {
      const slotNumber = i < 10 ? `#0${i}` : `#${i}`;

      // Check if the slot is filled by anyone
      const isFilled = i <= totalVaccinations;

      // Check if the slot if mine or not
      const isMySlot = vacinationCountList.some((vaccination) => {
        // console.log("Vaccination: ", vaccination);
        return vaccination.society_id === mySocietyId;
      });

      slots.push(
        <div key={i} className={`col-4 mb-4 ${isFilled ? "filled" : ""}`}>
          <div
            className={`slot ${isMySlot
              ? "filled bg-primary text-white"
              : isFilled
                ? "filled"
                : ""
              }`}
          >
            {slotNumber}
          </div>
        </div>
      );
    }

    return <div className="row">{slots}</div>;
  };

  console.log("Spots detail data : ", spotDetailData);
  console.log("Vaccination Count : ", vacinationCount);
  console.log("Vaccination Count List : ", vacinationCountList);

  console.log("Vaccination Date : ", vaccinationDate);
  console.log("Vaccination Data list by date : ", vacinationListByDate);

  console.log(errorMessage);

  return (
    <main>
      <header class="jumbotron">
        <div class="container d-flex justify-content-between align-items-center">
          <div>
            <h1 class="display-4">{spotDetailData.name ?? "-"}</h1>
            <span class="text-muted">{spotDetailData.address ?? "-"}</span>
          </div>
          <a
            href=""
            class="btn btn-primary"
            onClick={handleRegisterVaccination}
          >
            Register vaccination
          </a>
        </div>
      </header>

      <div class="container">
        <div class="row mb-3">
          {successMessage && (
            <div className="col-md-12">
              <div className="alert alert-success">{successMessage}</div>
            </div>
          )}

          {errorMessage.length > 0 && (
            <div className="col-md-12">
              <div className="alert alert-danger">
                {errorMessage.map((errorObj, index) => (
                  <div key={index}>
                    {Object.entries(errorObj).map(([key, value]) => (
                      <div key={key}>
                        <strong>{key}:</strong>{" "}
                        {Array.isArray(value)
                          ? value.join(", ")
                          : String(value)}
                      </div>
                    ))}
                  </div>
                ))}
              </div>
            </div>
          )}

          {errorMessage && (
            <div className="col-md-12">
              <div className="alert alert-danger">{errorMessage.message}</div>
            </div>
          )}

          <div class="col-md-3">
            <div class="form-group">
              <label for="vaccination-date">Select vaccination date</label>
              <input
                type="date"
                class="form-control"
                id="vaccination-date"
                onChange={handleDateChange}
              />
            </div>
          </div>
        </div>

        <div class="row mb-5">{generateSessions()}</div>
      </div>
    </main>
  );
};
