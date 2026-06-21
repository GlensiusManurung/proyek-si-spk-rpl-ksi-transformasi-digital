@extends('layouts.app')

@section('title','Contact')

@section('vite')
@vite(['resources/css/contact.css','resources/js/contact.js'])
@endsection

@section('content')

<section class="contact-section">

<div class="contact-container">

<div class="contact-form">

<h1>Contact</h1>

<form id="contactForm">

<label>Name</label>
<input type="text" name="name" placeholder="Input Field" required>

<label>Email</label>
<input type="email" name="email" placeholder="Input Field" required>

<label>Subject</label>
<input type="text" name="subject" placeholder="Input Field">

<label>Message</label>
<textarea name="message" placeholder="Input Field"></textarea>

<button type="submit" class="btn-send">
SEND MESSAGE
</button>

</form>

</div>

<div class="contact-image">
<div class="image-placeholder"></div>
</div>

</div>

</section>


<section class="offices">

<div class="office-container">

<div class="office">
<h3>Our offices</h3>
<p>
Find our offices around the world and feel free to pay us a visit!
</p>
</div>

<div class="office">
<h3>Copenhagen</h3>
<p>Frederiksberg</p>
<p>Nordhavn</p>
<p>Sydhavn</p>
</div>

<div class="office">
<h3>London</h3>
<p>Hackney Wick</p>
<p>Brixton</p>
<p>Elephant & Castle</p>
</div>

</div>

</section>


<section class="map-section">

<h2>Find us here</h2>

<div class="map-placeholder"></div>

</section>

@endsection