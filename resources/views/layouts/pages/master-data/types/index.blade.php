@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <div class="d-flex flex-row justify-content-between">
              <div>
                <h5 class="mb-0">All Types</h5>
              </div>
              <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Types</a>
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
                    <td >
                    
                        
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm text-center ">{{$index + 1}}</h6>
                        </div>
                      
                    </td>
                    <td>
                      <p class="text-xs text-center font-weight-bold mb-0">{{ $type->name }}</p>
                    </td>
                    
                    
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
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

@endsection