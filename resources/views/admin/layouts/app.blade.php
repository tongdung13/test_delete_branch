<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        #tnContact {
            max-width: 230px;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            bottom: 3%;
            left: 2%;
            z-index: 9999;
        }

        #tnContact li {
            list-style-type: none;
            width: 40px;
            height: 40px;
            padding: 0;
            margin-bottom: 10px;
            white-space: nowrap;
        }

        #tnContact li a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            margin-right: 15px;
            text-align: center;
            border-radius: 99px;
        }

        #tnContact li a i {
            font-size: 18px;
            color: #fff;
        }

        #tnContact li .iconzalo img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }

        #tnContact li .label {
            position: relative;
            visibility: hidden;
            cursor: pointer;
            color: #fff;
            padding: 6px 10px;
            border-radius: 0 99px 99px 0;
        }

        #tnContact li .label:before {
            content: "";
            top: 0;
            left: -15px;
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-top: 15px solid transparent;
            border-right: 15px solid #189eff;
            border-bottom: 15px solid transparent;
        }

        #tnContact li:hover .label {
            visibility: visible;

        }

        /* Background Icon & Label */
        .iconfb,
        .label.fb {
            background: #3b5999
        }

        .iconzalo,
        .label.zalo {
            background: #008df2
        }

        .iconsms,
        .label.sms {
            background: #00c300;
        }

        .iconcall,
        .label.call {
            background: #383838
        }

        .fb.label:before {
            border-right-color: #3b5999 !important
        }

        .zalo.label:before {
            border-right-color: #008df2 !important
        }

        .sms.label:before {
            border-right-color: #00c300 !important
        }

        .call.label:before {
            border-right-color: #383838 !important
        }
    </style>
</head>

<body>

    @yield('content')
    <ul id="tnContact">
        <li>
            <a href="https://messenger.com/t/temnerhome" class="iconfb" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <span class="label fb">Chat Facebook</span>
        </li>
        <li>
            <a href="https://zalo.me/0907701772" class="iconzalo" target="_blanl">
                <img src="https://webvina.net/wp-content/uploads/2021/07/icon_zalomessage.png" alt="">
            </a>
            <span class="label zalo">Nhắn tin zalo</span>
        </li>
        <li>
            <a href="sms:0907701772" class="iconsms">
                <i class="fas fa-sms"></i>
            </a>
            <span class="label sms">Nhắn tin điện thoại</span>
        </li>
        <li>
            <a href="tel:0907701772" class="iconcall">
                <i class="fas fa-phone"></i>
            </a>
            <span class="label call">Gọi điện thoại</span>
        </li>
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
