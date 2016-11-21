<?php
require_once('dao.class.php');
class Base
{
     private   $result;
     public   $dao;
     private   $tb;

     function __construct()
     {
          $this->dao = new DAO();
     }

     public function __destruct()
     {
          $this->dao->close_connection();
     }

     function set_table($tb){
          $this->tb = $tb;
     }
			 
     function add_item($post){
          global $global_db_schema;
          $db_schema = $global_db_schema[$this->tb];
          $query = "INSERT INTO $this->tb(";
          $first_field=true;
          foreach ($db_schema as $field => $type) {
              if('id' == $field){
                  continue;
              }else{
                  if($first_field){
                      $first_field=false;
                  }else{
                      $query .= ', ';
                  }
                  $query .= $field;
              }
          }
          $first_field=true;
          $query.=') VALUES (';
          foreach ($db_schema as $field => $type) {
               if('id' == $field){
                    continue;
               }else{
                    if($first_field){
                        $first_field=false;
                    }else{
                        $query .= ', ';
                    }
                    if($type == 'char'){
                      if(isset($post[$field])&&$post[$field]){
                          $query .="'".$post[$field]."'";
                        }else{
                          $query .="''";
                        }  
                    }else if($type == 'timestamp'){
                        if(isset($post[$field])&&$post[$field]){
                          $query .="'".$post[$field]."'";
                        }else{
                          $query .="NOW()";
                        }
                    }else{
                        if(isset($post[$field])&&$post[$field]){
                            $query .=$post[$field];
                        }else{
                            $query .=0;
                        }
                    }
               }
          }
          $query .= ')';
          $this->result = $this->dao->query($query);
          return $this->result? true: false;
     }

     function insert_by_exec_sql($query){
        $this->result = $this->dao->query($query);
        return $this->result? true: false;
     }

    function update_item($post){
        global $global_db_schema;
        $db_schema = $global_db_schema[$this->tb];
        $query = "UPDATE $this->tb SET ";
        $first_field = true;
        foreach ($db_schema as $field => $type) {
            if('id' == $field or 'time_created' == $field or 'user_name' == $field){
                continue;
            }else{
                if($first_field){
                    $first_field=false;
                }else{
                    $query .= ', ';
                }
                if($type == 'char'){
                    if(isset($post[$field]))
                      $query .= "$field = '".$post[$field]."'";
                }else{
                  if(isset($post[$field]))
                    $query .= "$field = ".$post[$field];
                }
            }
        }
        $query .= " WHERE id=".$post['id'];
        $this->result = $this->dao->query($query);
        return $this->result? true: false;
     }

     function update_part_item($post){
        global $global_db_schema;
        $db_schema = $global_db_schema[$this->tb];
        $query = "UPDATE $this->tb SET ";
        $first_field = true;
        foreach ($post as $field => $value) {
            if('id' == $field or 'time_created' == $field or 'user_name' == $field){
                continue;
            }else{
                if($first_field){
                    $first_field=false;
                }else{
                    $query .= ', ';
                }
                if($db_schema[$field] == 'char'){
                    $query .= "$field = '".$value."'";
                }else{
                    $query .= "$field = ".$value;
                }
            }
        }
        $query .= " WHERE id=".$post['id'];
        $this->result = $this->dao->query($query);
        return $this->result? true: false;
        //return $query;
     }
    function update_part_item_all($post){
        global $global_db_schema;
        $db_schema = $global_db_schema[$this->tb];
        $query = "UPDATE $this->tb SET ";
        $first_field = true;
        foreach ($post as $field => $value) {
            if('id' == $field ){
                continue;
            }else{
                if($first_field){
                    $first_field=false;
                }else{
                    $query .= ', ';
                }
                if($db_schema[$field] == 'char'){
                    $query .= "$field = '".$value."'";
                }else{
                    $query .= "$field = ".$value;
                }
            }
        }
        $query .= " WHERE id=".$post['id'];
        $this->result = $this->dao->query($query);
        return $this->result? true: false;
    }
     function update_by_condition($post,$condition){
        global $global_db_schema;
        $db_schema = $global_db_schema[$this->tb];
        $query = "UPDATE $this->tb SET ";
        $first_field = true;
        foreach ($post as $field => $value) {
            if('id' == $field or 'time_created' == $field or 'user_name' == $field){
                continue;
            }else{
                if($first_field){
                    $first_field=false;
                }else{
                    $query .= ', ';
                }
                if($db_schema[$field] == 'char'){
                    $query .= "$field = '".$value."'";
                }else{
                    $query .= "$field = ".$value;
                }
            }
        }
        $query .= " WHERE ".$condition;
        $this->result = $this->dao->query($query);
        return $this->result? true: false;
     }
     
     function delete_item($id)
     {
          $query = "DELETE FROM $this->tb WHERE id=$id";
          $this->result = $this->dao->query($query);
          return $this->result? true: false;
     }

     function get_item_by_condition($con=''){
          $condition='';	
          if(is_array($con) and count($con)>0){
              foreach($con as $k => $v){
                  if(!is_numeric($v)){
                      if($k=="area"){
                          $condition = $condition." AND $k LIKE '%$v%'";
                      }else{
                          $condition = $condition." AND $k = '$v'";
                      }
                  }else{
                      $condition = $condition." AND $k = $v";
                  }
              }
          }
      	  $query = "SELECT * FROM $this->tb WHERE 1 $condition";
      	  $this->dao->query($query);
      	  return $this->dao->fetch();
     }

     function count_by_condition($con=''){
          $condition='';
          if(is_array($con) and count($con)>0){
              foreach($con as $k => $v){
                  if($k=="AREA"){
                      $condition = $condition." AND area = '$v'";
                  }else{
                      if(!is_numeric($v)){
                          if($k=="area"){
                              $condition = $condition." AND $k LIKE '%$v%'";
                          }else{
                              $condition = $condition." AND $k = '$v'";
                          }
                      }else{
                          $condition = $condition." AND $k = $v";
                      }
                  }
              }
          }
      		$query = "SELECT count(*) FROM $this->tb WHERE 1".$condition;
      		$this->dao->query($query);
      		$rs = $this->dao->fetch();
      		return $rs['count(*)'];
	   }
     function count_by_query($query){
        //$query = "SELECT count(*) FROM $this->tb WHERE 1".$condition;
          $this->dao->query($query);
          $rs = $this->dao->fetch();
          return $rs['count(*)'];
     }
    	function page($offset, $range, $col='*', $con='',$group=''){
          global $global_db_schema;
          $db_schema = $global_db_schema[$this->tb];
          $condition = '';	
          $columns = '';
          if(is_array($con) and count($con)>0){
              foreach($con as $k => $v){
                  if($k=="AREA"){
                      $condition = $condition." AND area = '$v'";
                  } else if(array_key_exists($k,$db_schema)){
                      if(!is_numeric($v)){
                          if($k=="area"){
                              $condition = $condition." AND $k LIKE '%$v%'";
                          }else{
                              $condition = $condition." AND $k = '$v'";
                          }
                      }else{
                          $condition = $condition." AND $k = $v";
                      }
                  }
              }// end foreach
          }else{
            $condition = $con;
          }

          if(is_array($col) and count($col)>0){
              $first_col = true;
              foreach($col as $k){
                  if($first_col){
                      if($k == "checkbox"){
                          $columns = $columns." \"''\" as checkbox";
                      }else{
                          $columns = $columns."$k";
                      }
                      $first_col = false;
                  }else{
                      if($k == "place_holder"){
                          $columns = $columns.", \"''\" as place_holder";
                      }else{
                          $columns = $columns.", $k";
                      }
                  }
              }// end foreach
          }else{
              $columns = '*';
          }
		      $query = 'SELECT '.$columns.' FROM `'.$this->tb.'` WHERE 1'.$condition;
          if(!empty($group)){
            $query .= $group;
          }
          if($offset!='0' or $range!='-1'){
		          $query .= ' limit '.$offset.','.$range;
          }

      		$this->dao->query($query);
          if($col=='*'){
              // array key is field name (prepare for excel exporting)
              return $this->dao->fetch_all_keys();
          }else{
              // array key is index num
              return $this->dao->fetch_all();
          }		
      }

      function get_result_by_exec_sql($query,$flag=0){
          $this->dao->query($query);
          if($flag==0)
            return $this->dao->fetch_all_keys();
          else
            return $this->dao->fetch_all();
      }
      function get_result_by_sql($query){
          $this->dao->query($query);
          return $this->dao->fetch_all();
      }
      function get_insert_id(){
          return $this->dao->get_insert_id();
      }

}
?>
