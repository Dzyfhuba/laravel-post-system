<?php

namespace Dzyfhuba\PostSys\Traits;

trait HasMessage {
    
    protected function addOrEditMessage( Object $model, String $content, Int $user_id, Int $status ): Object
    {
        return $model->message()->updateOrCreate([],['content' => $content, 'user_id' => $user_id, 'status' => $status])->messageable;
    }
}
