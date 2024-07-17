@extends('layouts.app', ['class' => 'bg-gray-100'])

@section('content')
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card mb-4 border-radius-md shadow-md">
                    <div class="card-header pb-0 m-auto">
                    <a class="align-items-center d-flex" href="">
                    <img style="width: 55px; height: 55px;" src="https://southernleyte.gov.ph/wp-content/uploads/2023/03/Province-Logo.png" class="ms-2 mb-3" alt="...">
                    <span class="sidebar-text fw-bolder fs-4 ms-2">
                        DTS
                        <p style="font-size: 10px;">Document Tracking System</p>
                    </span>
                    </a>
                    </div>
                        <hr class="horizontal dark mt-0">
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card mb-4 border-radius-md shadow-md">
                    <div class="card-header pb-0">
                        <div class="align-items-center">
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-secret me-1"></i> Log In</h5> 
                            <p class="text-sm">Sign In with your account credetials to proceed</p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4 mt-0">
                        <form role="form" id="sign-in">
                            @csrf
                            @method('post')
                            <div class="flex flex-col mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email')}}" placeholder="example@gmail.com" aria-label="Email" required>
                                @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="flex flex-col mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" aria-label="Password" id="password" placeholder="Password" required>
                                @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="remember" type="checkbox" id="show-password">
                                <label class="form-check-label" for="">Show Password</label>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg bg-dark text-white btn-lg w-100 mt-4 mb-0">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
