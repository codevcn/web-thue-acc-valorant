import { axiosClient } from "../utils/scripts/api-client.js"

export class AdminService {
  static async updateProfile(adminData, rulesData) {
    const dataToSubmit = new FormData()
    dataToSubmit.set("adminData", JSON.stringify(adminData))
    if (rulesData) {
      dataToSubmit.set("rulesData", rulesData)
    }
    const { data } = await axiosClient.post("/admin/update-profile", dataToSubmit)
    return data
  }
}
