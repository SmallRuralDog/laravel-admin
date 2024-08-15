<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ data_get($config,'title') }}</title>
    <link rel="stylesheet" href="/admin/amis/{{$amisVersion}}/sdk.css"/>
    {!! $darkCss !!}
    <link rel="stylesheet" href="/admin/amis/{{$amisVersion}}/helper.css"/>
    <link rel="stylesheet" href="/admin/amis/{{$amisVersion}}/iconfont.css"/>
    <script type="text/javascript" src="/admin/amis/{{$amisVersion}}/sdk.js"></script>
    <script>
        window.AmisAdmin = @json($config);
    </script>
</head>
<body>
<div id="app"></div>
{{vite_assets()}}
</body>
</html>
