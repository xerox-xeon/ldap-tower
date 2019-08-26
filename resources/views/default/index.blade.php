<!DOCTYPE html>
<html>
<head>
    <title>{{ $site_name }}站点部署中</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
        body { text-align: center; padding: 10%; font: 20px Helvetica, sans-serif; color: #333; }
        h1 { font-size: 50px; margin: 0; }
        article { display: block; text-align: left; max-width: 650px; margin: 0 auto; }
        a { color: #dc8100; text-decoration: none; }
        a:hover { color: #333; text-decoration: none; }
        @media only screen and (max-width : 480px) {
            h1 { font-size: 40px; }
        }
    </style>
</head>
<body>
<article>
    <h1>站点正在部署中</h1>
    <p><b>站点名称:</b> {{ $site_name  }} </p>
    <p><b>站点ID:</b> {{ $site_id  }} </p>
    <p><b>站点目录：</b>{{ $site_path }}</p>
    <p id="signature">&mdash; <a href="javascript:;">[请联系客服咨询进度]</a></p>
</article>
</body>
</html>