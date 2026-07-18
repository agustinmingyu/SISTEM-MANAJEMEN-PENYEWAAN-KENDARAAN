# Supervisor Configuration for Laravel Queue Worker

This example file shows how to configure Supervisor to keep the Laravel queue worker running.

## Example Supervisor config

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --timeout=90
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

## Instructions

1. Save this file as `/etc/supervisor/conf.d/laravel-worker.conf`.
2. Reload Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
```

3. Start the worker:

```bash
sudo supervisorctl start laravel-worker:*
```

## Notes

- Replace `/path/to/your/project` with the actual project root.
- Use the same user as the web server, for example `www-data`.
- Configure `QUEUE_CONNECTION` in `.env` to `database` or `redis`.
- Check worker logs in `storage/logs/worker.log`.

## Optional systemd alternative

If you prefer systemd, use a service file like this:

```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --timeout=90
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=laravel-queue-worker
RestartSec=5s

[Install]
WantedBy=multi-user.target
```

Save as `/etc/systemd/system/laravel-queue.service` and enable it:

```bash
sudo systemctl daemon-reload
sudo systemctl start laravel-queue
sudo systemctl enable laravel-queue
```
