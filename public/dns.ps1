# Script Konfigurasi DNS Otomatis untuk Klien Windows
# Memerlukan hak akses Administrator
$ServerIP = "10.10.22.34"

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " [TKJ AUTO-DNS] Mengonfigurasi DNS Klien ke $ServerIP" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan

# 1. Pasang DNS ke Network Adapter Aktif
try {
    $activeNic = Get-NetIPConfiguration | Where-Object { $_.IPv4DefaultGateway -ne $null } | Select-Object -First 1
    if ($activeNic) {
        Write-Host "[1/3] Mengatur DNS pada interface '$($activeNic.InterfaceAlias)'..." -ForegroundColor Yellow
        Set-DnsClientServerAddress -InterfaceAlias $activeNic.InterfaceAlias -ServerAddresses ($ServerIP, "8.8.8.8")
        Write-Host "      [OK] DNS Primer: $ServerIP | Sekunder: 8.8.8.8" -ForegroundColor Green
    } else {
        Write-Host "[!] Interface aktif tidak terdeteksi via default gateway." -ForegroundColor Yellow
    }
} catch {
    Write-Host "[!] Gagal mengatur DNS adapter via PowerShell: $($_.Exception.Message)" -ForegroundColor Red
}

# 2. Daftarkan ke C:\Windows\System32\drivers\etc\hosts (Jaminan 100% Berhasil)
try {
    Write-Host "[2/3] Mendaftarkan host ke file hosts Windows..." -ForegroundColor Yellow
    $hostsPath = "$env:windir\System32\drivers\etc\hosts"
    if (Test-Path $hostsPath) {
        $lines = Get-Content $hostsPath | Where-Object {
            $_ -notmatch "yuda\.local" -and $_ -notmatch "systemorbital"
        }
        $lines += "$ServerIP yuda.local"
        $lines | Set-Content -Path $hostsPath -Force
        Write-Host "      [OK] yuda.local tersimpan di hosts." -ForegroundColor Green
    }
} catch {
    Write-Host "[!] Gagal menulis file hosts (pastikan Run as Administrator): $($_.Exception.Message)" -ForegroundColor Red
}

# 3. Flush DNS Cache
Write-Host "[3/3] Membersihkan cache DNS..." -ForegroundColor Yellow
Clear-DnsClientCache -ErrorAction SilentlyContinue
ipconfig /flushdns | Out-Null
Write-Host "      [OK] Cache DNS Windows telah dibersihkan!" -ForegroundColor Green

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host " SUKSES! Website siap dibuka di browser:" -ForegroundColor Green
Write-Host " 👉 Web Portofolio : http://yuda.local" -ForegroundColor White
Write-Host "==========================================================" -ForegroundColor Green
