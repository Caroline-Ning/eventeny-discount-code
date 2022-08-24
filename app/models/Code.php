<?php
class Code
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getCodes()
  {
    $this->db->query("SELECT * FROM codes
                      ORDER BY codes.created_at DESC");
    // result is an array of objects
    return $this->db->resultSet();
  }

  public function addCode($data)
  {
    // prepare statement
    $this->db->query('INSERT INTO codes (code,event_id,type,type_value,customer_eligibility,limit_times,limit_times_value,limit_one,user_id,start_date,end_date,is_deleted,used_times) VALUES(:code,:event_id,:type,:type_value,:customer_eligibility,:limit_times,:limit_times_value,:limit_one,:user_id,:start_date,:end_date,:is_deleted,:used_times)');

    // bind $data with placeholder
    $tableHead = ["code", "event_id", "type", "type_value", "customer_eligibility", "limit_times", "limit_times_value", "limit_one", "user_id", "start_date", "end_date", "is_deleted", "used_times"];

    foreach ($tableHead as $str) {
      $this->db->bind(':' . $str, $data[$str]);
    }

    // execute, return t/f
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function editCode($data)
  {
    // prepare statement
    $this->db->query('UPDATE codes SET code=:code,type=:type,type_value=:type_value,customer_eligibility=:customer_eligibility,limit_times=:limit_times,limit_times_value=:limit_times_value,limit_one=:limit_one,start_date=:start_date,end_date=:end_date,is_deleted=:is_deleted WHERE id=:id');

    // bind $data with placeholder
    $tableHead = ["id", "code", "type", "type_value", "customer_eligibility", "limit_times", "limit_times_value", "limit_one", "start_date", "end_date", "is_deleted"];

    foreach ($tableHead as $str) {
      $this->db->bind(':' . $str, $data[$str]);
    }

    // print_r($data);

    // execute, return t/f
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function markDeleteCode($id)
  {
    $this->db->query('UPDATE codes SET is_deleted=:is_deleted
                      WHERE id = :id');

    // bind values
    $this->db->bind(':id', $id);
    $this->db->bind(':is_deleted', 1);

    // execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getCodesByUser($user_id)
  {
    $this->db->query('SELECT * FROM codes 
                      WHERE user_id = :user_id AND is_deleted=:is_deleted
                      ORDER BY codes.created_at DESC');
    $this->db->bind(':user_id', $user_id);
    $this->db->bind(':is_deleted', 0);

    return $this->db->resultSet();
  }

  public function getCodeById($id)
  {
    $this->db->query('SELECT * FROM codes 
                      WHERE id = :id AND is_deleted=:is_deleted');
    $this->db->bind(':id', $id);
    $this->db->bind(':is_deleted', 0);

    return $this->db->single();
  }

  public function getCodesByEventId($event_id)
  {
    $this->db->query('SELECT * FROM codes 
                      WHERE event_id = :event_id AND is_deleted=:is_deleted');
    $this->db->bind(':event_id', $event_id);
    $this->db->bind(':is_deleted', 0);

    return $this->db->resultSet();
  }

  public function getCodeByEventAndCode($event_id, $input)
  {
    $this->db->query('SELECT * FROM codes 
    WHERE event_id = :event_id AND code=:code AND is_deleted=:is_deleted');

    $this->db->bind(':event_id', $event_id);
    $this->db->bind(':code', $input);
    $this->db->bind(':is_deleted', 0);

    return $this->db->single();
  }

  public function updateUsedTimes($code_id, $used_times)
  {
    $this->db->query('UPDATE codes SET used_times=:used_times
    WHERE id = :id');

    // bind values
    $this->db->bind(':id', $code_id);
    $this->db->bind(':used_times', $used_times + 1);

    // execute
    return $this->db->execute();
  }
}
