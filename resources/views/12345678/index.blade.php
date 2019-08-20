<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=0">
    <title>481棋牌</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ url('/asset/css/m.css') }}">
    <script src="<?php echo url('/asset/js/jquery.min.js') ?>" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="js/ewm.js" type="text/javascript" charset="utf-8"></script> -->
    <script type='text/javascript' charset='UTF-8' src='//res.cdn.openinstall.io/openinstall.js'></script>
    <script src="<?php echo url('/asset/js/qrcode.min.js') ?>"></script>
    <style>
        #qrcode img{
            width: 1.46rem;
            height: 1.46rem;
            position: absolute;
            right: 1.5rem;
            top: 2.2rem;
        }

        
        @media screen and (min-width: 640px) {
            #url{
                position: absolute;
                left: 73px;
                top: 16.5vh;
                color: #5c2707;
                font-size: 20px;
            }
		}

		
		@media screen and (max-width: 414px) {
			#qrcode img{
				right: 0.9rem;
				top: 1.37rem;
				width: 1rem;
            	height: 1rem;
            }
            #url{
                position: absolute;
                left: 0.9rem;
                top: 14vh;
                color: #5c2707;
                font-size: 3vw;
                font-weight: bold;
            }
		}
		@media screen and (max-width: 375px) {
			#qrcode img{
                width: 0.9rem;
                height: 0.9rem;
                position: absolute;
                right: 0.82rem;
                top: 1.24rem;
            }
            #url{
                position: absolute;
                left: 0.9rem;
                top: 1.7rem;
                color: #5c2707;
                font-size: 3vw;
                font-weight: bold;
            }
        }
        @media screen and (max-width: 320px) {
			#qrcode img{
                width: 0.78rem;
                height: 0.78rem;
                position: absolute;
                right: 0.7rem;
                top: 1.05rem;
            }
            #url{
                position: absolute;
                left: 0.75rem;
                top: 1.42rem;
                color: #5c2707;
                font-size: 3vw;
                font-weight: bold;
            }
		}

        .dw_propt {
            width: 100%;
            min-height: 1.4rem;
            background: rgba(255, 255, 255, 0.77);
            position: fixed;
            left: 0;
            bottom: 0;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.35);
        }

        .ppt_lt {
            position: relative;
        }

        .img {
            display: block;
            width: 1.25rem;
            height: 1.25rem;
            position: absolute;
            top: 0.08rem;
            left: 0.18rem;
            overflow: hidden;
        }

        .img img {
            display: block;
            width: 100%;
            height: 100%;
        }

        .ppt_lt .lt_t {
            padding: 0.20rem 0 0 1.74rem;
            color: #333;
        }

        .ppt_lt .lt_t h3 {
            font-size: 0.3rem;
        }

        .ppt_lt .lt_t span {
            font-size: 0.28rem;
            color: #545454;
            display: block;
            margin-top: 0.15rem;
        }

        .ppt_lt_ii .lt_in {
            margin: 0 0.3rem;
            position: relative;
        }

        .ppt_lt .ppt_dw {
            display: block;
            width: 80px;
            height: 0.9rem;
            line-height: 0.9rem;
            background: #43c117;
            color: #fff;
            text-align: center;
            font-size: 16px;
            border-radius: 0.08rem;
            position: absolute;
            top: 0.33rem;
            right: 0.3rem;
        }

        .ppt_lt_ii .ppt_dw {
            width: 100%;
            left: 0;
            right: 0
        }
       

    </style>
</head>
<body>
<div id="all" style="position: relative;    height: 100%;">
    <div class="bg mohe_down">
        <span id="url"></span>
        <img src="/asset/img/down.jpg">
    </div >
    <div class="dw_propt mohe_down">
        <div class="ppt_lt">
            <span class="img">
                <img src="/asset/images/kd_icon.png" alt="">
            </span>
            <div class="lt_t">
                <h3 style="margin-top: 20px;">加注册免费送88元</h3>
                <!-- <span>添加QQ免费领取8元</span> -->
            </div>
            <a class="ppt_dw mohe_down">立即下载</a>

        </div>
    </div>
    <div id="qrcode"></div>
</div>

<script>
   var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: window.location.href ,
        width:200,
        height:200,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
   }); 
</script>
<script src="/asset/js/poplar.js"></script>
<script>
    var url = document.getElementById('url');
    var hostUrl =window.location.hostname
    var str = hostUrl
    var arr=str.split('.')
    url.innerHTML = arr[1]
</script>
</body>
</html>