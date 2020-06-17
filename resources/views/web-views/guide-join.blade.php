<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hướng dẫn tham gia và thuật toán</title>
    <base href="{{url('assets')}}/">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: 'UTM Avo';
        }

        img {
            max-width: 100%;
        }

        .text-view {
            padding: .8em;
        }

        .w-100 {
            width: 100%;
        }

        .top-info {
            background: #1a1a1a;
            padding-bottom: 2em;
        }

        .post-info {
            background: #ffffff;
            padding-top: 1.5em;
        }

        .title {
            font-size: 1em;
            color: #040404;
            font-weight: 600;
            padding: 20px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #000000;
        }

        .sub-details {
            color: #666666;
        }

        .author {
            float: left;
            font-size: 80%
        }

        .seen {
            float: right;
            font-size: 80%
        }

        .seen span {
            margin-right: .5em;
        }

        /*.content,*/
        /*.content>p,*/
        /*.content p {*/
        /*    color: #CCCCCC !important;*/
        /*}*/

        .mt-1 {
            margin-top: .25rem;
        }
        .title-p {
            font-weight: 600;
            margin: 30px 0;
        }
    </style>
</head>

<body>
<div class="post-info text-view">
    <div class="title">
        HƯỚNG DẪN THAM GIA VÀ THUẬT TOÁN
    </div>

    <div class="content">
        <p class="title-p">HƯỚNG DẪN THAM GIA</p>
        <p>B1: ĐĂNG KÝ</p>
        <p>B2: NẠP XU</p>
        <p>B3: MUA PHIẾU 10K</p>
        <p>B4: QUAY SỐ ĐẾM NGƯỢC ĐỂ BIẾT NGƯỜI TRÚNG</p>
        <p>B5: NẾU BẠN TRÚNG, CHÚC MỪNG BẠN NHẬN SẢN PHẨM VÀ CHIA SẺ LÊN GÓC SHOW HÀNG</p>

        <p class="title-p">CÁCH CHƠI ĐƠN GIẢN</p>
        <p>Ví dụ: mua sản phẩm Iphone 7 plus 128GB giá 25,000,000 VNĐ.</p>
        <p>- Số phiếu 10K của sản phẩm là: 2500.</p>
        <p>- Mối phiếu 10K có giá trị là: 10,000 VNĐ và bắt đầu từ 10,000,001.</p>
        <p>- Người dùng không bị giới hạn mua số lượng phiếu, mua càng nhiều phiếu thì tỉ lệ trúng càng cao.</p>

        <p class="title-p">THUẬT TOÁN MINH BẠCH</p>
        <p>1. Sau khi bán hết phiếu của sản phẩm, xác định 100 giao dịch cuối cùng trên hệ thống.</p>
        <p>2. Lấy tổng thời gian của 100 giao dịch đó theo mili giây.</p>
        <p>3. Dùng tổng thời gian chia cho tổng số phiếu của sản phẩm -> ra số dư -> dùng số dư cộng với 10,000,001 -> kết quả. </p>

        <p class="title-p">CÔNG THỨC TÍNH THUẬT TOÁN</p>
        <p>(Sử dụng hàm MOD là hàm trả về số dư trong bảng tính EXCEL)</p>
        <p>MOD(Thời gian, Tổng số) + giá trị cố định</p>
        <p>Trong đó: </p>
        <p>* Thời gian: là tổng số thời gian của 100 lượt mua cuối cùng của sản phẩm.</p>
        <p>* Tổng số: là tổng số phiếu cần mua của sản phẩm.</p>
        <p>* Giá trị cố định: là giá trị không thay đổi trong công thức, luôn bằng 10000001.</p>
        <p>Ví dụ: Bạn chọn mua sản phẩm Iphone X. (Thời gian = 12556626823; Tổng số phiếu Iphone X: 3500; Giá trị cố định không đổi: 10000001)</p>
        <p>= MOD(12556626823, 3500) + 10000001 = 2323 + 10000001 = 10002324</p>
        <p>Ô kết quả thuật toán tính được trùng với số phiếu bạn đã mua thì bạn là người trúng thưởng.</p>
    </div>
</div>


</body>

</html>
