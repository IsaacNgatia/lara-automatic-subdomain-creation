<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guard = 'web';
    protected $fillable = [
        'username',
        'name',
        'password',
        'email',
        'type',
        'phone_number',
        'account_name',
        'subdomain',
        'database_name',
        'add',
        'read',
        'delete',
        'edit',
        'role_id',
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $casts = [
        'add' => 'boolean',
        'read' => 'boolean',
        'delete' => 'boolean',
        'edit' => 'boolean',
        'email_verified_at' => 'datetime'
    ];
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    /**
     * Get all admin notes associated with the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\AdminNote A collection of admin notes.
     */
    public function adminNotes(): HasMany
    {
        return $this->hasMany(AdminNote::class);
    }
    /**
     * Get all admin logs associated with the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\AdminLog A collection of admin logs.
     */
    public function adminLogs(): HasMany
    {
        return $this->hasMany(AdminLog::class);
    }
    /**
     * Get all expense types associated with the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\ExpenseType A collection of expense types.
     */
    public function expenseTypes(): HasMany
    {
        return $this->hasMany(ExpenseType::class);
    }
    /**
     * Get all expenses associated with the admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\Expense A collection of expenses.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
    /**
     * Get all complaint replies associated with the admin.
     *
     * This function retrieves all complaint replies made by the admin.
     * It uses Laravel's Eloquent ORM to establish a one-to-many relationship
     * between the admin and complaint replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\ComplaintReply A collection of complaint replies made by the admin.
     */
    public function complaintReplies(): HasMany
    {
        return $this->hasMany(ComplaintReply::class, 'replied_by');
    }

    public function accountSettings()
    {
        return $this->hasOne(AccountSetting::class, 'admin_id');
    }
}