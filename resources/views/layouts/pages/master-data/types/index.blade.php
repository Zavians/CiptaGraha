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
                <h5 class="mb-0">All Types</h5>
              </div>
              <button type="button" class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addTypeModal">
                <a>+&nbsp; New Types</a>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addTypeModalLabel">Add Type</h5>
                      <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('storeTypes') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter type name" value="{{ old('name') }}" required>

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
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach($dataTypes as $index => $type)
                  <tr class="text-center">
                    <td>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm text-center ">{{$index + 1}}</h6>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs text-center font-weight-bold mb-0">{{ $type->name }}</p>
                    </td>

                    <td class="align-middle">
                      <!-- Edit Button -->
                      <!-- Button to trigger modal for the specific type -->
                      <button type="button" class="btn btn-danger btn-sm bg-gradient-info mb-0" data-bs-toggle="modal" data-bs-target="#modal-update-{{$type->id}}">
                        <i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i>
                      </button>

                      <!-- Modal Structure -->
                      <div class="modal fade" id="modal-update-{{$type->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-updateLabel-{{$type->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modal-updateLabel-{{$type->id}}">Update Type</h5>
                              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('updateTypes', $type->id) }}" method="POST">
                         
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                  <label for="name" class="form-label" style="text-align: left;">Full Name</label>
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ $type->name }}" value="{{ old('name', $type->name) }}" required>

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
                      <button type="button" class="btn btn-danger btn-sm bg-gradient-danger mb-0" data-bs-toggle="modal" data-bs-target="#modal-delete" onclick="setDeleteId('{{ $type->id }}')">
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
                              <form action="{{ route('destroyTypes', $type->id) }}" method="POST">
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



@endsection