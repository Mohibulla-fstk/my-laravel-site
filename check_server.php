<?php
// Server & Cloudflare Check Script

echo "<h2>Server Check for nmfashionworld.com</h2>";

// Server IP
echo "<b>Server IP:</b> " . $_SERVER['SERVER_ADDR'] . "<br>";

// Remote IP (visitor IP)
echo "<b>Remote Address:</b> " . $_SERVER['REMOTE_ADDR'] . "<br>";

// PHP Version
echo "<b>PHP Version:</b> " . phpversion() . "<br>";

// Cloudflare Headers
$cf_cache = isset($_SERVER['HTTP_CF_CACHE_STATUS']) ? $_SERVER['HTTP_CF_CACHE_STATUS'] : 'Not Set';
echo "<b>CF-Cache-Status:</b> " . $cf_cache . "<br>";

$cf_connecting_ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : 'Not Set';
echo "<b>CF-Connecting-IP:</b> " . $cf_connecting_ip . "<br>";

// Extra info
echo "<b>Server Software:</b> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

echo "<hr><p>✅ If 'CF-Cache-Status' is set or Server IP does not match your hosting IP, Cloudflare is still active.</p>";
?>
