import React, { useState, useEffect } from "react";
import client from "../../../utils/router";

export const VacinationSpot = () => {
  const [vaccinationData, setVaccinationData] = useState([]);
  const [spotsData, setSpotsData] = useState([]);

  const [districtData, setDistrictData] = useState("");
  const [provinceData, setProvinceData] = useState("");

  const fetchVaccination = async () => {
    try {
      const response = await client.get("v1/vaccinations");
      setVaccinationData(response?.data);
    } catch (err) {
      console.log(err);
    }
  };

  const fetchSpots = async () => {
    try {
      const response = await client.get("v1/spots");
      setProvinceData(response?.data.province);
      setDistrictData(response?.data.district);
      setSpotsData(response?.data.spots);
    } catch (err) {
      console.log(err);
    }
  };

  useEffect(() => {
    fetchVaccination();
    fetchSpots();
  }, []);

  console.log("Vaccination Data : ", vaccinationData);
  console.log("Spots Data : ", spotsData);
  console.log("District Data : ", districtData);

  return (
    <main>
      <header class="jumbotron">
        <div class="container">
          <h1 class="display-4">
            {vaccinationData.length === 0
              ? "First Vaccination"
              : "Second Vaccination"}
          </h1>
        </div>
      </header>

      <div class="container mb-5">
        <div class="section-header mb-4">
          <h4 class="section-title text-muted font-weight-normal">
            List Vaccination Spots in {districtData} - {provinceData}
          </h4>
        </div>

        <div class="section-body mt-4">
          {spotsData.length > 0 &&
            spotsData.map((spot, index) => {
              const isDisabled =
                (spot.serve === 2 && vaccinationData.length === 0) ||
                spot.serve === 1;

              return (
                <article
                  className={`spot ${isDisabled ? "disabled" : ""}`}
                  key={index}
                >
                  <div className="row">
                    <div className="col-5">
                      <h5 className="text-primary">
                        <a
                          href={`${isDisabled
                            ? ""
                            : `/vacination-spot/detail/${spot.id}`
                            } `}
                          className={`spot-name ${isDisabled && "disabled"}`}
                        >
                          {spot.name}
                        </a>
                      </h5>
                      <span className="text-muted">{spot.address}</span>
                    </div>
                    <div className="col-4">
                      <h5>Available vaccines</h5>
                      <span className="text-muted">
                        <ul>
                          {
                            Object.entries(spot.available_vaccine)
                              .filter(vaccine => vaccine[1])
                              .map((vaccine, index) => {
                                return <li key={index}>{vaccine}</li>
                              })
                          }
                        </ul>
                      </span>
                    </div>
                    <div className="col-3">
                      <h5>Serve</h5>
                      <span className="text-muted">
                        {spot.serve === 1 && "Only first vaccination"}
                        {spot.serve === 2 && "Only Second vaccination"}
                        {spot.serve === 3 && "Both vaccination"}
                      </span>
                    </div>
                  </div>
                </article>
              );
            })}
        </div>
      </div>
    </main>
  );
};
