import { axiosClient } from "../utils/scripts/api-client.js"

export class GameAccountService {
  static async fetchAccounts(
    last_id,
    last_updated_at,
    rank,
    status,
    device_type,
    search_term,
    order_type
  ) {
    const params = {}
    if (last_updated_at) params.last_updated_at = last_updated_at
    if (last_id) params.last_id = last_id
    if (rank) params.rank = rank
    if (status) params.status = status
    if (device_type) params.device_type = device_type
    if (search_term) params.search_term = search_term
    if (order_type) params.order_type = order_type
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

  static async addNewAccounts(accountsFormData, imgFile) {
    const dataToSubmit = new FormData()
    dataToSubmit.set("accounts", JSON.stringify(accountsFormData))
    if (imgFile) dataToSubmit.set("avatar", imgFile)
    const { data } = await axiosClient.post("/game-accounts/add-new", dataToSubmit)
    return data
  }

  static async updateAccount(accountId, accountData, avatar) {
    const dataToSubmit = new FormData()
    dataToSubmit.set("account", JSON.stringify(accountData))
    if (avatar) dataToSubmit.set("avatar", avatar)
    const { data } = await axiosClient.post(`/game-accounts/update/${accountId}`, dataToSubmit)
    return data
  }

  static async deleteAccount(accountId) {
    const { data } = await axiosClient.delete(`/game-accounts/delete/${accountId}`)
    return data
  }
}
