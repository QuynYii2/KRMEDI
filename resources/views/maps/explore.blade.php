<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('home.Display navigation directions') }}</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link href="{{ asset('css/explore.css') }}" rel="stylesheet">
</head>
<body>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
<div id="map"></div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiZGFuaWVsbmd1eWVuMTk5MyIsImEiOiJjbG9oM29qZmMxOGd4MmpuMG41OHhzb2U0In0.6zVNE3WJd-sOkWlE-fI9ow';
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [-79.4512, 43.6568],
        zoom: 13
    });

    map.addControl(
        new MapboxDirections({
            accessToken: mapboxgl.accessToken
        }),
        'top-left'
    );
</script>

</body>
</html>
