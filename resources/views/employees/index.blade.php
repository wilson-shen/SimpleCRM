@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Employees') }}</div>

                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a href="{{ url('/') }}" class="btn btn-secondary">Home</a>
                            <a href="{{ route('employees.create') }}" class="btn btn-primary ms-2">Create Employee</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Actions</th>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone }}</td>
                                            <td>{{ $employee->company->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>

                                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">No employees found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
