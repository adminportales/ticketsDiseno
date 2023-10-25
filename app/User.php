<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'status', 'last_login'
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
    ];

    //Crear el perfil al momento de crear el usuario
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create();
        });
    }

    //Funcion para obtener el perfil
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    //Funcion para saber que roles tiene el usuario
    public function whatRoles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    //Funcion para obtener los tickets asignados al diseñador
    public function assignedTickets()
    {
        return $this->hasMany('App\Ticket', 'designer_id');
    }
    //Funcion para obtener los tickets creados por el vendedor o asistente
    public function ticketsCreated()
    {
        return $this->hasMany('App\Ticket', 'creator_id');
    }

    //Funcion para obtener los tickets creados por el vendedor y su asistente
    public function ticketsCreatedBySellerAndAssistant()
    {
        return $this->hasMany('App\Ticket', 'creator_id');
    }

    //Funcion para saber que tickets tiene asigando cada diseñador
    public function whatTypes()
    {
        return $this->belongsToMany(Type::class, 'ticket_assigments', 'designer_id', 'type_id');
    }

    public function team()
    {
        return $this->hasOne('App\Team');
    }

    public function teamMember()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    public function deliveries()
    {
        return $this->hasMany(TicketDelivery::class, 'designer_id');
    }

    public function latestTicketsToTransferMe()
    {
        return $this->hasMany(TicketAssignProcess::class, 'designer_received_id', 'id');
    }
}
