# Resilient download script for doctor photos
# - Retries each download with exponential backoff
# - On persistent failure writes a 1x1 PNG placeholder to the target path

$jobs = @(
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=7'; Out='public/images/doctor-photo-7.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=8'; Out='public/images/doctor-photo-8.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=9'; Out='public/images/doctor-photo-9.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=10'; Out='public/images/doctor-photo-10.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=11'; Out='public/images/doctor-photo-11.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=12'; Out='public/images/doctor-photo-12.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=13'; Out='public/images/doctor-photo-13.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=14'; Out='public/images/doctor-photo-14.jpg'},
  @{Url='https://source.unsplash.com/400x400/?doctor,white%20coat,portrait&sig=15'; Out='public/images/doctor-photo-15.jpg'}
)

# Minimal 1x1 PNG placeholder (base64)
$placeholderBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII='

if (-not (Test-Path -Path 'public/images')) { New-Item -ItemType Directory -Path 'public/images' | Out-Null }

$maxRetries = 5
foreach ($j in $jobs) {
  $url = $j.Url
  $out = $j.Out
  $succeeded = $false
  for ($i = 1; $i -le $maxRetries; $i++) {
    try {
      Invoke-WebRequest -Uri $url -OutFile $out -TimeoutSec 30 -ErrorAction Stop
      Write-Host "OK: $out"
      $succeeded = $true
      break
    } catch {
      $msg = $_.Exception.Message
      Write-Host "Attempt $i failed for $out -> $msg"
      if ($i -lt $maxRetries) {
        $sleep = [math]::Min(30, [math]::Pow(2, $i))
        Write-Host "Waiting $sleep seconds before retrying..."
        Start-Sleep -Seconds $sleep
      }
    }
  }
  if (-not $succeeded) {
    Write-Host "Writing placeholder for $out"
    [IO.File]::WriteAllBytes($out, [Convert]::FromBase64String($placeholderBase64))
  }
}

Write-Host "Done."
