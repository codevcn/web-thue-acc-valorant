import { axiosClient } from "../utils/scripts/api-client.js"

export class AdminService {
  static async updateProfile(dataToSend) {
    const dataToSubmit = new FormData()
    dataToSubmit.set("adminData", JSON.stringify(dataToSend))
    const { data } = await axiosClient.post("/admin/update-profile", dataToSubmit)
    return data
  }
}
