<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
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
            width: 100%;
            gap: 10px;
            padding: 10px;
        }

        .input_field {
            width: 30%;
            height: 36px;
            padding: 0 0 0 12px;
            border-radius: 5px !important;
            outline: none;
            border: 1px solid #e5e5e5;
            filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
            transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
            color: #000;
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
                    <h2 class="h2_font title">Add category</h2>
                    <form action="{{ url('add_category') }}" class="form" method="POST">
                        @csrf
                        <input type="text" name="category" placeholder="Add category" class="input_field">
                        <button>Add</button>
                    </form>
                </div>
                <table class="center table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($data as $item)
                        <tr>
                            <td style="width:60%">
                                <span id="categoryName_{{ $item->id }}">{{ $item->category_name }}</span>

                            </td>
                            <td style="width:40%">
                                <a href="{{ url('edit_category', $item->id) }}" class="btn btn-info">Edit</a>
                                <a onclick="return confirm('Are you sure you want to delete this???')"
                                    href="{{ url('delete_category', $item->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
        <!-- page-body-wrapper ends -->

        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        
</body>

</html>
