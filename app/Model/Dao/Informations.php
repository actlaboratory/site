<?php

namespace Model\Dao;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\DBALException;
use PDO;


class Informations extends Dao
{
    // 年ごとにお知らせを取得
    function selectFromYear($year, $sort, $order, $limit=NULL){
        //クエリビルダをインスタンス化
        $queryBuilder = new QueryBuilder($this->db);

        //ベースクエリを構築する
        $queryBuilder
            ->select('*')
            ->from($this->_table_name)
            ->where("year(date) = ". (int)$year);

        //ソート順が指定されていたら指定します
        if ($sort) {
            $queryBuilder->orderBy($sort, $order);
        }

        //リミットが指定されていたら指定します
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        //クエリ実行
        $query = $queryBuilder->execute();

        //レコードの取得
        $result = $query->FetchALL();
        //結果を返送
        return $result;
    }

    // 年一覧取得
    function getYears($order="ASC"){
        $queryBuilder = new QueryBuilder($this->db);

        //ベースクエリを構築する
        $queryBuilder
            ->select('DISTINCT YEAR(date) as date')
            ->from($this->_table_name);

        $queryBuilder->orderBy("date", $order);

        //クエリ実行
        $query = $queryBuilder->execute();

        //レコードの取得
        $result = $query->FetchALL();
        //結果を返送
        return $result;
    }

}
