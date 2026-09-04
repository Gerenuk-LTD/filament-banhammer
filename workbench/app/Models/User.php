<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Mchev\Banhammer\Traits\Bannable;

class User extends Model
{
    use Bannable;

    protected $guarded = [];

    public function getFilamentBanhammerTitleAttribute(): string
    {
        return $this->name;
    }
}
