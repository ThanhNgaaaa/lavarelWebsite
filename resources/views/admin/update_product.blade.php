<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}
    <!-- Required meta tags -->
    <base href="/public">
    @include('admin.css')
    <style type="text/css">
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

        .form-group {
            display: flex;
            align-items: center;
        }

        .input_file {}
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
                <div class="div_center card coupons">
                    <h2 class="h2_font title">Update product</h2>
                    <form action="{{ url('update_product_confirm', $product->id) }}" class="form frm-add" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class=" font_size col-md-2 control-label" for="product_name">Name:</label>
                            <div class="col-md-6">
                                <input id="product_name" name="product_name" placeholder="Product name"
                                    class="input_field form-control " required="" type="text"
                                    value="{{ $product->title }}">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="product_description">Description</label>
                            <div class="col-md-6">
                                <input id="product_description" name="product_description"
                                    placeholder="Product description" class=" input_field form-control input-md"
                                    required="" type="text" value="{{ $product->description }}">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="product_categorie">Category</label>
                            <div class="col-md-6">
                                @php
                                    $categoryId = $product->category;
                                    $cate = \App\Models\category::find($categoryId);
                                    $catename = $cate->category_name;
                                @endphp

                                <select id="product_categorie" name="product_categorie" required=""
                                    class="select_field">
                                    <option value="{{ $product->category }}">{{ $catename }}</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" font_size col-md-2 control-label" for="product_image">Current Image:</label>
                            <div class="col-md-6">
                                <img height="100" width="100" src="/product/{{ $product->image }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" font_size col-md-2 control-label" for="product_image">Choose Image:</label>
                            <div class="col-md-6">
                                <input id="product_image" name="product_image" class="input_file" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="product_quantity">Quantity</label>
                            <div class="col-md-6">
                                <input id="product_quantity" name="product_quantity" placeholder="Quantity"
                                    class=" input_field form-control input-md" required="" type="number"
                                    min="0" value="{{ $product->quantity }}">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="price">Price</label>
                            <div class="col-md-6">
                                <input id="price" name="product_price" placeholder="Price"
                                    class="input_field form-control input-md" required="" type="number"
                                    min="0" value="{{ $product->price }}" step="0.01">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="percentage_discount">Discount</label>
                            <div class="col-md-6">
                                <input id="percentage_discount" name="product_discount" placeholder="Discount"
                                    class="input_field form-control input-md" required="" type="number"
                                    min="0" value="{{ $product->discount_price }}" step="0.01">

                            </div>
                        </div>
                        <div>
                            <button type="submit" class="ml-60 btn btn-default">Update</button>

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
