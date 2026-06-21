@extends('layouts.app')

@section('title','About')

@section('vite')
@vite(['resources/css/about.css','resources/js/about.js'])
@endsection

@section('content')

<!-- HERO -->
<section class="about-hero">

<div class="about-content">

<h1>Tentang Kami</h1>

<p>
We are a creative company focused on delivering
modern digital experiences for everyone.
</p>



</div>

</section>


<!-- OUR STORY -->
<section class="about-section">

<div class="about-grid">

<div class="about-text">

<h2>Our Story</h2>

<p>
Started from a small idea, our company grew into
a passionate team dedicated to innovation,
technology, and user experience.
</p>

</div>

<div class="img-placeholder large"></div>

</div>

</section>


<!-- MISSION -->
<section class="mission-section">

<h2>Our Mission</h2>

<div class="mission-grid">

<div class="mission-card">
<h3>Innovation</h3>
<p>We create modern solutions for modern problems.</p>
</div>

<div class="mission-card">
<h3>Quality</h3>
<p>Delivering the best experience is our priority.</p>
</div>

<div class="mission-card">
<h3>Growth</h3>
<p>We grow together with our clients and community.</p>
</div>

</div>

</section>


<!-- TEAM -->
<section class="team-section">

<h2>Meet Our Team</h2>

<div class="team-grid">

<div class="team-card">
<div class="img-placeholder"style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/Glenn-opr.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 30vh; display: flex; justify-content: center; align-items: center; text-align: center; color: white;"></div>
<h3>Glensius Manurung</h3>
<p>Fullstack Developer</p>
</div>

<div class="team-card">
<div class="img-placeholder"></div>
<h3>Ardi Reza Pardede</h3>
<p>Sistem Analyst</p>
</div>



</div>

</section>


<!-- CTA -->
<section class="about-cta">

<h2>Want To Work With Us?</h2>



</section>

@endsection