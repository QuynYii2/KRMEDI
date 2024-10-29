<?php

namespace App\Models;

use App\Models\online_medicine\ProductMedicine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password',
        'username', 'phone', 'address_code', 'status', 'type',
        'provider_id', 'provider_name', 'prescription', 'free', 'abouts', 'abouts_en', 'abouts_lao', 'workspace',
        'last_seen', 'extend', 'average_star', 'identify_number', 'signature', 'token','avt','devices_name','devices_id','health_insurance_front','health_insurance_back','insurance_id',
        'date_health_insurance','client_id_kiot_viet','client_secret_kiot_viet','retailer_kiot_viet','is_send'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extend' => 'array',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'id', 'user_id');
    }

    public static function getNameByID($id)
    {
        if (!$id) {
            return '';
        }

        $user = User::where('id', $id)->first();

        if (!$user) {
            return '';
        }

        if (!$user->name && !$user->last_name) {
            return 'No name';
        }

        if (!$user->name) {
            $user->name = '';
        }
        if (!$user->last_name) {
            $user->last_name = '';
        }

        return $user->name . ' ' . $user->last_name;
    }

    public static function isExistUsername($username)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public static function isExistEmail($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public static function isExistPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public static function getMemberNameByID($id)
    {
        if (!$id) {
            return '';
        }
        $user = User::where('id', $id)->first();
        if (!$user) {
            return '';
        }
        $role = RoleUser::where('user_id', $id)->first();
        if (!$role) {
            return '';
        }
        return Role::where('id', $role->role_id)->first()->name;
    }

    public static function getEmailByID($id)
    {
        if (!$id) {
            return '';
        }
        $user = User::where('id', $id)->first();
        if (!$user) {
            return '';
        }
        return $user->email ?? 'noemail@gmail.com';
    }

    public static function getAvtByID($id)
    {
        if (!$id) {
            return '';
        }
        $user = User::where('id', $id)->first();
        if (!$user) {
            return '';
        }

        if (!$user->avt) {
            return '/img/user-circle.png';
        }
        return $user->avt;
    }

    //get member name by id

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    //get email by id

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    //get avt by id

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function isAdmin($user_id = null)
    {
        if ($user_id) {
            $role_user = RoleUser::where('user_id', $user_id)->first();
        } else {
            $role_user = RoleUser::where('user_id', Auth::user()->id)->first();
        }

        if (!$role_user) {
            return false;
        }

        $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

        if ($roleNames->contains('ADMIN')) {
            return true;
        } else {
            return false;
        }
    }


    public static function isNormal()
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->type == \App\Enums\Role::NORMAL;
    }

    public static function getClinicID($user_id = null)
    {
        if (!Auth::check()) {
            return false;
        }

        if ($user_id) {
            $clinic = User::with('clinic')->find($user_id);

            if (!$clinic || self::isAdmin($user_id)) {
                return 0;
            }
        } else {
            $clinic = User::with('clinic')->find(Auth::user()->id);

            if (!$clinic || self::isAdmin()) {
                return 0;
            }
        }

        return $clinic->clinic->id;
    }

    public function productMedicines()
    {
        return $this->hasMany(ProductMedicine::class);
    }

    public function getUsersByRoleName($roleName)
    {
        return $this->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })->get();
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
