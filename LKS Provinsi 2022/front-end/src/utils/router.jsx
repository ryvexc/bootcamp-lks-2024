import axios from "axios";

// For global use

// Store API
const client = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  params: {
    token: localStorage.getItem("token"),
  },
});

// client.interceptors.response((response) => {
//     response.error
// })

export default client;
