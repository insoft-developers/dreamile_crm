<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detail():HasMany
    {
        return $this->hasMany(TemplateDetail::class, 'template_id');
    }
}
