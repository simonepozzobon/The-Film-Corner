@extends('layouts.admin')
@section('title', 'Student')
@section('page-title', 'Students List')
@section('content')
 <div class="clearfix">
   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <table class="table table-hover">
           <thead>
             <th>Id</th>
             <th>Name</th>
             <th>Teacher</th>
             <th>School</th>
             <th>View</th>
           </thead>
           <tbody>
            @foreach ($students as $student)
              <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->teacher->name }}</td>
                <td>{{ $student->school->name }}</td>
                <td><a class="btn btn-small btn-info" href="students/{{ $student->id }}">View</a></td>
              </tr>
            @endforeach
           </tbody>
         </table>
       </div>
       <div class="col-md-4">
         <div class="card">
           <h3 class="card-header">New Student</h3>
           <div class="card-block">
             <div class="card-text">
               <form class="" action="/admin/students" method="POST">
                 {{ csrf_field() }}
                 {{ method_field('POST') }}
                 <div class="form-group">
                   <label for="name">Name:</label>
                   <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the student">
                 </div>
                 <div class="form-group">
                   <label for="email">Email:</label>
                   <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="student@email.com">
                 </div>
                 <div class="form-group">
                   <label for="password">Password:</label>
                   <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="password">
                 </div>
                 <div class="form-group">
                   <label for="teacher_id">Teacher:</label>
                   <select class="form-control" name="teacher_id">
                     @foreach ($teachers as $teacher)
                       <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                     @endforeach
                   </select>
                 </div>
                 <div class="form-group">
                   <label for="school_id">School:</label>
                   <select class="form-control" name="school_id">
                     @foreach ($schools as $school)
                       <option value="{{ $school->id }}">{{ $school->name }}</option>
                     @endforeach
                   </select>
                 </div>
                 <button type="submit" name="button" class="btn btn-primary btn-small btn-block mt-4">Save</button>
               </form>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
@endsection
