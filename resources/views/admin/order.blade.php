<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
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

        .image_size {
            /* height: ;
            width: ; */
        }

        th,
        td {
            padding: 15px;
            word-wrap: break-word;
        }
        tr:hover {background-color: coral;}
        .input_search{
            width: 80%;
            border-radius: 10px !important;
            margin: 0 0 10px 10px;
            color: #000;
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
                <div>
                    <form action="{{url('search')}}" method="get">
                        <input type="text" name="search" class="input_search" placeholder="Search ...">
                        <button type="submit" class="btn btn-info">Search</button>
                    </form>
                </div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="container">
                    <div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    {{-- <th>Address</th> --}}
                                    <th>Phone</th>
                                    <th>Product Title</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Payment Status</th>
                                    <th>Delivery Status</th>
                                    <th>Image</th>
                                    <th>Delivered</th>
                                    <th>Send Email</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                @forelse ($order as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        {{-- <td>{{ $item->address }}</td> --}}
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->product_title }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->payment_status }}</td>
                                        <td>{{ $item->delivery_status }}</td>
                                        <td>
                                            <img class="image_size" src="/product/{{ $item->image }}" />
                                        </td>
                                        <td>
                                            @if ($item->delivery_status == 'processing')
                                                <a onclick="return confirm('Are you sure this product is delivered???')"
                                                    href="{{ url('delivered', $item->id) }}"
                                                    class="btn m-2 btn-info">Delivered</a>
                                                {{-- <a onclick="return confirm('Are you sure you want to delete this???')"
                                                href="{{ url('delete_product', $item->id) }}"
                                                class="btn btn-danger">Delete</a> --}}
                                            @else
                                                <p>Delivered</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ url('send_email', $item->id) }}">Send
                                                Email</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" style="text-align:center">
                                            No data found
                                        </td>
                                    </tr>
                                    
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- page-body-wrapper ends -->

        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
</body>

</html>
