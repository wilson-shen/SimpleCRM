@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Employee') }}</div>

                <div class="card-body">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-4">Back</a>

                    <form action="{{ isset($employee)? route('employees.update', $employee->id): route('employees.store') }}" method="POST">
                        @csrf

                        @if(isset($employee))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="first-name">
                                First Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="first-name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $employee?->first_name ?? '') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="last-name">
                                Last Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="last-name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $employee?->last_name ?? '') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- dorpdown select for company --}}
                        <div class="form-group mb-3">
                            <label for="company">Company</label>
                            <select name="company_id" id="company" class="form-select @error('company_id') is-invalid @enderror">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $employee?->company_id ?? '') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee?->email ?? '') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee?->phone ?? '') }}">
                            @error('phone')
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
    const phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    })
</script>
@endsection
