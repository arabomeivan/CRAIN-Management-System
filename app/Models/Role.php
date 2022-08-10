<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    const ADMIN_ROLE = 'admin';
<<<<<<< HEAD
    const EMPLOYEE_ROLE = 'employee';
    const SUPPLIER_ROLE = 'supplier';

    /**
     * Get the user associated with the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
=======
>>>>>>> 0152b24cad519c3f30f8cf0343e1fd4076aa0668
}
