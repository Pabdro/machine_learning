import axios from "axios";

const instance = axios.create({
  baseURL: "https://machinelearning-production-b92a.up.railway.app/api",
});

instance.defaults.headers.common["Authorization"] = getCookie("token");

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    return `Bearer ${parts.pop().split(";").shift()}`;
  }
}

export default instance;
