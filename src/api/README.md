Mobile Application Subscription Managment API
=======

**register**

```
POST /api/register HTTP/1.1
Host: api.local
Content-Type: application/json

{
    "uid": "<UID>",
    "app_id": "<APPID>",
    "language":"<LANG>",
    "os": "<IOS|ANDROID>"
}
```

**purchase**

```
POST /api/purchase HTTP/1.1
Host: api.local
Authorization: Bearer <TOKEN>
Content-Type: application/json

{
    "receipt": "<RECEIPT>"
}
```

**check_subscription**

```
GET /api/check_subscription HTTP/1.1
Host: api.local
Authorization: Bearer <TOKEN>
```
