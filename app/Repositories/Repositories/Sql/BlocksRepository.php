<?php
/**
 * Created by WAQAS.
 * User: waqas
 * Date: 4/7/2016
 * Time: 11:14 AM
 */

namespace App\Repositories\Repositories\Sql;


use App\DB\Providers\SQL\Factories\Factories\Block\BlockFactory;
use App\DB\Providers\SQL\Models\Block;
use App\Repositories\Interfaces\Repositories\BlocksRepoInterface;


class BlocksRepository extends SqlRepository implements BlocksRepoInterface
{
    private $factory;
    public function __construct()
    {
         $this->factory = new BlockFactory();
    }
    public function store(Block $block)
    {
        return $this->factory->store($block);
    }


    public function getById($id)
    {
        return $this->factory->find($id);
    }

    public function all()
    {
        return $this->factory->all();
    }

    public function update(Block $block)
    {
        $this->factory->update($block);
        return $this->factory->find($block->id);
    }

    public function delete(Block $block)
    {
        return $this->factory->delete($block);
    }
}