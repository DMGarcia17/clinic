<?php
/**
 * 
 */
class DatabaseConnection
{
    public $db;
    public function __construct()
    {
        require_once 'Variables.php';
        try{
            $this->db = new PDO('mysql:host='.server.';dbname='.db, user, pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }

    public function blankect_query($table, $fields)
    {
        $query = $this->db->prepare('select '.$fields.' from '.$table.' order by 1');
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function blankectOQuery($table, $fields, $order)
    {
        $query = $this->db->prepare('select '.$fields.' from '.$table.' order by '.$order);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function filtered_query($table, $fields, $condition)
    {
        $query = $this->db->prepare('select '.$fields.' from '.$table.' where '.$condition);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function filteredOQuery($table, $fields, $condition, $order)
    {
        $query = $this->db->prepare('select '.$fields.' from '.$table.' where '.$condition.' order by '.$order);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function query($sql)
    {
        $query = $this->db->prepare($sql);
        try{
          $query->execute();
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
          $res = $e->getMessage();
        }
        return $res;
    }

    public function insert($table, $fields, $values)
    {
    $query = $this->db->prepare("insert into {$table}({$fields}) values ({$values})");
    try{
      $res = $query->execute();
    }catch (PDOException $e){
      $res = $e->getMessage();
    }
    return $res;
    }

    public function update($table, $condition, $values)
    {
    $query = $this->db->prepare("update {$table} set {$values} where {$condition}");
    try{
      $res = $query->execute();
    }catch (PDOException $e){
      $res = $e->getMessage();
    }
    return $res;
    }
    public function delete($table, $condition){
        $sql = "delete from $table where $condition";
        $query = $this->db->prepare($sql);
        try{
            $res = $query->execute();
        }catch (PDOException $e){
            $res = $e->getMessage();
        }
        return $res;
    }

}