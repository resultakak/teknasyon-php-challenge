Mobile Application Subscription Managment API
=======

## API Resources

**register**

```
POST /api/register HTTP/1.1
Host: api.local
Content-Type: application/json

{
    "uid": "<UID>",
    "app_id": "<APPID>",
    "language":"<LANG>",
    "platform": "<IOS|ANDROID>"
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

## Status Codes

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 202 | `ACCEPTED` |
| 301 | `MOVED PERMANENTLY` |
| 302 | `FOUND` |
| 307 | `TEMPORARY REDIRECT` |
| 308 | `PERMANENTLY REDIRECT` |
| 400 | `BAD REQUEST` |
| 401 | `UNAUTHORIZED` |
| 403 | `FORBIDDEN FOUND` |
| 404 | `NOT FOUND` |
| 500 | `INTERNAL SERVER ERROR` |
| 501 | `NOT_IMPLEMENTED` |
| 502 | `BAD_GATEWAY` |
