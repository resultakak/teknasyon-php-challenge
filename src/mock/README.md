# Mock API

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
