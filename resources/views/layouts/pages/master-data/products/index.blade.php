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
                            <button type="button" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                                <a>+&nbsp; New Product</a>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addTypeModalLabel">Add Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('storeProducts') }}" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <!-- Product Name -->
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Product Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter product name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                    <div class="alert alert-danger mt-2" role="alert">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                                                            <path d="M7.938 2.016a1.13 1.13 0 0 1 1.124 0l6.857 3.939c.502.289.756.84.67 1.424l-.93 6.545c-.085.594-.528 1.06-1.098 1.128l-6.857 1.375c-.57.068-1.07-.243-1.125-.696l-.93-6.546c-.086-.584.168-1.135.67-1.424L7.938 2.016zM7.002.663a1.968 1.968 0 0 0-1.977 0L.167 4.602a2.307 2.307 0 0 0-1.352 2.087L0 14.076c0 .841.677 1.571 1.515 1.673L8.374 16c.839.103 1.536-.526 1.536-1.366v-9.937c0-.841-.677-1.571-1.515-1.673L7.002.663zM1 6h14v2H1V6zm1.55-3a.72.72 0 1 1 1.44 0 .72.72 0 0 1-1.44 0z" />
                                                        </svg>
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <!-- Product Images -->
                                                <div class="mb-3">
                                                    <label for="images" class="form-label">Product Images</label>
                                                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                                                    @error('images')
                                                    <div class="alert alert-danger mt-2" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <!-- Product Price -->
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Product Price</label>
                                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Enter product price" value="{{ old('price') }}" required>
                                                    @error('price')
                                                    <div class="alert alert-danger mt-2" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


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

                                        <td>
                                            <div class="row">
                                                <div class="col-md-8 mx-auto">
                                                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-indicators">
                                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                        </div>
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img src="https://images.unsplash.com/photo-1537511446984-935f663eb1f4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=80" class="d-block w-100" alt="...">
                                                            </div>
                                                            <div class="carousel-item">
                                                                <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=80" class="d-block w-100" alt="...">
                                                            </div>

                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
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
                                            <button type="button" class="btn btn-danger btn-sm bg-gradient-info mb-0" data-bs-toggle="modal" data-bs-target="#modal-update-{{$product->id}}">
                                                <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                                            </button>

                                            <!-- Modal Structure -->
                                            <div class="modal fade" id="modal-update-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-updateLabel-{{$product->id}}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-updateLabel-{{$product->id}}">Update Type</h5>
                                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('updateTypes', $product->id) }}" method="POST">

                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label" style="text-align: left;">Full Name</label>
                                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ $product->name }}" value="{{ old('name', $product->name) }}" required>

                                                                    @error('name')
                                                                    <div class="alert alert-danger mt-2 d-flex align-items-center" role="alert">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                                                                            <path d="M7.938 2.016a1.13 1.13 0 0 1 1.124 0l6.857 3.939c.502.289.756.84.67 1.424l-.93 6.545c-.085.594-.528 1.06-1.098 1.128l-6.857 1.375c-.57.068-1.07-.243-1.125-.696l-.93-6.546c-.086-.584.168-1.135.67-1.424L7.938 2.016zM7.002.663a1.968 1.968 0 0 0-1.977 0L.167 4.602a2.307 2.307 0 0 0-1.352 2.087L0 14.076c0 .841.677 1.571 1.515 1.673L8.374 16c.839.103 1.536-.526 1.536-1.366v-9.937c0-.841-.677-1.571-1.515-1.673L7.002.663zM1 6h14v2H1V6zm1.55-3a.72.72 0 1 1 1.44 0 .72.72 0 0 1-1.44 0z" />
                                                                        </svg>
                                                                        <span>{{ $message }}</span>
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn bg-gradient-info">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



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