<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-5">
                    <h1 class="text-center text-primary mb-4">Employee List - {{auth()->user()->role == 'user' ? "User" : "Admin"}}</h1>

                    @if(auth()->check() && auth()->user()->role == 'admin')
                    <div class="text-end mb-3">
                        <a href="{{ route('employees.create') }}" class="btn btn-success">
                            Add Employee
                        </a>
                    </div>
                    @endif
                  
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>EMP ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>DOB</th>
                                <th>DOJ</th>
                                @if(auth()->check() && auth()->user()->role == 'admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ Carbon\Carbon::parse($employee->dob)->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($employee->doj)->format('d/m/Y') }}</td>
                                    @if(auth()->check() && auth()->user()->role == 'admin')
                                    <td>
                                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline;" id="delete-form-{{ $employee->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-form-id="delete-form-{{ $employee->id }}">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="d-flex justify-content-center">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>

        
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this employee? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    </div>


</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var deleteButtons = document.querySelectorAll('.btn-danger');
        
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var formId = button.getAttribute('data-form-id');
                var form = document.getElementById(formId);
                var confirmDeleteButton = document.getElementById('confirm-delete-btn');

                if (form && confirmDeleteButton) {
                    confirmDeleteButton.onclick = function() {
                        form.submit();  
                    };
                } else {
                    console.error("Form or confirmation button not found.");
                }
            });
        });
    });
</script>
