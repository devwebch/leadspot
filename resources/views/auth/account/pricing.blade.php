@extends('layouts.app')

@section('title', 'Pricing')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Pricing</div>
        </div>
        <div class="panel-body">

            <!-- Start pricing -->
            <div class="p-l-30 p-r-30 m-t-50">
                <div class="row">
                    <!-- free -->
                    <div class="col-sm-3 p-l-5 p-r-5">
                        <div class="pricing-headingm m-t-45">
                            <div class="bg-master-light p-t-60 p-b-60">
                                <h1 class="text-center m-b-25 font-montserrat">FREE</h1>
                                <p class="hint-text text-center">One client - one end
                                    <br> user product</p>
                            </div>
                            <div class="bg-master-darker p-t-20 p-b-20">
                                <h5 class="block-title text-center text-white no-margin">FREE</h5>
                            </div>
                        </div>
                        <div class="pricing-details bg-white p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                            <ul class="no-style">
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">One</span> user</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">60</span> company searches</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">10</span> email lookups</li>
                            </ul>
                            <p class="small-text hint-text">Use, by one client, in a single end product which end users are not charged for. </p>
                        </div>
                    </div>
                    <!-- /free -->
                    <!-- boutique -->
                    <div class="col-sm-3 p-l-5 p-r-5">
                        <div class="pricing-headingm m-t-45">
                            <div class="bg-master-light p-t-60 p-b-60">
                                <h1 class="text-center m-b-25 font-montserrat">$49/mo</h1>
                                <p class="hint-text text-center">One client - one end
                                    <br> user product</p>
                            </div>
                            <div class="bg-master-darker p-t-20 p-b-20">
                                <h5 class="block-title text-center text-white no-margin">Boutique</h5>
                            </div>
                        </div>
                        <div class="pricing-details bg-white p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                            <ul class="no-style">
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">One</span> user</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">1'000</span> company searches</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">500</span> email lookups</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                                <li class="text-black fs-16 normal m-b-25">&nbsp;</li>
                            </ul>
                            <div class="text-center">
                                <a href="#" class="btn btn-complete btn-block btn-lg all-caps">Subscribe</a>
                            </div>
                        </div>
                    </div>
                    <!-- /boutique -->
                    <!-- company -->
                    <div class="col-sm-3 p-l-5 p-r-5 xs-m-t-40">
                        <div class="pricing-heading xs-p-t-10">
                            <div class="m-l-15 m-r-15 bg-primary padding-10">
                                <h5 class="block-title text-center text-white no-margin">Recommended</h5>
                            </div>
                            <div class="bg-master-light p-t-60 p-b-60">
                                <h1 class="text-center m-b-25 font-montserrat">$129/mo</h1>
                                <p class="hint-text text-center">Many clients - one end
                                    <br> user product</p>
                            </div>
                            <div class="bg-master-darker p-t-20 p-b-20">
                                <h5 class="block-title text-center text-white no-margin">Company</h5>
                            </div>
                        </div>
                        <div class="pricing-details bg-white p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                            <ul class="no-style">
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">3</span> team members</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">5'000</span> company searches</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">2'000</span> email lookups</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">PDF</span> reports</li>
                            </ul>
                            <div class="text-center">
                                <a href="#" class="btn btn-complete btn-block btn-lg all-caps">Subscribe</a>
                            </div>
                        </div>
                    </div>
                    <!-- /company -->
                    <!-- agency -->
                    <div class="col-sm-3 p-l-5 p-r-5">
                        <div class="pricing-heading m-t-45 ">
                            <div class="bg-master-light p-t-60 p-b-60">
                                <h1 class="text-center m-b-25 font-montserrat">$499/mo</h1>
                                <p class="hint-text text-center"> client - one end
                                    <br> user product</p>
                            </div>
                            <div class="bg-master-darker p-t-20 p-b-20">
                                <h5 class="block-title text-center text-white no-margin">Agency</h5>
                            </div>
                        </div>
                        <div class="pricing-details bg-white p-t-30 p-b-30 p-l-40 p-r-40 md-p-l-20 md-p-r-20">
                            <ul class="no-style">
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">Unlimited</span> team members</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">50'000</span> company searches</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">10'000</span> email lookups</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">CMS</span> detector</li>
                                <li class="text-black fs-16 normal m-b-25"><span class="bold">PDF</span> reports</li>
                            </ul>
                            <div class="text-center">
                                <a href="#" class="btn btn-complete btn-block btn-lg all-caps">Subscribe</a>
                            </div>
                        </div>
                    </div>
                    <!-- /agency -->
                </div>
            </div>
            <!-- End pricing -->

        </div>
    </div>

@endsection