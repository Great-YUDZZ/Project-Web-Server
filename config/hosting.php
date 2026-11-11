<?php

return [
    'ctl' => env('HOSTING_CTL', '/usr/local/sbin/hosting-ctl'),
    'bind_dir' => env('HOSTING_BIND_DIR', '/etc/bind'),
    'bind_named_conf_local' => env('HOSTING_BIND_CONF_LOCAL', '/etc/bind/named.conf.local'),
    'nginx_sites_available' => env('HOSTING_NGINX_SITES_AVAILABLE', '/etc/nginx/sites-available'),
    'primary_vhost' => env('HOSTING_PRIMARY_VHOST', '/etc/nginx/sites-available/project_tkj_yuda2'),
    'repo_vhost' => env('HOSTING_REPO_VHOST', base_path('nginx/project_tkj_yuda2.conf')),
    'services' => [
        'nginx' => [
            'unit' => 'nginx',
            'display' => 'Nginx Web Server',
            'port' => 80,
            'manager' => 'systemd',
            'description' => 'Reverse proxy + FastCGI gateway :80',
            'protected' => true,
        ],
        'php-fpm' => [
            'unit' => 'php8.4-fpm',
            'display' => 'PHP 8.4-FPM',
            'port' => null,
            'manager' => 'systemd',
            'description' => 'PHP engine via unix socket',
            'protected' => true,
        ],
        'mariadb' => [
            'unit' => 'mariadb',
            'display' => 'MariaDB Database',
            'port' => 3306,
            'manager' => 'systemd',
            'description' => 'Relational engine InnoDB :3306',
            'protected' => true,
        ],
        'named' => [
            'unit' => 'named',
            'display' => 'BIND9 DNS (Named)',
            'port' => 53,
            'manager' => 'systemd',
            'description' => 'DNS lokal yuda.local + sinkhole :53',
            'protected' => true,
        ],
        'avahi-daemon' => [
            'unit' => 'avahi-daemon',
            'display' => 'Avahi mDNS',
            'port' => 5353,
            'manager' => 'systemd',
            'description' => 'Discovery .local untuk Apple/Linux client',
            'protected' => false,
        ],
        'ssh' => [
            'unit' => 'ssh',
            'display' => 'OpenSSH Daemon',
            'port' => 22,
            'manager' => 'systemd',
            'description' => 'Remote admin SSH :22',
            'protected' => true,
        ],
    ],
    'sinkhole' => [
        'protected_domains' => [
            'yuda.local',
            'localhost',
            'host.containers.internal',
            'host.docker.internal',
        ],
        'default_target' => '0.0.0.0',
        'allow_targets' => ['0.0.0.0', '127.0.0.1'],
    ],
    'vhost' => [
        'protected' => [
            'project_tkj_yuda2',
            'great-yuda.my.id',
            'www.great-yuda.my.id',
            'yuda.local',
            'localhost',
            '127.0.0.1',
        ],
    ],
    'aapanel' => [
        'enabled' => env('AAPANEL_ENABLED', false),
        'base_url' => env('AAPANEL_BASE_URL', 'http://127.0.0.1:7800'),
        'api_sk' => env('AAPANEL_API_SK', ''),
        'timeout' => (int) env('AAPANEL_TIMEOUT', 5),
    ],
    'audit' => [
        'keep_days' => 90,
    ],
];
