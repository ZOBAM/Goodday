@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background-color: rgb(231, 220, 220); color: rgb(48, 46, 44);">
                    Welcome To Good Day Website, this site is currently under development.
                </div>

                <div class="card-body">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img src="{{ asset('images/slide3.png') }}" class="d-block w-100" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="{{ asset('images/slide1.png') }}" class="d-block w-100" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="{{ asset('images/slide2.png') }}" class="d-block w-100" alt="...">
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
