<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
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
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    @include('home.header')
    <!-- Navbar End -->
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            @if (session()->has('message'))
                <div id="alertMessage" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="row_single-product">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="/product/{{ $product->image }}" alt="Product Image">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->title }}</h3>
                        @if ($product->discount_price > 0)
                            {
                            <p class="single-product-discount-pricing"><span>Per Kg</span>
                                ${{ $product->discount_price }}
                            </p>
                            <p class="single-product-pricing">${{ $product->price }}</p>
                            }
                        @else
                            <p class="single-product-discount-pricing">${{ $product->price }}</p>
                        @endif

                        <p>{{ $product->description }}</p>
                        <div class="single-product-form">
                            <form action="{{ url('add_cart', $product->id) }}" method="post" class="add-product-form">
                                @csrf
                                <div>
                                    <input class="input_add-cart" type="number" name="quantity" id="quantityInput"
                                        value="1" min="1" max="{{ $product->quantity }}" step="0.1">
                                    <span>Available {{ $product->quantity }} </span>
                                    <span id="maxQuantityError" style="color: red; display: none;">Số lượng vượt quá
                                        giới hạn.</span>
                                </div>
                                <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to
                                    Cart</button>
                            </form>

                            <p><strong>Categories: </strong>{{ $product->category }}</p>
                        </div>
                        <h4>Share:</h4>
                        <ul class="product-share">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

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
    <script>
        var quantityInput = document.getElementById("quantityInput");
        var maxQuantityError = document.getElementById("maxQuantityError");

        quantityInput.addEventListener("input", function() {
            var quantity = parseFloat(quantityInput.value);
            var maxQuantity = parseFloat(quantityInput.max);

            if (quantity > maxQuantity) {
                quantityInput.value = maxQuantity;
                maxQuantityError.style.display = "block";
            } else {
                maxQuantityError.style.display = "none";
            }
        });
    </script>
    <script>
        // Tự động ẩn thông báo sau 2 giây
        setTimeout(function() {
            var alertMessage = document.getElementById("alertMessage");
            if (alertMessage) {
                alertMessage.style.display = "none";
            }
        }, 2000); // 2000 milliseconds = 2 seconds
    </script>

    <!-- Template Javascript -->
    <script src="home/js/main.js"></script>
</body>

</html>
