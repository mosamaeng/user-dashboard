<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'occupation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $appends = [
        'impression_count',
        'conversion_count',
        'revenue',
        'conversion_per_day',
    ];

    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logs(){
        return $this->hasMany(Log::class);
    }

    public function getImpressionCountAttribute(){
        return $this->logs->where('type', 'impression')->count();
    }
    
    public function getConversionCountAttribute(){
        return $this->logs->where('type', 'conversion')->count();
    }

    public function getRevenueAttribute(){
        return $this->logs->sum('revenue');
    }

    public function getConversionPerDayAttribute(){
        return $this->logs()
            ->select(DB::raw('DATE(time) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy('day')
            ->take(5)
            ->get()
            ->toArray();
    }

    public function scopeSearch($query, $request){
        // Applying search on name, impression, conversion and revenue
        if ($request->has('search')) {
            $query->where(function ($nameQuery) use ($request) {
                $nameQuery->where('name', 'like', '%' . $request->input('search') . '%');
            });
    
            $query->orWhereHas('logs', function ($logQuery) use ($request) {
                $logQuery->select('user_id')
                        ->where('type', 'impression')
                        ->groupBy('user_id') 
                        ->havingRaw('COUNT(id) = ?', [$request->input('search')]);
            });

            $query->orWhereHas('logs', function ($logQuery) use ($request) {
                $logQuery->select('user_id')
                        ->where('type', 'conversion')
                        ->groupBy('user_id') 
                        ->havingRaw('COUNT(id) = ?', [$request->input('search')]);
            });

            $query->orWhereHas('logs', function ($logQuery) use ($request) {
                $logQuery->select('user_id')
                        ->groupBy('user_id') 
                        ->havingRaw('FLOOR(SUM(revenue)) = ?', [$request->input('search')]);
            });
        }

        return $query;
    }
}
