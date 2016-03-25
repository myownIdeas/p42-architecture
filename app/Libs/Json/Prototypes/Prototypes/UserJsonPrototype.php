<?php
/**
 * Created by PhpStorm.
 * User: JR Tech
 * Date: 3/25/2016
 * Time: 11:46 AM
 */

namespace App\Libs\Json\Prototypes\Prototypes;


use App\Libs\Json\Prototypes\Interfaces\JsonPrototypeInterface;
use App\Models\Sql\User;

class UserJsonPrototype extends JsonPrototype implements JsonPrototypeInterface
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function prototype()
    {
        return $this->user->toJson();
    }
}