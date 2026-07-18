# Changelog

## 2026-07-19

- Add admin Pembayaran CRUD
  - Routes converted to resource: `pembayaran` (create, store, index, show, edit, update, destroy)
  - `PembayaranController`: added `create`, `store`, `edit`, `destroy`, `__construct()` for `authorizeResource`
  - Views added: `resources/views/admin/pembayaran/create.blade.php`, `edit.blade.php`
  - Existing views `index` and `show` verified
  - Authorization: `PembayaranPolicy` used for resource authorization
  - Tests: ran test suite (`pest`) — 27 tests passed

Notes:
- No migrations or model changes required.
- Run the test suite locally after pulling changes to verify environment-specific behavior.
