<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Larecta Admin</title>
    <script type="module" crossorigin src="/admin/assets/js/main.js"></script>
    <link rel="stylesheet" href="/admin/assets/css/main.css">
  </head>
  <body>
    <div id="root"></div>
    <style>
        dx-license {
            display: none !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var licenseElement = document.querySelector('dx-license');
            if (licenseElement) {
                licenseElement.remove();
            }
        });
    </script>
  </body>
</html>
