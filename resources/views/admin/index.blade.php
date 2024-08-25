@extends('layout.main4')

@section('css-for-this-page')
@endsection

@section('content')
    <div class="content flex-column-fluid">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-3 bg-success rounded shadow-sm">
                    <i class="bi bi-people-fill fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Total Account</h4>
                    <p id="totalAccount" class="font-weight-bold text-white">1,000</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3 bg-danger rounded shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Total Error</h4>
                    <p id="totalError" class="font-weight-bold text-white">50</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3 bg-primary rounded shadow-sm">
                    <i class="bi bi-bar-chart-line-fill fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Total Activity</h4>
                    <p id="totalActivity" class="font-weight-bold text-white">350</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3 bg-warning rounded shadow-sm">
                    <i class="bi bi-shield-fill-minus fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Total Spam</h4>
                    <p id="totalSpam" class="font-weight-bold text-white">200</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3 bg-info rounded shadow-sm">
                    <i class="bi bi-shield-x fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Total Blacklist</h4>
                    <p id="totalBlacklist" class="font-weight-bold text-white">75</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-for-this-page')
@endsection
