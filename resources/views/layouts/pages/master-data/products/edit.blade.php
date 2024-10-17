@extends('layouts.user_type.auth')

@section('content')


<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        @if(session()->has('success'))
        <div x-data="{ show: true, progress: 100 }"
            x-init="setTimeout(() => show = false, 5000); 
                      setInterval(() => { if(progress > 0) progress -= 1; }, 50)"
            x-show="show"
            class="bg-success rounded text-white py-2 px-4 position-relative"
            style="width: 300px;">
            <p class="m-0">{{ session('success') }}</p>
            <div class="progress-bar position-absolute bottom-0 start-0 bg-white"
                :style="{ width: progress + '%' }"
                style="height: 3px;">
            </div>
        </div>
        @endif

        <form action="{{ route('updateProducts', $editProducts->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Section -->
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add Product</h5>
                            <a href="{{ route('indexProducts') }}" class="btn bg-gradient-primary btn-sm mb-0 text-white">
                                <&nbsp; Back</a>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="px-4 pt-4">
                                    
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" placeholder="Enter product name" value="{{ old('name', $editProducts->name) }}">
                                                @error('name')
                                                <div class="alert alert-danger mt-2" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Upload Files <span class="text-danger">*</span></label>
                                                <div class="dropzone" id="kt_dropzonejs_example_1" style="border: 2px dashed #007bff; padding: 20px; border-radius: 10px; background-color: #f8f9fa; text-align: center;">
                                                    <div class="dz-message needsclick">
                                                        <i class="ki-duotone ki-file-up fs-3x text-primary" style="font-size: 40px;"><span class="path1"></span><span class="path2"></span></i>
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                            <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                   

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="price" class="form-label">Product Price <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                    id="price" name="price" placeholder="Enter product price" value="{{ old('price', $editProducts->price) }}">
                                                @error('price')
                                                <div class="alert alert-danger mt-2" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attribute Section -->
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5 class="mb-0">Add Product Attribute</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="px-4 pt-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="header" class="form-label">Header Attribute <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('header') is-invalid @enderror"
                                                    id="header" name="header" placeholder="Enter header Attribute">
                                                @error('header')
                                                <div class="alert alert-danger mt-2" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="body" class="form-label">Body</label>
                                                <textarea id="request" name="body" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="footer" class="form-label">Footer Attribute <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('footer') is-invalid @enderror"
                                                    id="footer" name="footer" placeholder="Enter footer Attribute">
                                                @error('footer')
                                                <div class="alert alert-danger mt-2" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn bg-gradient-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    new FroalaEditor('#request', {
        events: {
            'contentChanged': function() {
                var content = this.html.get();
                document.getElementById('request').value = content;
            }
        }
    });

    var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
        url: "{{ route('storeProducts') }}",
        paramName: "images[]", // The name that will be used to transfer the file
        maxFiles: 10,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg,image/png,image/jpg,image/gif,image/webp', // Allow only specific file types
        accept: function(file, done) {
            if (file.name == "wow.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        }
    });
</script>

@endsection