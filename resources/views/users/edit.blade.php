@extends('layouts.app')

@section('content')      
            <div class="card">
                <div class="card-header">My Profile</div>
                @include('partials.errors')
                <div class="card-body">
                    <form action="{{ route('users.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea class="form-control" name="about" id="about" cols="5" rows="10">{{ $user->about}}</textarea>      
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="btn btn-success">Update Profile</button>
                        </div>

                    </form>    
                </div>
            </div>
       
@endsection
