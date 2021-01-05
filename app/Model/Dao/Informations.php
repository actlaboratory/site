<?php

namespace Model\Dao;

use Doctrine\DBAL\DBALException;
use PDO;

class Informations extends Dao{

	//Žw’è‚µ‚½”N‚Ì‚à‚Ì‚ðŽæ“¾
	public function getByYear(int $year){
		$queryBuilder = parent::getQueryBuilder()
			->select('*')
			->from($this->_table_name)
			->andWhere(strval('"'.intval($year)) . "-01-01\" <= `date`")
			->andWhere(strval('"'.intval($year)) . "-12-31\" >= `date`")
			->orderBy("date", "DESC");
		//var_dump($queryBuilder->getsql());
		//exit();
		return $queryBuilder->execute()->FetchALL();
	}
}
