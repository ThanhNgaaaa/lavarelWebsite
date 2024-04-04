<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lavie - Organic Food Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    {{-- <link href="home/img/favicon.ico" rel="icon"> --}}
    <link rel="shortcut icon" href="home/img/favicon.png" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="home/lib/animate/animate.min.css" rel="stylesheet">
    <link href="home/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="home/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="home/css/style.css" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    @include('home.header')
    <!-- Navbar End -->
    {{-- Cart Start --}}

    <div class="cart-section mt-150 mb-150">
        <div style="margin-bottom:15px; width:100%; text-align:right; padding:0 60px;">
            <a style="color:#279EFF" href="{{ url('show_order') }}">Your Orders</a>
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            </div>
        @endif
        @if (count($cart) > 0)
            <div class="container">
                <div class="row_cart">
                    <div class="col-lg-8 col-md-12">
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead class="cart-table-head">
                                    <tr class="table-head-row">
                                        <th class="product-remove"></th>
                                        <th class="product-image">Product Image</th>
                                        <th class="product-name">Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalPrice = 0; ?>
                                    @foreach ($cart as $item)
                                        <tr class="table-body-row">
                                            <td class="product-remove">
                                                <a onclick="confirmation(event)"
                                                    href="{{ url('delete_item_cart', $item->id) }}"><i
                                                        class="far fa-window-close"></i></a>
                                            </td>
                                            <td class="product-image"><img src="/product/{{ $item->image }}"
                                                    alt="Product Image"></td>
                                            <td class="product-name">{{ $item->product_title }}</td>
                                            @php
                                                $product = \App\Models\Product::find($item->product_id);
                                                if ($product->discount_price > 0) {
                                                    $productPrice = $product ? $product->discount_price : 0;
                                                } else {
                                                    $productPrice = $product ? $product->price : 0;
                                                }

                                            @endphp

                                            <td class="product-price">${{ $productPrice }}</td>
                                            <td class="product-quantity">
                                                <form method="post" action={{ url('update_item_cart', $item->id) }}>
                                                    @csrf
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        placeholder="0">
                                                    <button type="submit">Update</button>
                                                </form>

                                            </td>
                                            <?php $totalPriceItem = $item->quantity * $productPrice; ?>
                                            <td class="product-total">${{ $totalPriceItem }}</td>
                                        </tr>
                                        <?php $totalPrice = $totalPrice + $totalPriceItem; ?>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="total-section">
                            <table class="total-table">
                                <thead class="total-table-head">
                                    <tr class="table-total-row">
                                        <th>Total</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-data">
                                        <td><strong>Subtotal: </strong></td>
                                        <td>${{ $totalPrice }}</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>Shipping: </strong></td>
                                        <td>$0</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>Total: </strong></td>
                                        <td>${{ $totalPrice }}</td>

                                    </tr>
                                </tbody>
                            </table>
                            <div class="cart-buttons">
                                <a href="{{ url('cash_order') }}" class="boxed-btn">Cash Order</a>
                                <a href="{{ url('stripe', $totalPrice) }}" class="boxed-btn black">Paying By Card</a>
                            </div>
                        </div>

                        <div class="coupon-section">
                            <h3>Apply Coupon</h3>
                            <div class="coupon-form-wrap">
                                <form action="index.html">
                                    <p><input type="text" placeholder="Coupon"></p>
                                    <p><input type="submit" value="Apply"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <div>
                    You don't have any items in your cart. Let's get shopping!
                    <a href="{{ url('/') }}" class="boxed-btn">
                        Start shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
    {{-- Cart End --}}
    <!-- Footer Start -->
    @include('home.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="home/lib/wow/wow.min.js"></script>
    <script src="home/lib/easing/easing.min.js"></script>
    <script src="home/lib/waypoints/waypoints.min.js"></script>
    <script src="home/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="home/js/main.js"></script>
    <script src="admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinjecadmin/t -->
    <!-- Plugin jadmin/s for this page -->
    <script src="admin/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="admin/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="admin/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="admin/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugadmin/in js for this page -->
    <!-- inject:jadmin/s -->
    <script src="admin/assets/js/off-canvas.js"></script>
    <script src="admin/assets/js/hoverable-collapse.js"></script>
    <script src="admin/assets/js/misc.js"></script>
    <script src="admin/assets/js/settings.js"></script>
    <script src="admin/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="admin/assets/js/dashboard.js"></script>
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);
            swal({
                    title: "Are you sure to delete this product",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                });
        }
    </script>
</body>

</html>
