@extends('layouts.app')

@section('title', 'Account')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">

                            <h2>My account</h2>

                            <div class="panel panel-transparent">
                                <ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white" id="tab-3">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab3hellowWorld">My informations</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#tab3FollowUs">Subscription</a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#tab3Inspire">Misc.</a>
                                    </li>
                                </ul>
                                <div class="tab-content bg-white">
                                    <div class="tab-pane" id="tab3hellowWorld">
                                        <div class="row column-seperation">
                                            <div class="col-md-6">
                                                <h3>
                                                    <span class="semi-bold">Sometimes </span>Small things in life
                                                    means the most
                                                </h3>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="semi-bold">
                                                    great tabs
                                                </h3>
                                                <p>Native boostrap tabs customized to Pages look and feel, simply changing class name you can change color as well as its animations</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane active" id="tab3FollowUs">
                                        <h3>
                                            “ Nothing is <span class="semi-bold">impossible</span>, the word
                                            itself says 'I'm <span class="semi-bold">possible</span>'! ”
                                        </h3>
                                        <p>
                                            A style represents visual customizations on top of a layout. By editing a style, you can use Squarespace's visual interface to customize your...
                                        </p>
                                        <br>
                                        <p class="pull-right">
                                            <button class="btn btn-default btn-cons" type="button">White</button>
                                            <button class="btn btn-success btn-cons" type="button">Success</button>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="tab3Inspire">
                                        <h3>
                                            Follow us &amp; get updated!
                                        </h3>
                                        <p>
                                            Instantly connect to what's most important to you. Follow your friends, experts, favorite celebrities, and breaking news.
                                        </p>
                                        <br>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection