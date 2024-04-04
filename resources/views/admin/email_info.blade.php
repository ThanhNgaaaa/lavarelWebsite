<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <base href="/public">
    @include('admin.css')
    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }

        .tbl-header {
            background-color: rgba(255, 255, 255, 0.3);
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }

        .tbl-content {
            height: 360px;
            overflow-x: auto;
            margin-top: 0px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        th {
            padding: 20px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 12px;
            color: #fff;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            text-align: left;
            vertical-align: middle;
            font-weight: 300;
            font-size: 12px;
            color: #fff;
            border-bottom: solid 1px rgba(255, 255, 255, 0.1);
        }

        @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);

        .content-wrapper {
            background: -webkit-linear-gradient(left, #25c481, #25b7c4);
            background: linear-gradient(to right, #25c481, #25b7c4);
            font-family: 'Roboto', sans-serif;
        }

        .container {
            /* margin: 50px;
            margin-right:50px;  */
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        .div_center {
            text-align: center;
            padding: 40px 0;
        }

        .h2_font {
            font-size: 40px;
        }

        .title {
            width: 100%;
            height: 10px;
            position: relative;
            display: flex;
            align-items: center;
            padding-left: 20px;
            border-bottom: 1px solid #efeff3;
            font-weight: 700;
            font-size: 11px;
            color: #63656b;
            padding-bottom: 18px;
        }

        .coupons {
            border-radius: 7px;
        }

        .coupons form {
            display: flex;
            /* grid-template-columns: 1fr 80px; */
            flex-direction: column;
            width: 100%;
            gap: 10px;
            /* padding: 20px 0 0 150px; */

        }

        .font_size {
            font-size: 16px;
        }

        .input_field {
            width: 100%;
            height: 36px;
            padding: 12px 20px;
            border-radius: 5px !important;
            outline: none;
            border: 1px solid #e5e5e5;
            filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
            transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
            color: #000;
            background-color: #fff;
        }

        .select_field {
            /* font-size: 1.4rem !important; */
            width: 100%;
            height: 36px;
            border-radius: 5px !important;
            outline: none;
            border: 1px solid #e5e5e5;
            filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
            transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
            color: #000;
            background-color: #fff;
        }

        .coupons form button {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 10px 18px;
            gap: 10px;
            width: 60px;
            height: 36px;
            background: linear-gradient(180deg, #4480FF 0%, #115DFC 50%, #0550ED 100%);
            box-shadow: 0px 0.5px 0.5px #EFEFEF, 0px 1px 0.5px rgba(239, 239, 239, 0.5);
            border-radius: 5px;
            border: 0;
            font-style: normal;
            font-weight: 600;
            font-size: 12px;
            line-height: 15px;
            color: #ffffff;
        }

        .center {
            margin: auto;
            width: 50%;
            text-align: center;
            margin-top: 40px;
            border: 1px solid #fff;
        }

        label {
            font-size: 16px !important;
        }

        .input_field:focus {
            outline: none;
            border: 1px solid #000;
            background-color: #fff;
            color: #000;
        }

        .text-color {
            color: #000;
        }

        .frm-add {
            text-align: justify;
            padding: 20px 0 0 150px;
        }

        .ml-20 {
            margin-left: 60px;
        }
        .form-group{
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        @include('admin.header')
        <!-- partial:partials/_navbar.html -->

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
             <div class="container">
                <h1 style="text-align:center;font-size:25px">Send email to {{$order->email}}</h1>
                <form action="{{url('send_user_email',$order->id)}}" method="POST" class="form frm-add">
                    @csrf
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="email_greeting">Email Greeting:</label>
                        <div class="col-md-6">
                            <input id="email_greeting" name="greeting" placeholder="Email greeting"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="firstline">FirstLine:</label>
                        <div class="col-md-6">
                            <input id="firstline" name="firstline" placeholder="FirstLine"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="body">Email Body:</label>
                        <div class="col-md-6">
                            <input id="body" name="body" placeholder="Body"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="email_button">Email button:</label>
                        <div class="col-md-6">
                            <input id="email_button" name="email_button" placeholder="Email button"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="url_email">Email url:</label>
                        <div class="col-md-6">
                            <input id="url_email" name="url_email" placeholder="url_email"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" font_size col-md-2 control-label" for="lastline">Email lastline:</label>
                        <div class="col-md-6">
                            <input id="lastline" name="lastline" placeholder="Email lastline"
                                class="input_field form-control " required="" type="text">

                        </div>
                    </div>
                    <div>
                        <button type="submit" class="ml-60 btn btn-default">SEND</button>

                    </div>
                </form>
             </div>

            </div>
        </div>
        <!-- page-body-wrapper ends -->

        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
</body>

</html>
