<!DOCTYPE html>
<html>
<head>
    <title>Test HTTPS Configuration</title>
    <script>
        console.log('Protocol:', window.location.protocol);
        console.log('Host:', window.location.host);
        console.log('Origin:', window.location.origin);
        
        // Test if secure_asset is working
        console.log('Testing secure_asset configuration...');
        
        // Check if all links are HTTPS
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a, img, link, script[src]');
            links.forEach(function(el) {
                const url = el.href || el.src;
                if (url && url.startsWith('http://')) {
                    console.warn('Found HTTP URL:', url);
                }
            });
        });
    </script>
</head>
<body>
    <h1>HTTPS Configuration Test</h1>
    <p>Protocol: <span id="protocol"></span></p>
    <p>Host: <span id="host"></span></p>
    <p>Origin: <span id="origin"></span></p>
    
    <script>
        document.getElementById('protocol').textContent = window.location.protocol;
        document.getElementById('host').textContent = window.location.host;
        document.getElementById('origin').textContent = window.location.origin;
    </script>
</body>
</html>
