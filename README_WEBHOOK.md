Webhook & Queue setup

1) Set `PAYMENT_WEBHOOK_SECRET` in `.env` to a random secret string.

2) Example curl to simulate webhook signature (SHA256 HMAC):

```bash
PAYLOAD='{"pembayaran_id":1,"status":"paid"}'
SECRET="your_secret_here"
SIG=$(echo -n "$PAYLOAD" | openssl dgst -sha256 -hmac "$SECRET" -binary | xxd -p -c 256)
curl -X POST http://localhost:8000/webhook/pembayaran \
  -H "Content-Type: application/json" \
  -H "X-Signature: $SIG" \
  -d "$PAYLOAD"
```

3) Queue & mail

- Configure `QUEUE_CONNECTION` in `.env` (database/redis).
- Run migrations and create queue table if using `database`:

```bash
php artisan queue:table
php artisan migrate
```

- Start worker:

```bash
php artisan queue:work --sleep=3 --tries=3
```

4) Mail

- Configure mail settings in `.env` (SMTP or use Mailtrap / sendmail).
- For development, `MAIL_MAILER=log` will write messages to log.
