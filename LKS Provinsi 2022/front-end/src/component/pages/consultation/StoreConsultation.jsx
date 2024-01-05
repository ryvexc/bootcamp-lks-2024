import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import client from "../../../utils/router";

export const StoreConsultation = () => {
  const navigate = useNavigate();

  /// Handle Message
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  // Handle textarea
  const [expanded, setExpanded] = useState({
    disease: "no",
    symptoms: "no",
  });

  // Handle formData
  const [formData, setFormData] = useState({
    disease: "",
    symptoms: "",
  });

  // Handle expanded
  const handleIsExpanded = (field, value) => {
    setExpanded((prevExpanded) => ({
      ...prevExpanded,
      [field]: value,
    }));
  };

  // Handle input change
  const handleFileInputChange = (field, value) => {
    setFormData((prevFormData) => ({
      ...prevFormData,
      [field]: value,
    }));
  };

  // Handle store data to API
  const storeConsultation = async () => {
    try {
      const payload = {
        disease_history: formData.disease,
        current_symptoms: formData.symptoms,
        doctor_id: "3",
      };

      const response = await client.post(
        "http://127.0.0.1:8000/api/v1/consultations",
        payload
      );

      console.log(response.data);
      setSuccessMessage("Request consultation success!");

      setTimeout(() => {
        navigate("/");
      }, 2000);
    } catch (err) {
      console.log(err?.response.data);
      setErrorMessage("All form must be filled!");
    }
  };

  // Handle Submit
  const handleStoreConsultation = (e) => {
    e.preventDefault();
    storeConsultation();
  };

  return (
    <main>
      <header className="jumbotron">
        <div className="container">
          <h1 className="display-4">Request Consultation</h1>
        </div>
      </header>

      <div className="container">
        <form onSubmit={handleStoreConsultation} className="mb-5">
          <div className="row mb-4">
            <div className="col-md-6">
              <div className="form-group">
                <div className="d-flex align-items-center mb-3">
                  <label htmlFor="disease-history" className="mr-3 mb-0">
                    Do you have disease history?
                  </label>
                  <select
                    className="form-control-sm"
                    onChange={(e) =>
                      handleIsExpanded("disease", e.target.value)
                    }
                    value={expanded.disease}
                  >
                    <option value="yes">Yes, I have</option>
                    <option value="no">No</option>
                  </select>
                </div>
                <textarea
                  id="disease-history"
                  className="form-control"
                  cols="30"
                  rows="10"
                  name="disease"
                  value={formData.disease}
                  onChange={(e) =>
                    handleFileInputChange("disease", e.target.value)
                  }
                  placeholder={
                    expanded.disease === "no"
                      ? "Describe your disease history"
                      : "Describe your disease history"
                  }
                  disabled={expanded.disease === "no"}
                  required
                ></textarea>
              </div>
            </div>
          </div>

          <div className="row mb-4">
            <div className="col-md-6">
              <div className="form-group">
                <div className="d-flex align-items-center mb-3">
                  <label htmlFor="current-symptoms" className="mr-3 mb-0">
                    Do you have symptoms now?
                  </label>
                  <select
                    className="form-control-sm"
                    onChange={(e) =>
                      handleIsExpanded("symptoms", e.target.value)
                    }
                    value={expanded.symptoms}
                  >
                    <option value="yes">Yes, I have</option>
                    <option value="no">No</option>
                  </select>
                </div>
                <textarea
                  id="current-symptoms"
                  className="form-control"
                  cols="30"
                  rows="10"
                  name="symptoms"
                  value={formData.symptoms}
                  onChange={(e) =>
                    handleFileInputChange("symptoms", e.target.value)
                  }
                  placeholder={
                    expanded.symptoms === "no"
                      ? "Describe your current symptoms"
                      : "Describe your current symptoms"
                  }
                  disabled={expanded.symptoms === "no"}
                  required
                ></textarea>
              </div>
            </div>
          </div>

          {errorMessage && (
            <div className="alert alert-danger w-50">{errorMessage}</div>
          )}

          {successMessage && (
            <div className="alert alert-success w-50">{successMessage}</div>
          )}

          <button type="submit" className="btn btn-primary">
            Submit
          </button>
        </form>
      </div>
    </main>
  );
};
