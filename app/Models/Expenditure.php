<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Expenditure extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * @var string[]
     */
    protected $fillable = [
        'description',
        'date',
        'user_id',
        'amount'
    ];

    /**
     * Relationship with User
     * 
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mapping users
     * @author Diogo C. Coutinho
     * @return User $object
     */
    public function scopeMappingExpenditures()
    {
        return $this->all()->map(function ($expenditure) {
            return [
                'id'            => $expenditure->id,
                'description'   => $expenditure->description,
                'date'          => $expenditure->date,
                'amount'        => $expenditure->amount,
                'edit_url'      => URL::route('expenditures.edit', $expenditure),
                'delete_url'    => URL::route('expenditures.destroy', $expenditure),
                'user'          => User::find($expenditure->user_id)
            ];
        });
    }

    /**
     * Create a new expenditure
     * @param Array $data
     * @return Expenditure $data
     */
    public static function newExpenditure($data)
    {
        return Expenditure::create([
            'description'   => $data['description'],
            'date'          => $data['datetime'],
            'user_id'       => $data['user_id'],
            'amount'        => $data['amount'],
        ]);
    }

    /**
     * Update expenditure data
     * @author Diogo C. Coutinho
     * @param Array $data
     * @return Expenditure $data
     */
    public static function updateExpenditure($data)
    {
        return Expenditure::find($data['id'])->update([
            'description'   => $data['description'],
            'date'          => $data['date'],
            'user_id'       => $data['user_id'],
            'amount'        => $data['amount'],
        ]);
    }
}
