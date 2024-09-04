<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProposalServices;
use App\Tab;

class Proposal extends Model
{
    //protected $table = 'proposal';

    public function services () {
        return $this->hasMany(ProposalServices::class);
    }

    public function tabs () {
        return $this->hasMany(Tab::class);
    }
}
