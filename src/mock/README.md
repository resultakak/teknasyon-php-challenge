# Mock API

## Authentication

Baisc Authentication

```shell
curl -I http://mock.local/api/auth_test -u username:password
```

```http
HTTP/1.1 200 OK
Server: nginx/1.21.1
Date: Wed, 28 Jul 2021 18:38:05 GMT
Content-Type: application/json
Connection: keep-alive
X-Powered-By: PHP/7.4.21
E-Tag: 398606dada94100577db43c3127a19b77d19beeb
```

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
