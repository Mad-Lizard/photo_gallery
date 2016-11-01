<?php require_once(LIB_PATH.DS."database.php");

class Comment extends DatabaseObject  {
  protected static $table_name = "comments";
  protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');
  protected static $class_name = "Comment";  
  
  public static $id;
  public static $photograph_id;
  public static $created;
  public static $author;
  public static $body;
    
  public static function make($photo_id, $author="Аноним", $body){
     if(!empty($photo_id) && !empty($author) && !empty($body)){
      $comment = new Comment();
      $comment->photograph_id=(int)$photo_id;
      $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
      $comment->author = $author;
      $comment->body = $body;
      return $comment;
  } else {
      return false;
    }
  }
    
  public static function find_comments_on($photo_id=0){
      global $db;
      $sql = "SELECT * FROM ".self::$table_name;
      $sql .=" WHERE photograph_id=". $db->escape_value($photo_id);
      $sql .=" ORDER BY created ASC";
      return self::find_by_sql($sql);
      
  }
    
  public function try_to_send_notification($body){
     
$mail = new PHPMailer();

$mail->IsSMTP();
$mail->Host   = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = false;
$mail->Username = "annamavka@gmail.com";
$mail->Password = "13+guestopen=06";
$mail->Port     = 25;
$mail->isHTML(true);


$mail->FromName = "Photo Gallery";
$mail->From     = "annamavka@gmail.com";
$mail->AddAddress("annamavka@gmail.com", "Photo Gallery Admin");
$mail->Subject  = "New comment";
$created = datetime_to_text($this->created);
$mail->Body     =<<<EMAILBODY
Comment has been received.

At {$this->created}, {$this->author} wrote:
      
{$this->body}
EMAILBODY;

$result=$mail->Send();
return $result;
  }
    
    public static function count_all(){
    global $db;
    $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $count = $db->query($sql); 
    $row = $db->fetch_array($count);
    return array_shift($row);
    }
    
   //DatabaseObject methods
  	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
    public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
    public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
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
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	    $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}  
}
?>