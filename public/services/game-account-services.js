import { axiosClient } from "../utils/scripts/api-client.js"

export class GameAccountService {
  static async fetchAccounts(last_id, rank, status, device_type, search_term, date_from, date_to) {
    const params = {}
    if (last_id) params.last_id = last_id
    if (rank) params.rank = rank
    if (status) params.status = status
    if (device_type) params.device_type = device_type
    if (search_term) params.search_term = search_term
    if (date_from) params.date_from = date_from
    if (date_to) params.date_to = date_to
    const { data } = await axiosClient.get("/game-accounts/load-more", { params })
    return data.accounts
  }

  static async fetchAccountRankTypes() {
    const { data } = await axiosClient.get("/game-accounts/rank-types")
    return data.rank_types
  }

  static async fetchAccountStatuses() {
    const { data } = await axiosClient.get("/game-accounts/statuses")
    return data.statuses
  }

  static async fetchDeviceTypes() {
    const { data } = await axiosClient.get("/game-accounts/device-types")
    return data.device_types
  }

  static async addNewAccount(accountData) {
    const { data } = await axiosClient.post("/game-accounts/add-new", {
      accounts: [accountData],
    })
    return data
  }

  static async updateAccount(accountId, accountData) {
    const { data } = await axiosClient.post(`/game-accounts/update/${accountId}`, {
      account: accountData,
    })
    return data
  }

  static async deleteAccount(accountId) {
    const { data } = await axiosClient.delete(`/game-accounts/delete/${accountId}`)
    return data
  }
}
