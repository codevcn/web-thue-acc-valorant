import requests

url = "http://localhost:3000/api/v1/game-accounts/load-more"  # thay bằng domain thật của bạn

params = {
    "last_id": 70
}

response = requests.get(url, params=params)

if response.status_code == 200:
    data = response.json()
    print(data.get("accounts", []))
else:
    print("Request failed:", response.status_code, response.text)
