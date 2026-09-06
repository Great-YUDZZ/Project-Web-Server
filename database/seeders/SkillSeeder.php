<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Networking
            ['name' => 'MikroTik RouterOS (Routing, NAT, Queue)', 'category' => 'networking', 'level' => 92],
            ['name' => 'Cisco Routing & Switching (VLAN, STP, OSPF)', 'category' => 'networking', 'level' => 88],
            ['name' => 'Subnetting & VLSM / CIDR IPv4 & IPv6', 'category' => 'networking', 'level' => 95],
            ['name' => 'VPN Implementation (WireGuard, OpenVPN, L2TP/IPsec)', 'category' => 'networking', 'level' => 85],
            ['name' => 'Firewall Filtering & Mangle Rules', 'category' => 'networking', 'level' => 89],

            // Sysadmin
            ['name' => 'Linux Server Administration (Debian, Ubuntu)', 'category' => 'sysadmin', 'level' => 90],
            ['name' => 'Web Server LEMP / LAMP (Nginx, PHP-FPM, MySQL)', 'category' => 'sysadmin', 'level' => 92],
            ['name' => 'DNS & DHCP Server Configuration (BIND9, Kea)', 'category' => 'sysadmin', 'level' => 87],
            ['name' => 'Virtualization & Hypervisor (Proxmox VE, KVM)', 'category' => 'sysadmin', 'level' => 84],
            ['name' => 'Network Storage & File Sharing (Samba, NFS, TrueNAS)', 'category' => 'sysadmin', 'level' => 82],

            // Hardware
            ['name' => 'Crimping & UTP/STP Cabling (Cat5e, Cat6 T568B)', 'category' => 'hardware', 'level' => 96],
            ['name' => 'Fiber Optic Splicing & OTDR Power Meter Testing', 'category' => 'hardware', 'level' => 80],
            ['name' => 'PC / Server Hardware Troubleshooting & Assembly', 'category' => 'hardware', 'level' => 92],
            ['name' => 'Wireless Point-to-Point & AP Unifi / Mikrotik', 'category' => 'hardware', 'level' => 88],

            // Tools & Automation
            ['name' => 'GNS3, EVE-NG & Cisco Packet Tracer', 'category' => 'tools', 'level' => 94],
            ['name' => 'Packet Analysis with Wireshark & tcpdump', 'category' => 'tools', 'level' => 86],
            ['name' => 'Bash Scripting & Server Automation', 'category' => 'tools', 'level' => 82],
            ['name' => 'Monitoring System (Zabbix, Prometheus, Grafana)', 'category' => 'tools', 'level' => 85],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }
    }
}
