<?php require_once(LIB_PATH.DS."database.php");

class Photograph extends DatabaseObject  {
    
  protected static $table_name = "photographs";
  protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption');
  protected static $class_name = "Photograph";  
  public static $id;
  public static $filename;
  public static $type;
  public static $size;
  public static $caption;
  public static $temp_path;
  protected $upload_dir="images";
  public $errors=array();
    
  protected $upload_errors = array(
UPLOAD_ERR_OK         => "что-то пошло не так.",
UPLOAD_ERR_INI_SIZE   => "Размер файла больше, чем  upload_max_filesize.",
UPLOAD_ERR_FORM_SIZE  => "Размер файла больше, чем MAX_FILE_SIZE.",
UPLOAD_ERR_PARTIAL    => "частичная загрузка файла.",
UPLOAD_ERR_NO_FILE    => "файл отсутствует.",
UPLOAD_ERR_NO_TMR_DIR => "отсутствует временная директория.",
UPLOAD_ERR_CANT_WRITE => "невозможно сделать запись на диск.",
UPLOAD_ERR_EXTENSION  => "загрузка файла была приостановлена."
);
    
  public function attach_file($file) {
      if(!$file||empty($file)||!is_array($file)){
          $this->errors[]= "Файл не был получен.";
          return false;
      } elseif($file['error']!=0) {
          $this->errors[]= $this->upload_errors[$file['error']];
          return false;
      } else {
      $this->temp_path = $file['tmp_name'];
      $this->filename = basename($file['name']);
      $this->type = $file['type'];
      $this->size = $file['size'];
      return true;
      }
   }
    
public function image_path(){
    return $this->upload_dir.DS.$this->filename;
}
    
public function size_as_text(){
    if($this->size < 1024){
        return "{$this->size} bytes";
    } elseif($this->size < 1048576){
        $size_kb = round($this->size / 1024);
        return "{$size_kb} KB";
    } else {
        $size_mb = round($this->size / 1048576, 1);
         return "{$size_mb} MB";
    }
}
    
public function comments(){
    return Comment::find_comments_on($this->id);
}

public static function count_all(){
    global $db;
    $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $count = $db->query($sql); 
    $row = $db->fetch_array($count);
    return array_shift($row);
}
    
  private function has_attribute($attribute){
         return array_key_exists($attribute, self::attributes());
  }
    
  protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
          
	    if(property_exists($this, $field)) {
          $attributes[$field] = $this->$field;
        }
	  }
       
	  return $attributes;
  }  
    
  protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
          
	  }
	  return $clean_attributes;
	}    
    
  public function save(){
      if(isset($this->id)){
          $this->update();
      } else {
          if(!empty($this->errors)){return false;}
          if(strlen($this->caption)>=255){
              $this->errors[]="Размер описания не может превышать 255 символов.";
              return false;
          }
          if(empty($this->filename)|| empty($this->temp_path)){
              $this->errors[] = "Файл не доступен.";
              return false;
          } 
          
          $target_path = SITE_ROOT.DS.'public'.DS.$this->upload_dir.DS.$this->filename;
          
          if(file_exists($target_path)){
              $this->errors[]="Файл {$this->filename} уже существует.";
              return false;
          }
          
        if(move_uploaded_file($this->temp_path, $target_path)){
             if($this->create()){
             unset($this->temp_path);
             return true; 
             }
        } else {
            $this->errors[]="Не получилось загрузчить файл {$this->filename}.";
              return false;
        }
     }
         
    }
  
    
     //DatabaseObject functions
//  public function save(){
//      return isset(self::$id) ? self::update() : self::create();
//  }
    
  public function create(){
    global $db;
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ".self::$table_name." (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('"  ;
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
           
    if($db->query($sql)){
        $this->id = $db->insert_id();
        return true;
  } else {
        return false;
    }
  }
      
  public function update() {
     global $db; 
    $attributes[] = self::sanitized_attributes(); 
    $attribute_pairs = array();
    foreach($attributes as $key => $value){
        $attribute_pairs[]= "{$key}='{$value}'";
    }  
    $sql = "UPDATE ".self::$table_name." SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id = ".self::$id;
    $sql .= " LIMIT 1";
   
    $db->query($sql);
    return ($db->affected_rows() == 1) ? true : false;
  }
      
  public function delete() {
      global $db;
      
      $sql = "DELETE FROM  ".self::$table_name;
      $sql .= " WHERE id = ". $db->escape_value($this->id);
      $sql .= " LIMIT 1";
   
    $db->query($sql);
    return ($db->affected_rows() == 1) ? true : false;
  }
    
  public function destroy(){
      global $db;
     if($this->delete()){
     $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
     return unlink($target_path)? true: false;
     } else {
         return false;
     }
      
  }

  public static function find_all(){
       return self::find_by_sql("SELECT * FROM ".self::$table_name);
    }
    
  public static function find_by_id($id=0){
        global $db;
      $sql = "SELECT * FROM ". self::$table_name ." WHERE id=".$db->escape_value($id)." LIMIT 1";
        $result_array=self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
      
    }
    
  public static function find_by_sql($sql=""){
       global $db;
      $result_set = $db->query($sql);
      $object_array = array();
      while ($row = $db->fetch_array($result_set)) {
          $object_array[]=self::instantiate($row);
      } 
      return $object_array; 
    }
  
  private static function instantiate($record){
      $object = new self();
//    $object->id         = $record['id'];
//    $object->username   = $record['username'];
//    $object->password   = $record['password'];
//    $object->first_name = $record['first_name'];
//    $object->last_name  = $record['last_name'];
      
      foreach($record as $attribute=>$value){
          if($object->has_attribute($attribute)){
              $object->$attribute = $value;
          }
      }
      return $object;
  }
    
// public static function find_all {
//     global $db;
//     $photo_array = array();
//     $photo_array = self::find_by_sql("SELECT filename FROM photographs");
//     return $photo_array;
//   }
      
}
    
    
?>