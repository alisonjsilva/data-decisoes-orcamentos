<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalServices extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proposal_services';

    public function category () {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
