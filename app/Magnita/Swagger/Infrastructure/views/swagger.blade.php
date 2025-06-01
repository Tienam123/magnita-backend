<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Linda Seeds API</title>

    <script src="{{ asset('assets/swagger/web-components.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/swagger/styles.min.css') }}">

    <style>
        a[href*='https://stoplight.io'] {
            display: none;
            visibility: hidden;
        }
    </style>


</head>
<body style="height: 100vh;">

<elements-api
        apiDescriptionUrl="{{ $json_url }}"
        router="hash"
        layout="responsive"
        hideSchemas="true"
        hideExport="false"
/>

<script>
  window.addEventListener('load', function () {
    setTimeout(function () {
      const links = document.querySelectorAll(`a[href*='https://stoplight.io']`);

      links.forEach((link) => {
        link.remove();
      });
    }, 5000);
  });
</script>
</body>
</html>
