@extends('layouts.auth.body')
@section('title', '| roles')
@section('content')
    <section class="container-fluid mt-5 ">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div><i class="fas fa-table me-1"></i>
                    Role Table</div>
                    @can('Roles Create')
                    <div>
                        <a class="btn btn-info btn-sm" href="{{ route('role.create') }}">Add Role</a>
                    </div>
                    @endcan
            </div>
            <div class="card-body">
                <table class="table  table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="">
                                        @can('Roles Edit')
                                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        @endcan
                                        @can('Roles Assign Permission')
                                        <a href="{{ route('role.permission', $role->id) }}"
                                            class="btn btn-success btn-sm mb-1">Assign permission</a>
                                        @endcan
                                        @can('Roles Delete')
                                        <form method="POST" action="{{ route('role.delete', $role->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="GET">
                                            <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm"
                                                data-toggle="tooltip" title='Delete'>Delete</button>
                                        </form>
                                        @endcan
                                        {{-- <a href="{{ route() }}" class="btn btn-danger btn-sm">Delete</a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
