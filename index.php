<?php
// Fetch metadata from GCP metadata server
function get_metadata($path) {
    $url = "http://metadata.google.internal/computeMetadata/v1/" . $path;
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "Metadata-Flavor: Google"
        ]
    ];
    $context = stream_context_create($opts);
    return @file_get_contents($url, false, $context);
}

// Collect instance info
$instance_name = get_metadata("instance/name");
$zone_path     = get_metadata("instance/zone");
$zone          = $zone_path ? basename($zone_path) : null;
$internal_ip   = get_metadata("instance/network-interfaces/0/ip");
$external_ip   = get_metadata("instance/network-interfaces/0/access-configs/0/external-ip");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mahendra's Demo App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Roboto, sans-serif;
      background: linear-gradient(135deg, #4285F4, #34A853);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .card {
      background: #fff;
      color: #333;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      max-width: 500px;
      width: 100%;
      text-align: center;
      animation: fadeIn 0.8s ease-out;
    }
    .logo {
      width: 100px;
      margin-bottom: 1rem;
    }
    h1 {
      margin-bottom: 1rem;
      font-size: 1.8rem;
      color: #202124;
    }
    .detail {
      margin: 1rem 0;
      padding: 1rem;
      border-radius: 8px;
      background: #f1f3f4;
      font-size: 1.1rem;
      text-align: left;
    }
    .label {
      font-weight: bold;
      color: #4285F4;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    footer {
      margin-top: 1.5rem;
      font-size: 0.85rem;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="card">
    <img src="https://images.seeklogo.com/logo-png/33/1/google-cloud-logo-png_seeklogo-336116.png" 
         alt="Google Cloud Logo" class="logo">
    <h1>🚀 Google Cloud VM Details</h1>
    <div class="detail"><span class="label">Instance Name:</span> <?= htmlspecialchars($instance_name) ?></div>
    <div class="detail"><span class="label">Zone:</span> <?= htmlspecialchars($zone) ?></div>
    <div class="detail"><span class="label">Internal IP:</span> <?= htmlspecialchars($internal_ip) ?></div>
    <div class="detail"><span class="label">External IP:</span> <?= htmlspecialchars($external_ip) ?></div>
    <footer>Rendered by PHP inside your GCP VM</footer>
  </div>
</body>
</html>
