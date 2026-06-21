@extends('layouts.app')

@section('title','Welcome')

@section('vite')
@vite(['resources/css/welcome.css','resources/js/welcome.js'])
@endsection

@section('content')

<!-- HERO -->
<section class="hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 80vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;">

  <div class="hero-content">
    <h1>PT. Bintang Surya Sejati Sukses</h1>
    <p>Optimalkan Pengiriman Anda Melalui Kami</p>
    
  </div>

</section>


<!-- PRODUCTS -->
<section class="products">

<h2>Pengiriman Cepat</h2>

<div class="product-grid">

<div class="product-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Driver Profesional</h3>
<p>Check what is in stock</p>
</div>

<div class="product-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Aman</h3>
<p>Read more from our company</p>
</div>

<div class="product-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Terpercaya</h3>
<p>Meet our amazing team</p>
</div>

</div>

</section>


<!-- CTA -->
<section class="cta">
<h2>Optimalkan Sekarang</h2>
</section>


<!-- NEWSLETTER PROMO -->
<section class="newsletter-promo">

<div class="newsletter-grid">

<div class="img-placeholder large"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>

<div class="newsletter-text">
<h2>Terjamin</h2>
<p>
Akan Menjadi Pengiriman Yg Aman dan terjamin Selamat Kepada Anda
</p>

<button class="btn-outline">Sign up</button>

</div>

</div>

</section>


<!-- CAREERS -->
<section class="careers">

<div class="careers-grid">

<div class="careers-text">

<h2>Bermutu</h2>

<p>
Melayani Lebih Dari 1000 customer dan Terjamin Product Bermutu.
</p>

<button class="btn-outline">CHECK OUT</button>

</div>

<div class="img-placeholder large"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>

</div>

</section>





<!-- BLOG -->
<section class="blog">

<h2>Blog</h2>

<div class="blog-grid">

<div class="blog-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Perusahaan Terpercaya</h3>
<p>Company</p>
</div>

<div class="blog-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/pengirimandriver.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Pengiriman</h3>
<p>24 jam</p>
</div>

</div>

</section>


<!-- NEWSLETTER INPUT -->
<section class="newsletter-input">

<h2>Temui Kami Disini</h2>



</section>

@endsection