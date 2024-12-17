<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeController extends Controller
{
   
    public function index()
    {
        $employees = Employee::paginate(10);

        return view('employees.index', compact('employees'));
    }
    

    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeRequest $request)
    {
    
        try {
            $latestEmployee = Employee::latest()->first();
            $newEmployeeId = $latestEmployee ? 'EMP-' . ($latestEmployee->id + 1) : 'EMP-1';
    
            $employeeData = $request->only(['name', 'email', 'dob', 'doj']);
            $employeeData['employee_id'] = $newEmployeeId;
    
            Employee::createEmployee($employeeData);
    
            return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while adding the employee: ' . $e->getMessage()]);
        }
    }
    
    public function edit(Employee $employee)
    {
        try {
            $employee->dob = Carbon::parse($employee->dob)->format('Y-m-d');
            $employee->doj = Carbon::parse($employee->doj)->format('Y-m-d');
            
            return view('employees.edit', compact('employee'));
        } catch (\Exception $e) {
           
            return redirect()->back()->with('error', 'Something went wrong while editing the employee data.');
        }
    }
    
    public function update(EmployeeRequest $request, Employee $employee)
    {
        try {
            $employeeData = $request->only(['name', 'email', 'dob', 'doj']);
            $employee->updateEmployee($employeeData);

            return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the employee: ' . $e->getMessage()]);
        }
    }

   public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while deleting the employee: ' . $e->getMessage()]);
        }
    }

    public function userView()
    {
        $employees = Employee::paginate(10);

        return view('employees.index', compact('employees'));
    }
}
