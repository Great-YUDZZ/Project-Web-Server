/**
 * Cisco Catalyst 2960-X Interactive Rack-Mount Switch Console
 * Authentic networking hardware simulation for SMK TKJ portfolio.
 * Zero AI slop: Real Cisco IOS CLI syntax, 802.1Q VLAN trunking, and port status telemetry.
 */

const PORT_DATA = {
    1: {
        name: 'Gi0/1',
        title: 'Server LEMP Baremetal',
        type: 'GigabitEthernet (RJ45)',
        status: 'UP',
        duplex: 'Full',
        speed: '1000 Mbps',
        vlan: '10 (LEMP_DMZ)',
        ip: '192.168.10.15/24',
        connected: 'Debian 13 Baremetal Host (Nginx 1.26 + MariaDB 11.8 + PHP 8.4-FPM)',
        role: 'Production Web Server Farm',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/1
 description LEMP-PROD-BAREMETAL-SERVER
 switchport mode access
 switchport access vlan 10
 spanning-tree portfast
 speed 1000
 duplex full
 no shutdown`,
        showSwitchport: `Name: Gi0/1
Switchport: Enabled
Administrative Mode: static access
Operational Mode: static access
Access Mode VLAN: 10 (LEMP_DMZ)
Trunking Native Mode VLAN: 1 (default)
Voice VLAN: none`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/1     LEMP-PROD-SERVER   connected    10         a-full  a-1000 10/100/1000BaseTX`
    },
    2: {
        name: 'Gi0/2',
        title: 'Workstation Network Admin',
        type: 'GigabitEthernet (RJ45)',
        status: 'UP',
        duplex: 'Full',
        speed: '1000 Mbps',
        vlan: '20 (MGMT_LAN)',
        ip: '192.168.20.10/24',
        connected: 'Workstation Admin (SSH Ed25519 Keys, Syslog Daemon, SNMP Monitor)',
        role: 'Manajemen & Monitoring Jaringan',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/2
 description ADMIN-MGMT-WORKSTATION
 switchport mode access
 switchport access vlan 20
 spanning-tree portfast
 speed 1000
 duplex full
 no shutdown`,
        showSwitchport: `Name: Gi0/2
Switchport: Enabled
Administrative Mode: static access
Operational Mode: static access
Access Mode VLAN: 20 (MGMT_LAN)
Trunking Native Mode VLAN: 1 (default)
Voice VLAN: none`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/2     ADMIN-MGMT-WS      connected    20         a-full  a-1000 10/100/1000BaseTX`
    },
    8: {
        name: 'Gi0/8',
        title: 'Cisco Aironet AP + VoIP',
        type: 'GigabitEthernet (PoE+ 802.3at)',
        status: 'UP',
        duplex: 'Full',
        speed: '100 Mbps',
        vlan: '30 (Data) / 35 (Voice)',
        ip: '192.168.30.2/24',
        connected: 'Dual-Band Wireless AP + Cisco IP Phone 7821',
        role: 'Access Point & VoIP Priority QoS',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/8
 description AP-WIRELESS-VOIP-7821
 switchport mode access
 switchport access vlan 30
 switchport voice vlan 35
 power inline auto
 mls qos trust cos
 no shutdown`,
        showSwitchport: `Name: Gi0/8
Switchport: Enabled
Administrative Mode: static access
Operational Mode: static access
Access Mode VLAN: 30 (WLAN_DATA)
Trunking Native Mode VLAN: 1 (default)
Voice VLAN: 35 (VOIP_QOS)`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/8     AP-VOIP-DESK       connected    30         a-full   a-100 10/100/1000BaseTX`
    },
    12: {
        name: 'Gi0/12',
        title: 'Backup Storage NAS (NFS)',
        type: 'GigabitEthernet (RJ45)',
        status: 'UP',
        duplex: 'Full',
        speed: '1000 Mbps',
        vlan: '10 (LEMP_DMZ)',
        ip: '192.168.10.50/24',
        connected: 'Debian Storage Server (ZFS Pool, Automated MariaDB Dump)',
        role: 'Snapshot Storage & Backup Disktro',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/12
 description NAS-STORAGE-BACKUP-NFS
 switchport mode access
 switchport access vlan 10
 speed 1000
 duplex full
 no shutdown`,
        showSwitchport: `Name: Gi0/12
Switchport: Enabled
Administrative Mode: static access
Operational Mode: static access
Access Mode VLAN: 10 (LEMP_DMZ)
Trunking Native Mode VLAN: 1 (default)
Voice VLAN: none`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/12    NAS-NFS-STORAGE    connected    10         a-full  a-1000 10/100/1000BaseTX`
    },
    24: {
        name: 'Gi0/24',
        title: 'Proxmox VE Cluster Node',
        type: 'GigabitEthernet (RJ45 Trunk)',
        status: 'UP',
        duplex: 'Full',
        speed: '1000 Mbps',
        vlan: 'Trunk (10, 20, 30, 99)',
        ip: '192.168.99.2/24',
        connected: 'Server Virtualisasi Proxmox VE (Debian Kernel KVM/LXC)',
        role: 'Hypervisor Node & Router Virtual Lab',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/24
 description PROXMOX-VIRT-HYPERVISOR
 switchport trunk encapsulation dot1q
 switchport mode trunk
 switchport trunk allowed vlan 10,20,30,99
 spanning-tree portfast trunk
 speed 1000
 duplex full
 no shutdown`,
        showSwitchport: `Name: Gi0/24
Switchport: Enabled
Administrative Mode: trunk
Operational Mode: trunk
Administrative Trunking Encapsulation: dot1q
Operational Trunking Encapsulation: dot1q
Trunking Native Mode VLAN: 99 (HYPERVISOR_MGMT)
Trunking VLANs Enabled: 10,20,30,99`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/24    PROXMOX-HYPERV     connected    trunk      a-full  a-1000 10/100/1000BaseTX`
    },
    25: {
        name: 'Gi0/25',
        title: 'Core Router Uplink (802.1Q)',
        type: 'GigabitEthernet (SFP Fiber Uplink)',
        status: 'UP',
        duplex: 'Full',
        speed: '1000 Mbps',
        vlan: 'Trunk (VLAN ALL 1-4094)',
        ip: '192.168.1.1/24 (Gateway)',
        connected: 'Cisco 2911 Integrated Services Router (ISR) Gigabit Gateway',
        role: 'Inter-VLAN Routing & Gateway BGP/OSPF',
        statColor: 'text-emerald-400',
        ledActive: true,
        showRun: `interface GigabitEthernet0/25
 description UPLINK-TO-CISCO-2911-ROUTER
 switchport trunk encapsulation dot1q
 switchport mode trunk
 switchport trunk allowed vlan all
 switchport nonegotiate
 speed 1000
 duplex full
 no shutdown`,
        showSwitchport: `Name: Gi0/25
Switchport: Enabled
Administrative Mode: trunk
Operational Mode: trunk
Administrative Trunking Encapsulation: dot1q
Operational Trunking Encapsulation: dot1q
Trunking Native Mode VLAN: 1 (default)
Trunking VLANs Enabled: ALL`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
Gi0/25    UPLINK-CISCO-ISR   connected    trunk      a-full  a-1000 1000BaseSX-SFP`
    }
};

// Fallback generator for empty ports
const getPortInfo = (portNum) => {
    if (PORT_DATA[portNum]) {
        return PORT_DATA[portNum];
    }
    const isSfp = portNum > 24;
    const ifName = isSfp ? `Gi0/${portNum}` : `Gi0/${portNum}`;
    return {
        name: ifName,
        title: `Port Kosong (${ifName})`,
        type: isSfp ? 'SFP Fiber Slot' : 'GigabitEthernet (RJ45)',
        status: 'DOWN',
        duplex: 'Auto',
        speed: 'Auto',
        vlan: '1 (Default Unassigned)',
        ip: 'Unassigned',
        connected: 'Tidak ada patch cable terhubung',
        role: 'Port Cadangan / Expansion',
        statColor: 'text-zinc-500',
        ledActive: false,
        showRun: `interface ${ifName}
 description UNUSED-LAB-PORT
 switchport mode access
 switchport access vlan 1
 shutdown`,
        showSwitchport: `Name: ${ifName}
Switchport: Enabled
Administrative Mode: static access
Operational Mode: down
Access Mode VLAN: 1 (default)
Trunking Native Mode VLAN: 1 (default)`,
        showStatus: `Port      Name               Status       Vlan       Duplex  Speed Type
${ifName.padEnd(9)} UNASSIGNED-PORT    notconnect   1            auto    auto 10/100/1000BaseTX`
    };
};

export const initCiscoSwitch = () => {
    const chassis = document.getElementById('cisco-switch-chassis');
    if (!chassis) return;

    let currentPort = 1;
    let currentTab = 'run'; // 'run', 'switchport', 'status'
    let currentMode = 'STAT'; // 'STAT', 'SPEED', 'DUPLEX'

    // Mode cycle: STAT -> SPEED -> DUPLEX -> STAT
    const modeBtn = chassis.querySelector('#cisco-mode-btn');
    const modeLeds = {
        STAT: chassis.querySelector('#led-mode-stat'),
        SPEED: chassis.querySelector('#led-mode-speed'),
        DUPLEX: chassis.querySelector('#led-mode-duplex')
    };

    const updateModeLeds = () => {
        Object.keys(modeLeds).forEach((modeKey) => {
            const led = modeLeds[modeKey];
            if (!led) return;
            if (modeKey === currentMode) {
                led.className = 'w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_#34d399] transition-all';
            } else {
                led.className = 'w-1.5 h-1.5 rounded-full bg-zinc-700 transition-all';
            }
        });

        // Update port LEDs appearance based on mode
        chassis.querySelectorAll('.cisco-port-btn').forEach((btn) => {
            const pNum = parseInt(btn.dataset.portNumber, 10);
            const portInfo = getPortInfo(pNum);
            const led = btn.querySelector('.port-led');
            if (!led) return;

            if (currentMode === 'STAT') {
                if (portInfo.ledActive) {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_5px_#34d399]';
                } else {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-zinc-800';
                }
            } else if (currentMode === 'SPEED') {
                if (portInfo.speed.includes('1000')) {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_5px_#34d399]';
                } else if (portInfo.speed.includes('100')) {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_5px_#fbbf24]';
                } else {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-zinc-800';
                }
            } else if (currentMode === 'DUPLEX') {
                if (portInfo.duplex === 'Full') {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_5px_#34d399]';
                } else {
                    led.className = 'port-led w-1.5 h-1.5 rounded-full bg-zinc-800';
                }
            }
        });
    };

    if (modeBtn) {
        modeBtn.addEventListener('click', () => {
            if (currentMode === 'STAT') currentMode = 'SPEED';
            else if (currentMode === 'SPEED') currentMode = 'DUPLEX';
            else currentMode = 'STAT';
            updateModeLeds();
        });
    }

    // UI elements to update
    const portNameEl = chassis.querySelector('#cisco-display-port');
    const portTitleEl = chassis.querySelector('#cisco-display-title');
    const portStatusEl = chassis.querySelector('#cisco-display-status');
    const portVlanEl = chassis.querySelector('#cisco-display-vlan');
    const portRoleEl = chassis.querySelector('#cisco-display-role');
    const portHostEl = chassis.querySelector('#cisco-display-host');
    const cliOutputEl = chassis.querySelector('#cisco-cli-output');
    const cliPromptEl = chassis.querySelector('#cisco-cli-prompt');

    const renderSelectedPort = (portNum) => {
        currentPort = portNum;
        const info = getPortInfo(portNum);

        // Update active highlight on buttons
        chassis.querySelectorAll('.cisco-port-btn').forEach((btn) => {
            const pNum = parseInt(btn.dataset.portNumber, 10);
            if (pNum === portNum) {
                btn.classList.add('ring-2', 'ring-rose-500', 'bg-zinc-800');
                btn.classList.remove('bg-zinc-900');
            } else {
                btn.classList.remove('ring-2', 'ring-rose-500', 'bg-zinc-800');
                btn.classList.add('bg-zinc-900');
            }
        });

        if (portNameEl) portNameEl.textContent = info.name;
        if (portTitleEl) portTitleEl.textContent = info.title;
        if (portStatusEl) {
            portStatusEl.textContent = `${info.status} (${info.speed} ${info.duplex})`;
            portStatusEl.className = `font-semibold ${info.statColor}`;
        }
        if (portVlanEl) portVlanEl.textContent = info.vlan;
        if (portRoleEl) portRoleEl.textContent = info.role;
        if (portHostEl) portHostEl.textContent = info.connected;

        // Render CLI Tab
        if (cliPromptEl) {
            if (currentTab === 'run') {
                cliPromptEl.textContent = `cisco-sw01# show running-config interface ${info.name}`;
            } else if (currentTab === 'switchport') {
                cliPromptEl.textContent = `cisco-sw01# show interfaces ${info.name} switchport`;
            } else {
                cliPromptEl.textContent = `cisco-sw01# show interfaces ${info.name} status`;
            }
        }

        if (cliOutputEl) {
            if (currentTab === 'run') {
                cliOutputEl.textContent = info.showRun;
            } else if (currentTab === 'switchport') {
                cliOutputEl.textContent = info.showSwitchport;
            } else {
                cliOutputEl.textContent = info.showStatus;
            }
        }
    };

    // Attach click listeners to all port buttons
    chassis.querySelectorAll('.cisco-port-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const pNum = parseInt(btn.dataset.portNumber, 10);
            renderSelectedPort(pNum);
        });
    });

    // Attach CLI tab switches
    const tabBtns = chassis.querySelectorAll('.cisco-cli-tab');
    tabBtns.forEach((tab) => {
        tab.addEventListener('click', () => {
            currentTab = tab.dataset.cliTab;
            tabBtns.forEach((t) => {
                if (t === tab) {
                    t.className = 'cisco-cli-tab px-3 py-1 rounded-md text-[11px] font-mono text-white bg-zinc-800 border border-zinc-700 transition-colors';
                } else {
                    t.className = 'cisco-cli-tab px-3 py-1 rounded-md text-[11px] font-mono text-zinc-400 hover:text-zinc-200 bg-transparent transition-colors';
                }
            });
            renderSelectedPort(currentPort);
        });
    });

    // Initial render
    updateModeLeds();
    renderSelectedPort(1);
};
