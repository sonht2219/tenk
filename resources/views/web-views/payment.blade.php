<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thanh toán</title>
    <base href="{{url('assets')}}/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .content {
            padding: 0;
        }
        .title {
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
            background-color: #FF9800;
            padding: 10px;
            color: #fff0ff;
        }
        .amount {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #c0c5ce;
        }
        .amount input {
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 9px 15px;
            width: 50%;
        }
        .amount p {
            font-weight: 600;
        }
        .title-method {
            text-transform: uppercase;
            font-weight: 600;
            padding: 20px 10px 0 10px;
        }
        .wrap-method {
            padding: 10px 15px;
        }
        .method {
            border: 1px solid #c0c5ce;
            border-radius: 5px;
            margin: 10px 0;
            position: relative;
            height: 45px;
        }
        .method img {
            width: 30px;
            padding: 5px;
            position: absolute;
            top: 7%;
        }
        .method span {
            position: absolute;
            top: 30%;
            height: 30px;
            left: 50px;
        }
        .button-method {
            position: absolute;
            width: 100%;
            bottom: 10px;
            text-align: center;
        }
        .button-method button {
            text-transform: uppercase;
            padding: 10px 0;
            background-color: #FF9800;
            width: 95%;
            border: 1px solid #FF9800;
            border-radius: 4px;
            font-size: 16px;
            color: #fff0ff;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="title">
        Nạp Xu
    </div>

    <div class="amount">
        <p class="label">Số tiền nạp: </p>
        <input type="number" placeholder="Nhập số tiền">
    </div>

    <div class="title-method">Hình Thức Thanh Toán</div>
    <div class="wrap-method">
        <div class="method">
            <img src="https://codetay.com/wp-content/uploads/2019/06/logo-momo.png" alt=""/>
            <span>Ví MoMo</span>
        </div>
        <div class="method">
            <img src="https://lh6.ggpht.com/hBwZ9ECfWRoYg5i1VAvU8VVzNqq8LJVA3_S_pT26TTGdxrrJ-YFyl0FheDWbxUZwGg=w300" alt=""/>
            <span>Thẻ cào</span>
        </div>
        <div class="method">
            <img src="data:image/png;base64,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" alt=""/>
            <span>Chuyển khoản</span>
        </div>
    </div>

    <div class="button-method">
        <button type="button">Tiếp tục</button>
    </div>
</div>
</body>

</html>

