@servers(['server' => ['root@192.168.88.190']])

@task('deploy', ['on' => 'server'])

    @if ($server === 'develop')
        cd /var/www/print.dev/public_html
    @elseif ($server === 'master')
        cd /var/www/print.prod/public_html
    @endif

    php artisan down
    git pull origin {{ $server }}
    composer update
    php artisan migrate
    php artisan clear-compiled
    php artisan cache:clear
    php artisan view:clear
    php artisan storage:link
    php artisan route:clear
    php artisan route:cache
    php artisan config:clear
    php artisan config:cache
    php artisan optimize
    php artisan up
@endtask
