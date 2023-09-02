    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Lengkap') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="alert alert-danger alert-block small">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                        
                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                                    <div class="col-md-6">
                                        <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" placeholder="contoh : user.lastname">
                                        @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="{{ asset('img/logo-ppid3.png')}}" alt=""/>
                        <p style="color: #ffffff;">Klik <a href="/ppid/login"><b>Login</b></a> jika sudah terdaftar di web PPID</p>
                    </div>
                    <div class="col-md-9 register-right">
                        <div class="tab-content" id="myTabContent" style="margin-top: -10%;">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form>
                                    <div class="row register-form">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Nama Depan *" value="" />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Nama Belakang *" value="" />
                                            </div>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Email *" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="No. Telepon *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control"  placeholder="Konfirmasi Password *" value="" />
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary rounded-lg" style="margin-right: 2%;">Register</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenis_pemohon" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Pemohon') }}</label>
                                </form>
                            </div>
                            {{-- <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h4  class="register-heading">Apply as a Hirer</h4>
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_pemohon" id="jenis_pemohon1" value="Perorangan" checked>
                                          <label class="form-check-label" for="jenis_pemohon">
                                            Perorangan
                                          </label>
                                        </div>  
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_pemohon" id="jenis_pemohon2" value="Sekelompok Orang">
                                          <label class="form-check-label" for="jenis_pemohon">
                                            Sekelompok Orang
                                          </label>
                                        </div>   
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_pemohon" id="jenis_pemohon3" value="Badan Hukum">
                                          <label class="form-check-label" for="jenis_pemohon">
                                            Badan Hukum
                                          </label>
                                        </div>                                                                            
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alamat E-Mail') }}</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="First Name *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Last Name *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" maxlength="10" minlength="10" class="form-control" placeholder="Phone *" value="" />
                                        </div>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenis_identitas" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Identitas') }}</label>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas1" value="KTP" checked>
                                          <label class="form-check-label" for="jenis_identitas">
                                            KTP
                                          </label>
                                        </div>  
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas2" value="SIM">
                                          <label class="form-check-label" for="jenis_identitas">
                                            SIM
                                          </label>
                                        </div>   
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas3" value="Paspor">
                                          <label class="form-check-label" for="jenis_identitas">
                                            Paspor
                                          </label>
                                        </div>                                                                          
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas4" value="NPWP">
                                          <label class="form-check-label" for="jenis_identitas">
                                            NPWP
                                          </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" value="" />
                                        </div>
                                    </div>
                                </div>                          
                                <div class="form-group row">
                                    <label for="nomor_identitas" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Identitas') }}</label>
                                    <div class="col-md-6">
                                        <input id="nomor_identitas" type="text" class="form-control @error('nomor_identitas') is-invalid @enderror" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required autocomplete="nomor_identitas">
                                        @error('nomor_identitas')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="alamat" name="alamat" rows="5">{{ old('alamat') }}</textarea>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Confirm Password *" value="" />
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_ponsel" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Ponsel') }}</label>
                                    <div class="col-md-6">
                                        <input id="nomor_ponsel" type="tel" class="form-control @error('nomor_ponsel') is-invalid @enderror" name="nomor_ponsel" value="{{ old('nomor_ponsel') }}" required autocomplete="nomor_ponsel">
                                        @error('nomor_ponsel')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <label for="pekerjaan" class="col-md-4 col-form-label text-md-right">{{ __('Pekerjaan') }}</label>
                                    <div class="col-md-6">
                                        <input id="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ old('pekerjaan') }}" required autocomplete="pekerjaan">
                                        @error('pekerjaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <label for="instansi" class="col-md-4 col-form-label text-md-right">{{ __('Instansi') }}</label>
                                    <div class="col-md-6">
                                        <input id="instansi" type="text" class="form-control @error('instansi') is-invalid @enderror" name="instansi" value="{{ old('instansi') }}" required autocomplete="instansi">
                                        @error('instansi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                        
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option class="hidden"  selected disabled>Please select your Sequrity Question</option>
                                                <option>What is your Birthdate?</option>
                                                <option>What is Your old Phone Number</option>
                                                <option>What is your Pet Name?</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="`Answer *" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister"  value="Register"/>
                                    </div>
                                </div>
                            </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
                </div>                                    
            </div>
        </div>
    </div><!-- End Services Section -->
      </div>
    </div><!-- End About Section -->
