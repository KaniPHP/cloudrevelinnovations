<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-5">
                    <h1 class="text-center text-primary mb-4">Edit Employee <span class="badge badge-lg badge-success"> {{$employee->employee_id}} </span></h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">DOB:</label>
                            <input type="text" class="form-control datepicker" id="dob" name="dob" 
                                   placeholder="DD/MM/YYYY" value="{{ old('dob', \Carbon\Carbon::parse($employee->dob)->format('d/m/Y')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="doj" class="form-label">DOJ:</label>
                            <input type="text" class="form-control datepicker" id="doj" name="doj" 
                                   placeholder="DD/MM/YYYY" value="{{ old('doj', \Carbon\Carbon::parse($employee->doj)->format('d/m/Y')) }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',  
            autoclose: true,      
            todayHighlight: true  
        });
    });
</script>
