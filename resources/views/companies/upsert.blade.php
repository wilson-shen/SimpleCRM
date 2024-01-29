@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Company') }}</div>

                <div class="card-body">
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary mb-4">Back</a>

                    <form action="{{ isset($company)? route('companies.update', $company->id): route('companies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(isset($company))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="name">
                                Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $company?->name ?? '') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $company?->email ?? '') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="logo">Logo</label>

                            <div id="preview-logo">
                                @if(isset($company, $company->logo))
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo" width="100">
                                @endif
                            </div>

                            <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $company?->website ?? '') }}">
                            @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        const logoInput = document.querySelector('#logo');
        const logoPreview = document.querySelector('#preview-logo');

        logoInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            logoPreview.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="${file.name}" width="100">`;
        })
    </script>
@endsection

