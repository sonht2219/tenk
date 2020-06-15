@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trang chủ</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Email đã được xác thực. Vui lòng đăng nhập và tiếp tục sử dụng trên ứng dụng.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
