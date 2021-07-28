# Mock API

## API Resources

**iOS**

```
POST /api/ios/receipt/verify HTTP/1.1
Host: mock.local
Authorization: Basic <USERNAME:PASSWORD>
Content-Type: application/json
Content-Length: 27

{
    "receipt":"<TOKEN>"
}
```

**Android**

```
POST /api/android/receipt/verify HTTP/1.1
Host: mock.local
Authorization: Basic <USERNAME:PASSWORD>
Content-Type: application/json
Content-Length: 27

{
    "receipt":"<TOKEN>"
}
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
