<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'description',
        'category_id',
        'amount',
        'user_id'
    ];

    public static function boot(){
        static::addGlobalScope('user', function($query){
            $query->where('user_id', auth()->id());
        });

        static::saving(function(self $transaction){
            $transaction->user_id = $transaction->user_id ?: auth()->id();
        });
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeByCategory($query, Category $category){
        if ($category->exists){
            $query->where('category_id', $category->id);
        }
    }

    public function scopeByMonth($query, string $month = 'this month'){
        $query->where('created_at', '>=', Carbon::parse("first day of $month"))
            ->where('created_at', '<=', Carbon::parse("last day of $month"));
    }

    public static function validate(array $attributes = []){
        $rules = [
            'description' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
        ];

        $validator = Validator::make($attributes, $rules);
        
        if ($validator->fails()){
            throw new ValidationException($validator);
        }
    }
}
