<?php

use App\Enum\DepositChannel;
use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Enum\Status\RewardStatus;
use App\Enum\Status\TransactionStatus;
use App\Enum\Type\UserAddressType;


/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 12/11/19
 * Time: 2:42 PM
 */

//use App\Enums\PolicyScope\DefinedScopes;

return [
//    DefinedScopes::class => [
//        DefinedScopes::CAN_MANAGER_POLICIES => 'Quản lý và chỉnh sửa quyền',
//        DefinedScopes::CAN_FIX_PRODUCT_ATTRIBUTES => 'Thêm/Sửa các thuộc tính của sản phẩm',
//        DefinedScopes::CAN_USE_ADMIN_PAGE_FOR_PRODUCTS => 'Thêm/Sửa sản phẩm từ trang admin',
//        DefinedScopes::CAN_ACTION_WITH_BANNER => 'Thêm/Sửa banner',
//        DefinedScopes::CAN_ACTION_WITH_ARTICLES => 'Thêm/Sửa tin tức',
//        DefinedScopes::CAN_ACTION_WITH_REPORTS => 'Xem report từ khách',
//        DefinedScopes::CAN_UPLOAD_NEW_PRODUCT => 'Thêm sản phẩm',
//        DefinedScopes::CAN_PUSH_NOTIFICATION_FROM_ADMIN => 'Push thông báo',
//        DefinedScopes::IS_VERIFIED_SHOP => 'Shop đã được kiểm chứng',
//        DefinedScopes::CAN_ACTION_WITH_TRANSACTION => 'Thao tác với giao dịch',
//        DefinedScopes::CAN_MANAGER_VIP_PACKAGE => 'Thêm/sửa/xóa gói vip',
//        DefinedScopes::CAN_MANAGER_USERS => 'Quản lý user',
//        DefinedScopes::CAN_MANAGER_GROUP_MEMBER => 'Quản lý nhóm thành viên',
//        DefinedScopes::CAN_MANAGER_SYSTEM_BANK_ACCOUNT => 'Quản lý tài khoản ngân hàng TDHH',
//        DefinedScopes::CAN_UP_FIND_BUY_PRODUCT => 'Có thể tìm mua sản phẩm',
//        DefinedScopes::CAN_MANAGE_SHOP_EVENT => 'Quản lý sự kiện',
//        DefinedScopes::CAN_SEE_RARE_PRODUCT => 'Sản phẩm Bạc',
//        DefinedScopes::CAN_SEE_SUPER_RARE_PRODUCT => 'Sản phẩm Vàng',
//        DefinedScopes::IS_STREAM_PUBLISHER => 'Có thể stream video',
//        DefinedScopes::CAN_ACTION_WITH_SYSTEM_PRICE => 'Có thể thao tác giá hệ thống'
//    ],
//    VipPackageType::class => [
//        VipPackageType::PARTNER => 'Đối tác',
//        VipPackageType::MEMBERSHIP => 'Thành viên'
//    ],
    CommonStatus::class => [
        CommonStatus::ACTIVE => 'Hoạt động',
        CommonStatus::INACTIVE => 'Không hoạt động'
    ],
    LotteryStatus::class => [
        LotteryStatus::WAITING => 'Chưa bán',
        LotteryStatus::SOLD => 'Đã bán',
        LotteryStatus::DISABLED => 'Không hoạt động'
    ],
    LotterySessionStatus::class => [
        LotterySessionStatus::SELLING => 'Đang bán',
        LotterySessionStatus::COUNT_DOWNING => 'Đang đếm ngược',
        LotterySessionStatus::ENDING => 'Kết thúc',
        LotterySessionStatus::DELETED => 'Đã xóa'
    ],
    UserAddressType::class => [
        UserAddressType::DEFAULT => 'Mặc định',
        UserAddressType::NORMAL => 'Thường'
    ],
    RewardStatus::class => [
        RewardStatus::WAITING => 'Đang chờ nhận',
        RewardStatus::PROCESSING => 'Đang xử lý',
        RewardStatus::SHIPPING => 'Đang vận chuyển',
        RewardStatus::DONE => 'Đã nhận',
        RewardStatus::REJECTED => 'Đã hủy'
    ],
    TransactionStatus::class => [
        TransactionStatus::PENDING => 'Chờ xử lý',
        TransactionStatus::SUCCESS => 'Hoàn thành',
        TransactionStatus::REJECT => 'Đã hủy'
    ],
    DepositChannel::class => [
        DepositChannel::MOMO => 'MOMO',
        DepositChannel::PHONE_CARD => 'Thẻ cào',
        DepositChannel::TRANSFER_BANK => 'Chuyển khoản'
    ]
//    CommentTargetType::class => [
//        CommentTargetType::PRODUCT => 'Sản phẩm'
//    ],
//    StreamStatus::class => [
//        StreamStatus::WAITING => 'Đang chờ',
//        StreamStatus::STREAMING => 'Đang phát',
//        StreamStatus::DISABLED => 'Đã tắt',
//        StreamStatus::DELETED => 'Đã xóa'
//    ]
];
