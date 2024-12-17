<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'dob',
        'doj',
    ];

    protected $casts = [
        'dob' => 'date',
        'doj' => 'date',
    ];


    
    public static function createEmployee(array $data)
    {
        $data['dob'] = Carbon::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d');
        $data['doj'] = Carbon::createFromFormat('d/m/Y', $data['doj'])->format('Y-m-d');

        return self::create($data);
    }


    public function updateEmployee(array $data)
    {
        $data['dob'] = Carbon::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d');
        $data['doj'] = Carbon::createFromFormat('d/m/Y', $data['doj'])->format('Y-m-d');

        return $this->update($data);
    }
}
