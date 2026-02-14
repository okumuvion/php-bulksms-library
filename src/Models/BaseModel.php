<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
	public function findAllBy(array $conditions)
    {
        return $this->where($conditions)->findAll();
    }

	public function getById($id)
	{
		return $this->where($this->primaryKey, $id)->first();
	}

	public function getColumnById($id, string $column)
	{
		$q = $this->where($this->primaryKey, $id)->first();
		return $q->{$column} ?? null;
	}

	public function findOneBy(array $conditions)
    {
        return $this->where($conditions)->first();
    }

    public function countRows(?array $conditions = null): int
    {
    	if ($conditions !== null) {
    		return $this->where($conditions)->countAllResults();
    	}
        return $this->countAll();
    }

	public function create($data): int
	{
		$this->protect(false);
		$this->insert($data);
		return $this->getInsertID();
	}

	public function createBatch($data): int
	{
		$this->insertBatch($data);
		return $this->getInsertID();
	}

	public function updateById($id, $data)
	{
		$this->where('id', $id)->set($data)->update();
		return $id;
	}

	public function deleteById($id)
	{
		$this->where('id', $id)->delete();
		return true;
	}

	public function getByWhere($whereArg, $args = [])
	{
        $this->where($whereArg);
		if(isset($args['order']))
			$this->orderBy($args['order'][0], $args['order'][1]);

		return $this->findAll();
	}

	public function predictId()
	{
		return ($query = $this->where($this->table)->orderBy($this->table_key, 'desc')) && $query->countAllResults() > 0 ? $query->first()->id + 1 : 1;
	}
}