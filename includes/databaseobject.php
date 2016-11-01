<?php  //require_once(LIB_PATH.DS."database.php");

class DatabaseObject {

//    
 protected static $table_name = "";
 protected static $db_fields = array();
//    
 protected static $id;}
//     
   
//  public function save(){
//      return isset(self::$id) ? self::update() : self::create();
//  }
//    
//  public function create(){
//    global $db;
//    $attributes = static::sanitized_attributes();
//      var_dump($sql);
//    $sql = "INSERT INTO ".static::$table_name." (";
//    $sql .= join(", ",array_keys($attributes));
//    $sql .= ") VALUES ('"  ;
//    $sql .= join("', '", array_values($attributes));
//    $sql .= "')";
//       var_dump($sql);
//      
//    if($db->query($sql)){
//        self::$id = $db->insert_id();
//        return true;
//  } else {
//        return false;
//    }
//  }
//      
//  public function update() {
//     global $db; 
//    $attributes[] = self::sanitized_attributes(); 
//    $attribute_pairs = array();
//    foreach($attributes as $key => $value){
//        $attribute_pairs[]= "{$key}='{$value}'";
//    }  
//    $sql = "UPDATE ".self::$table_name." SET ";
//    $sql .= join(", ", $attribute_pairs);
//    $sql .= " WHERE id = ".self::$id;
//    $sql .= " LIMIT 1";
//   
//    $db->query($sql);
//    return ($db->affected_rows() == 1) ? true : false;
//  }
//      
//  public function delete() {
//      global $db;
//      
//      $sql = "DELETE FROM  ".self::$table_name;
//      $sql .= " WHERE id = ". $db->escape_value(self::$id);
//      $sql .= " LIMIT 1";
//   
//    $db->query($sql);
//    return ($db->affected_rows() == 1) ? true : false;
//  }
// //DatabaseObject
//    
//    
//  public static function find_all(){
//       return self::find_by_sql("SELECT * FROM ".self::$table_name);
//    }
//    
//  public static function find_by_id($id=0){
//        global $db;
//      $sql = "SELECT * FROM ". self::$table_name ." WHERE id={$id} LIMIT 1";
//        $result_array=self::find_by_sql($sql);
//        return !empty($result_array) ? array_shift($result_array) : false;
//      
//    }
//    
//  public static function find_by_sql($sql=""){
//       global $db;
//      $result_set = $db->query($sql);
//      $object_array = array();
//      while ($row = $db->fetch_array($result_set)) {
//          $object_array[]=self::instantiate($row);
//      } 
//      return $object_array; 
//    }
//  
//  private static function instantiate($record){
//      $object = new self();
////    $object->id         = $record['id'];
////    $object->username   = $record['username'];
////    $object->password   = $record['password'];
////    $object->first_name = $record['first_name'];
////    $object->last_name  = $record['last_name'];
//      
//      foreach($record as $attribute=>$value){
//          if($object->has_attribute($attribute)){
//              $object->$attribute = $value;
//          }
//      }
//      return $object;
//  }
//    
//  private function has_attribute($attribute){
//         return array_key_exists($attribute, self::attributes());
//  }
//    
//  function attributes() { 
//		// return an array of attribute names and their values
//	  $attributes = array();
//	  foreach(static::$db_fields as $field) {
//	    if(isset($field)) {
//	      $attributes[$field] = $field;
//	    }
//	  }
//	  return $attributes;
//  }  
//    
//    protected function sanitized_attributes() {
//	  global $database;
//	  $clean_attributes = array();
//	  // sanitize the values before submitting
//	  // Note: does not alter the actual value of each attribute
//	  foreach(static::attributes() as $key => $value){
//	    $clean_attributes[$key] = $database->escape_value($value);
//	  }
//	  return $clean_attributes;
//	}
//  

?>