import { axiosClient } from "../utils/scripts/api-client.js"

export class GameAccountService {
  static async fetchAccounts(last_id, rank, status, device_type) {
    const params = {}
    if (last_id) params.last_id = last_id
    if (rank) params.rank = rank
    if (status) params.status = status
    if (device_type) params.device_type = device_type
    const { data } = await axiosClient.get("/game-accounts/load-more", { params })
    return data.accounts
  }
}
