<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partnership extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

  

    public function partnerType():BelongsTo
    {
        return $this->belongsTo(PartnershipType::class, 'partner_type_id');
    }

    public function picDreamile():BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_dreamile', 'id');
    }
}
