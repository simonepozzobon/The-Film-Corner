@extends('layouts.admin')
@section('title', 'Schools')
@section('page-title', 'Schools')
@section ('content')
      <div class="clearfix">
        <div class="row">
          <div class="col-md-8">
            <table class="table table-hover">
              <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Country</th>
                <th>View</th>
              </thead>
              <tbody>
                @foreach ($schools as $school)
                  <tr>
                    <td>{{ $school->id }}</td>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->address }}</td>
                    <td>{{ $school->city }}</td>
                    <td>{{ $school->postal_code }}</td>
                    <td>{{ $school->country }}</td>
                    <td><a href="#" class="btn btn-info btn-small">View</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="col-md-4">
            <div class="card">
              <h3 class="card-header">Create a new school</h3>
              <div class="card-block">
                <div class="card-text">
                  <form class="" action="/admin/schools" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the school">
                    </div>
                    <div class="form-group">
                      <label for="address">Address:</label>
                      <input type="address" name="address" value="{{ old('address') }}" class="form-control" placeholder="Address of the school">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Milan">
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="form-control" placeholder="20123">
                      </div>
                      <div class="form-group col-6">
                        <label for="country">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}" class="form-control" placeholder="Italy">
                      </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-primary btn-small btn-block mt-4">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
