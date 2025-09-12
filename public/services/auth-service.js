import { axiosClient } from "../utils/scripts/api-client.js?v=1.0.0"

export class AuthService {
  static async login(username, password) {
    const dataToSubmit = new FormData()
    dataToSubmit.append("username", username)
    dataToSubmit.append("password", password)
    const { data } = await axiosClient.post("/auth/login", dataToSubmit)
    return data
  }

  static async logout() {
    const { data } = await axiosClient.get("/auth/logout")
    return data
  }
}
