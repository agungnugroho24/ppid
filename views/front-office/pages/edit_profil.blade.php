@extends('front-office.layouts.master')

@section('title', 'Halaman Edit Data Profile')

@section('navbar')
  <x-navbar-auth-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')

    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user-circle-o" style="font-size:1.8em;"></i> <b>{{ __('Lengkapi Data Profil Anda') }}</b>
                            @include('sweetalert::alert')
                        </div>
                        <div class="card-body">
                            <form class="row" method="POST" action="{{ route('update-profile-update', Auth::user()->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Nama Depan') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ Auth::user()->first_name }}" required autocomplete="first_name" autofocus>
                                        </div>
                                        @error('first_name')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Nama Belakang') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ Auth::user()->last_name }}" required autocomplete="last_name" autofocus>
                                        </div>
                                        @error('last_name')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                   
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Username') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" placeholder="contoh : user.lastname">
                                        </div>
                                        @error('user_name')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                   
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Jenis Pemohon') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_pemohon" id="jenis_pemohon1" value="Perorangan" {{ old('jenis_pemohon') !== null && old('jenis_pemohon') == 'Perorangan' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_pemohon">
                                                Perorangan
                                              </label>
                                            </div>  
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_pemohon" id="jenis_pemohon2" value="Kelompok Orang" {{ old('jenis_pemohon') !== null && old('jenis_pemohon') == 'Kelompok Orang' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_pemohon">
                                                Kelompok Orang
                                              </label>
                                            </div> 
                                        </div>
                                        @error('jenis_pemohon')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Alamat E-Mail') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
                                        </div>
                                       
                                        @error('email')
                                            <span class="alert alert-danger alert-block small">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Jenis Identitas') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas1" value="KTP" {{ old('jenis_identitas') !== null && old('jenis_identitas') == 'KTP' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_identitas">
                                                KTP
                                              </label>
                                            </div>  
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas2" value="SIM" {{ old('jenis_identitas') !== null && old('jenis_identitas') == 'SIM' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_identitas">
                                                SIM
                                              </label>
                                            </div>   
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas3" value="PASPOR" {{ old('jenis_identitas') !== null && old('jenis_identitas') == 'PASPOR' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_identitas">
                                                PASPOR
                                              </label>
                                            </div>                                                                     
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="jenis_identitas" id="jenis_identitas4" value="NPWP" {{ old('jenis_identitas') !== null && old('jenis_identitas') == 'NPWP' ? 'checked' : '' }}>
                                              <label class="form-check-label" for="jenis_identitas">
                                                NPWP
                                              </label>
                                            </div>
                                           @error('jenis_identitas')
                                                <div class="alert alert-danger alert-block small">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror                                            
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Nomor Identitas') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                             <input id="nomor_identitas" type="text" class="form-control @error('nomor_identitas') is-invalid @enderror" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required autocomplete="nomor_identitas">
                                        </div>
                                        @error('nomor_identitas')
                                            <span class="alert alert-danger alert-block small" >
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Nomor Telepon') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                             <input id="nomor_ponsel" type="tel" class="form-control @error('nomor_ponsel') is-invalid @enderror" name="nomor_ponsel" value="{{ Auth::user()->nomor_ponsel }}" required autocomplete="nomor_ponsel">
                                        </div>
                                        @error('nomor_ponsel')
                                            <span class="alert alert-danger alert-block small">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                                       
                                    </div>                                    
                                </div>                                

                                <div class="form-group col-12">
                                    <label>{{ __('Keterangan') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="keterangan" name="keterangan" rows="5">{{ old('keterangan') }}</textarea>
                                        </div>
                                        @error('keterangan')
                                            <span class="alert alert-danger alert-block small">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                                </div>
                            </form>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Services Section -->

@endsection

