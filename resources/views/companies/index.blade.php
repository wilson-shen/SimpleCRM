@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Companies') }}</div>

                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a href="{{ url('/') }}" class="btn btn-secondary">Home</a>
                            <a href="{{ route('companies.create') }}" class="btn btn-primary ms-2">Create Company</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Logo</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($companies as $company)
                                        <tr>
                                            <td>{{ $company->name }}</td>
                                            <td>{{ $company->email }}</td>
                                            <td>
                                                @if ($company->logo)
                                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}Logo" width="100">
                                                @endif
                                            </td>
                                            <td>
                                                @if($company->website)
                                                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit</a>

                                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No companies found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $companies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
