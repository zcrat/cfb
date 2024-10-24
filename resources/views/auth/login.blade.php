@extends('layouts.app')

@section('content')
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">

        <div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="{{asset('img/logo_cfb_circle.png')}}" class="brand_logo" alt="Logo">
					</div>
                </div>
              
                <div class="d-flex justify-content-center form_container">
                <form method="POST" action="{{ route('login') }}">
                        @csrf
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" id="email" type="email" name="email" class="form-control input_user  @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input id="password" type="password" class="form-control input_pass @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" >
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
							
								<label class="custom-control-label" for="customControlInline">Remember me</label>
							</div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3 login_container">
                    <button type="submit" name="button" class="btn login_btn">Login</button>
                   
                   
                </div>
                        </form>
				</div>
				
                
               
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
					
					</div>
					<div class="d-flex justify-content-center links">
                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Olvidaste du password?
                                    </a>
                     @endif
					</div>
                </div>
              
			</div>
		</div>
	</div>   

    
@endsection
