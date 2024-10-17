@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        @if(session()->has('success'))
        <div x-data="{ show: true, progress: 100 }"
            x-init="setTimeout(() => show = false, 5000); 
               setInterval(() => { if(progress > 0) progress -= 1; }, 50)"
            x-show="show"
            class="bg-success rounded text-white py-2 px-4 position-relative"
            style="width: 300px;">

            <p class="m-0">{{ session('success') }}</p>
            <!-- Progress Bar -->
            <div class="progress-bar position-absolute bottom-0 start-0 bg-white"
                :style="{ width: progress + '%' }"
                style="height: 3px;">
            </div>
        </div>
        @endif

        <div class="row mt-2">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Products</h5>
                            </div>
                           
                                <a href="{{ route('addIndexProducts') }}" class="btn bg-gradient-primary btn-sm mb-0 text-white" >+&nbsp; New Product</a>
                          
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Image</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($dataProducts as $index => $product)
                                    <tr class="text-center">
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm text-center ">{{$index + 1}}</h6>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="text-xs text-center font-weight-bold mb-0">{{ $product->name }}</p>
                                        </td>



                                        <!-- Bagian ini di dalam <td> -->
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-md-8 mx-auto">
                                                    <div class="d-flex justify-content-center">
                                                        <div id="carouselExampleIndicators{{$product->id}}" class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-indicators">
                                                                @if(is_array(json_decode($product->images))) <!-- Pastikan array di-decode -->
                                                                @foreach(json_decode($product->images) as $key => $image)
                                                                <button type="button" data-bs-target="#carouselExampleIndicators{{$product->id}}" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="carousel-inner" style="width: 150px; height: 100px;">
                                                                @if(is_array(json_decode($product->images))) <!-- Pastikan array di-decode -->
                                                                @foreach(json_decode($product->images) as $key => $image)
                                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                                    <img src="{{ asset($image) }}" class="d-block" style="width: 150px; height: 100px;" alt="Image">
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <p>No images available.</p>
                                                                @endif
                                                            </div>
                                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{$product->id}}" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{$product->id}}" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>






                                        <td>
                                            <p class="text-xs text-center font-weight-bold mb-0">{{ $product->price }}</p>
                                        </td>

                                        <td class="align-middle">
                                            <!-- Edit Button -->
                                            <!-- Button to trigger modal for the specific type -->
                                            
                                            <a href="{{ route('editIndexProducts', $product->id) }}" class="btn btn-danger btn-sm bg-gradient-info mb-0" ><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></a>

                                         



                                            <!-- Delete Button with Modal -->
                                            <button type="button" class="btn btn-danger btn-sm bg-gradient-danger mb-0" data-bs-toggle="modal" data-bs-target="#modal-delete" onclick="setDeleteId('{{ $product->id }}')">
                                                <i class="fa-solid fa-trash-can " style="font-size: 12px;"></i>
                                            </button>

                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="modal-title-notification">Your Attention is Required</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <div class="py-3 text-center">
                                                                <i class="ni ni-bell-55 ni-3x"></i>
                                                                <h4 class="text-gradient text-danger mt-4">You should read this!</h4>
                                                                <p class="text-wrap">Activating this function will cause your data to be deleted</p>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <form action="{{ route('destroyTypes', $product->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">OK, I Got it!</button>
                                                            </form>



                                                            <button type="button" class="btn btn-link text-dark" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addTypeModal = new bootstrap.Modal(document.getElementById('addTypeModal'));
        addTypeModal.show();
    });
</script>
@endif

<script>
    function previewImage() {
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.backgroundImage = `url(${e.target.result})`;
            };
            reader.readAsDataURL(input.files[0]); // Read the file as URL
        }
    }
</script>



@endsection