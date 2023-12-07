/**
 * Created by Zura on 12/25/2021.
 */
import axios from "axios";

const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}`
})

export default axiosClient;