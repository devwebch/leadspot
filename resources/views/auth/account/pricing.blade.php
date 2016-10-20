@extends('layouts.app')

@section('title', 'Pricing')

@section('styles')
    <style>
        .bg-red {
            background: #b94a67;
        }
        .bg-blue {
            background: #5b9ec1;
        }
    </style>
@endsection

@section('scripts')
@endsection

@section('content')

    <!-- Start pricing -->
    <div class="p-l-30 p-r-30">
        <div class="row">
            <!-- free -->
            <div class="col-sm-3 p-l-5 p-r-5">
                <div class="pricing-headingm m-t-45">
                    <div class="bg-white p-t-60 p-b-60">
                        <h2 class="text-center m-b-25 font-montserrat">FREE</h2>
                        <p class="hint-text text-center">Try our services</p>
                    </div>
                    <div class="bg-master-lighter p-t-20 p-b-20">
                        <h5 class="block-title text-center no-margin">FREE</h5>
                    </div>
                </div>
                <div class="pricing-details bg-white p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                    <ul class="no-style">
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">One</span> user</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">60</span> company searches</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">10</span> email lookups</li>
                    </ul>
                </div>
            </div>
            <!-- /free -->
            <!-- boutique -->
            <div class="col-sm-3 p-l-5 p-r-5">
                <div class="pricing-headingm m-t-45">
                    <div class="bg-white p-t-60 p-b-60">
                        <h2 class="text-center m-b-25 font-montserrat">$49<span class="hint-text">/mo</span></h2>
                        <p class="hint-text text-center">Find real opportunities</p>
                    </div>
                    <div class="bg-info-light p-t-20 p-b-20">
                        <h5 class="block-title text-center text-white no-margin">Boutique</h5>
                    </div>
                </div>
                <div class="pricing-details bg-info-lighter p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                    <ul class="no-style">
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">One</span> user</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">1'000</span> company searches</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">500</span> email lookups</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                        <li class="text-black fs-16 normal m-b-25">&nbsp;</li>
                    </ul>
                    <div class="text-center">
                        <a href="/subscribe/boutique" class="btn btn-info btn-block btn-lg all-caps">Subscribe</a>
                    </div>
                </div>
            </div>
            <!-- /boutique -->
            <!-- company -->
            <div class="col-sm-3 p-l-5 p-r-5 xs-m-t-40">
                <div class="pricing-heading xs-p-t-10">
                    <div class="m-l-15 m-r-15 bg-red padding-10">
                        <h5 class="block-title text-center text-white no-margin">Recommended</h5>
                    </div>
                    <div class="bg-white p-t-60 p-b-60">
                        <h2 class="text-center m-b-25 font-montserrat">$129<span class="hint-text">/mo</span></h2>
                        <p class="hint-text text-center">Scale up</p>
                    </div>
                    <div class="bg-red p-t-20 p-b-20">
                        <h5 class="block-title text-center text-white no-margin">Company</h5>
                    </div>
                </div>
                <div class="pricing-details bg-danger-lighter p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                    <ul class="no-style">
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">3</span> team members</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">5'000</span> company searches</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">2'000</span> email lookups</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">PDF</span> reports</li>
                    </ul>
                    <div class="text-center">
                        <a href="/subscribe/company" class="btn btn-info btn-block btn-lg all-caps">Subscribe</a>
                    </div>
                </div>
            </div>
            <!-- /company -->
            <!-- agency -->
            <div class="col-sm-3 p-l-5 p-r-5">
                <div class="pricing-heading m-t-45 ">
                    <div class="bg-white p-t-60 p-b-60">
                        <h2 class="text-center m-b-25 font-montserrat">$499<span class="hint-text">/mo</span></h2>
                        <p class="hint-text text-center">For serious players</p>
                    </div>
                    <div class="bg-warning p-t-20 p-b-20">
                        <h5 class="block-title text-center text-white no-margin">Agency</h5>
                    </div>
                </div>
                <div class="pricing-details bg-warning-lighter p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                    <ul class="no-style">
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">Unlimited</span> team members</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">50'000</span> company searches</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">10'000</span> email lookups</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                        <li class="text-black fs-16 normal m-b-25"><span class="bold">PDF</span> reports</li>
                    </ul>
                    <div class="text-center">
                        <a href="/subscribe/agency" class="btn btn-info btn-block btn-lg all-caps">Subscribe</a>
                    </div>
                </div>
            </div>
            <!-- /agency -->
        </div>
    </div>
    <!-- End pricing -->

@endsection