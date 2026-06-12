<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <style>
        .carousel-item .row > div {
            padding: 0 10px;
        }
        .carousel-item img {
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="banner-container">
        <img src="{{ asset('/images_cus/background/milk-ghee.jpg') }}" alt="DairyFresh" style="width: 100%; object-fit: cover;">
        <img src="{{ asset('/images_cus/logo/dairy_fresh_transparent.png') }}" alt="DairyFresh" class="logo-show">
    </div>

    <div class="container mt-4">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        @foreach($data['products_view'] as $slider)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img
                    src="{{$slider->image_url }}"
                    class="d-block w-100"
                    alt="{{ $slider->name }}"
                >
            </div>
        @endforeach

    </div>

    <button class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>