<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Auth\Notifications\ResetPassword; 
use Illuminate\Notifications\Messages\MailMessage; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'roleid',
        'address',
        'phone',
        'isactive',
        'email_verified_at',
        'avatar',
        'background',
        'jobs',
        'school',
        'company',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'isactive' => 'boolean',
        ];
    }

    // Quan hệ 1-n: User BELONGS TO Role
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'roleid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Orders (với vai trò khách hàng)
    public function ordersAsCustomer(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Orders (với vai trò người bán/Saler)
    public function ordersAsSaler(): HasMany
    {
        return $this->hasMany(Order::class, 'sellerid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Products (với vai trò người bán/Saler)
    public function productsAsSaler(): HasMany
    {
        return $this->hasMany(Product::class, 'sellerid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY ShipperAssignments (với vai trò Shipper)
    public function shipperAssignments(): HasMany
    {
        return $this->hasMany(ShipperAssignment::class, 'shipperid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'authorid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'userid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Reviews
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'userid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Carts
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'userid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY Notifications
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'userid', 'id');
    }

    // Quan hệ 1-n: User HAS MANY UserActivities
    public function userActivities(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'userid', 'id');
    }

    // Quan hệ nhiều-nhiều: User HAS MANY ProductFavorites
    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'productfavorites', 'userid', 'productid');
    }

    // Quan hệ 1-n: User HAS MANY PostInteractions
    public function postInteractions(): HasMany
    {
        return $this->hasMany(PostInteraction::class, 'userid', 'id');
    }

    public function sendPasswordResetNotification($token) 
    { 
        $this->notify(new CustomResetPasswordNotification($token)); 
    }
}

