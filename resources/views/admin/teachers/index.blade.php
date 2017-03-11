@extends('layouts.admin')
@section('title', 'Teachers')
@section('page-title', 'Teachers List')
@section('content')
 <div class="clearfix">
   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <table class="table table-hover">
           <thead>
             <th>Id</th>
             <th>Name</th>
             <th>School</th>
             <th>Email</th>
             <th>View</th>
           </thead>
           <tbody>
            @foreach ($teachers as $teacher)
              <tr>
                <td>{{ $teacher->id }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->school->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td><a class="btn btn-small btn-info" href="teachers/{{ $teacher->id }}">View</a></td>
              </tr>
            @endforeach
           </tbody>
         </table>
       </div>
       <div class="col-md-4">
         <div class="card">
           <h3 class="card-header">New Teacher</h3>
           <div class="card-block">
             <div class="card-text">
               <form class="" action="/admin/teachers" method="POST" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 {{ method_field('POST') }}
                 <div class="form-group">
                   <label for="name">Name:</label>
                   <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the teacher">
                 </div>
                 <div class="form-group">
                   <label for="email">Email:</label>
                   <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="teacher@email.com">
                 </div>
                 <div class="form-group">
                   <label for="password">Password:</label>
                   <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="password">
                 </div>
                 <div class="form-group">
                   <label for="school_id">School:</label>
                   @if ($schools)
                     <select class="form-control" name="school_id">
                       @foreach ($schools as $school)
                         <option value="{{ $school->id }}">{{ $school->name }} - {{ $school->city }} - {{ $school->country }}</option>
                       @endforeach
                     </select>
                   @else
                     You need to create a School first!!
                   @endif
                 </div>
                 <div class="form-group">
                   <label for="media">Profile Picture:</label>
                   <input type="file" name="media" class="form-control"></input>
                 </div>
                 <hr>
                 <button type="submit" name="button" class="btn btn-primary btn-small btn-block mt-3">Save</button>
               </form>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
@endsection
