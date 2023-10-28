<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'start_date',
        'end_date',
        'location',
        'price',
    ];

    public function scopeOrderByCol(Builder $query, string $orderBy, string $orderDir = 'ASC'): Builder
    {
        return $query->orderBy($orderBy, $orderDir);
    }

    public function scopePriceFrom(Builder $query, string $priceFrom): Builder
    {
        return $query->where('price', '>=', $priceFrom);
    }
    public function scopePriceTo(Builder $query, string $priceTo): Builder
    {
        return $query->where('price', '<=', $priceTo);
    }

    public function scopeSearchBy(Builder $query, string $searchTerm): Builder
    {
        return $query->where(function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }

}
