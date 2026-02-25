@extends('backEnd.layouts.master')
@section('title','Create Collection')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary rounded-pill">
                        Back
                    </a>
                </div>
                <h4 class="page-title">Create Collection</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('collections.store') }}">
                        @csrf

                        {{-- Collection Name --}}
                        <div class="mb-3">
                            <label class="form-label">Collection Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Summer Collection"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Create Collection
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
