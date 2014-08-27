<?php
$dbname = '../secured/g00dcorner.db';
$avatars_path = '../secured/avatars/';
$photos_path = '../secured/photos/';

$tbl_users = "CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE NOT NULL, email TEXT, password TEXT, lastname TEXT, firstname TEXT, address TEXT, user_agent TEXT, avatar_path TEXT);";
$tbl_objects = "CREATE TABLE IF NOT EXISTS objects (id INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE NOT NULL, title TEXT, description TEXT, prix INTEGER, photo_path TEXT, category_id INTEGER NOT NULL, user_id INTEGER NOT NULL);";
$tbl_categories = "CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE NOT NULL, title TEXT);";

$db = new SQLite3($dbname);
$db->exec($tbl_users);
$db->exec($tbl_objects);
$db->exec($tbl_categories);
$db->close();

function create_user($mail, $passwd, $lastname, $firstname, $address, $avatar_path){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_mail = $db->escapeString($mail);
    $safe_passwd = md5($passwd);
    $safe_lastname = $db->escapeString($lastname);
    $safe_firstname = $db->escapeString($firstname);
    $safe_address = $db->escapeString($address);
    $safe_avatar_path = $db->escapeString($avatar_path);

    $query = "INSERT INTO users (email, password, lastname, firstname, address, user_agent, avatar_path) VALUES 
        ('".$safe_mail."', '".$safe_passwd."', '".$safe_lastname."', '".$safe_firstname."', '".$safe_address."', '".$_SERVER['HTTP_USER_AGENT']."', '".$safe_avatar_path."')";

    $result = $db->exec($query);
    
    $db->close();

    return $result;
}

function update_user($uid, $passwd, $lastname, $firstname, $address, $avatar_path){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_uid = (int)$uid;
    $safe_passwd = md5($passwd);
    $safe_lastname = $db->escapeString($lastname);
    $safe_firstname = $db->escapeString($firstname);
    $safe_address = $db->escapeString($address);
    $safe_avatar_path = $db->escapeString($avatar_path);

    $query = "UPDATE users SET password='".$safe_passwd."', lastname='".$safe_lastname."', firstname='".$safe_firstname."', address='".$safe_address."', user_agent='".$_SERVER['HTTP_USER_AGENT']."', avatar_path='".$safe_avatar_path."' WHERE id=".$safe_uid;

    $result = $db->exec($query);

    $db->close();

    return $result;
}

function user_login($mail, $passwd){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_mail = $db->escapeString($mail);
    $safe_passwd = md5($passwd);

    $query = "SELECT id FROM users WHERE email='".$safe_mail."' and password='".$safe_passwd."'";

    $result = (int)$db->querySingle($query);    

    $db->close();

    return $result;
}

function user_exists($mail){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_mail = $db->escapeString($mail);

    $query = "SELECT id FROM users WHERE email='".$safe_mail."'";

    $result = (int)$db->querySingle($query);    

    $db->close();

    return $result;
}

function get_user_infos($uid){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT * FROM users WHERE id=".(int)$uid;

    $result = $db->querySingle($query, true);

    $db->close();

    return $result;
}

function get_category($category_id){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT title FROM categories WHERE id=".(int)$category_id;

    $result = $db->querySingle($query);    

    $db->close();

    return $result;
}

function get_categories(){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT * FROM categories";

    $sqlResult = $db->query($query);

    $result = array();
    $i = 0;

    while($res = $sqlResult->fetchArray(SQLITE3_ASSOC)){ 
        $result[$i] = $res; 
        $i++;
    }
 
    $db->close();

    return $result;
}

function category_exists($category_name){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_category_name = $db->escapeString($category_name);

    $query = "SELECT id FROM categories WHERE title='".$safe_category_name."'";

    $result = (int)$db->querySingle($query);    

    $db->close();

    return $result;
}

function create_category($category_name){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_category_name = $db->escapeString($category_name);

    $query = "INSERT INTO categories (title) VALUES ('".$safe_category_name."')";

    $db->exec($query);    
    $result = $db->lastInsertRowID();

    $db->close();

    return $result;
}

function create_object($title, $description, $price, $photo_path, $cat_id, $user_id){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_title = $db->escapeString($title);
    $safe_description = $db->escapeString($description);
    $safe_price = (int)$price;
    $safe_photo_path = $db->escapeString($photo_path);
    $safe_cat_id = (int)$cat_id;
    $safe_user_id = (int)$user_id;

    $query = "INSERT INTO objects (title, description, prix, photo_path, category_id, user_id) VALUES 
        ('".$safe_title."', '".$safe_description."', '".$safe_price."', '".$safe_photo_path."', '".$safe_cat_id."', '".$safe_user_id."')";

    $result = $db->exec($query);
    
    $db->close();

    return $result;
}

function update_object($oid, $description, $price, $photo_path, $cat_id){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_oid = (int)$oid;
    $safe_description = $db->escapeString($description);
    $safe_price = (int)$price;
    $safe_photo_path = $db->escapeString($photo_path);
    $safe_cat_id = (int)$cat_id;

    $query = "UPDATE objects SET description='".$safe_description."', prix=".$safe_price.", photo_path='".$safe_photo_path."', category_id='".$safe_cat_id."' WHERE id=".$safe_oid;

    $result = $db->exec($query);

    $db->close();

    return $result;
}

function get_object($oid){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT objects.id as id, objects.title as title, objects.description as description, objects.prix as price, objects.photo_path as photo_path, objects.category_id as category_id, categories.title as category_name, users.firstname as firstname, users.lastname as lastname, users.email as email, users.avatar_path as avatar FROM objects JOIN categories ON objects.category_id=categories.id JOIN users ON objects.user_id=users.id WHERE objects.id=".(int)$oid;

    $result = $db->querySingle($query, true);

    $db->close();

    return $result;
}

function object_exists($oid){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT id FROM objects WHERE id=".(int)$oid;

    $result = (int)$db->querySingle($query); 

    $db->close();

    return $result;
}

function get_objects_user($uid){
    global $dbname;
    $db = new SQLite3($dbname);

    $query = "SELECT * FROM objects WHERE user_id=".(int)$uid;

    $sqlResult = $db->query($query);

    $result = array();
    $i = 0;

    while($res = $sqlResult->fetchArray(SQLITE3_ASSOC)){ 
        $result[$i] = $res; 
        $i++;
    } 


    $db->close();

    return $result;
}

function delete_object($oid){
    global $dbname;
    $db = new SQLite3($dbname);

    $object = get_object($oid);

    $query = "DELETE FROM objects WHERE id=".(int)$oid;
    $result = $db->exec($query);

    $query = "SELECT count(*) FROM objects WHERE category_id=".(int)$object['category_id'];
    $reste = $db->querySingle($query);

    if($reste == 0){
        $query = "DELETE FROM categories WHERE id=".(int)$object['category_id'];
        $result = $db->exec($query);
    }

    $db->close();

    return $result;
}

function search_object($keyword, $category){
    global $dbname;
    $db = new SQLite3($dbname);

    $safe_keyword = $db->escapeString($keyword);
    $safe_category = $db->escapeString($category);

    $query = "SELECT objects.id as id, objects.title as title, objects.description as description FROM objects JOIN categories ON objects.category_id=categories.id WHERE categories.id ".$safe_category." AND (objects.title like '%".$safe_keyword."%' OR objects.description like '%".$safe_keyword."%')";

    $sqlResult = $db->query($query);

    $result = array();
    $i = 0;

    while($res = $sqlResult->fetchArray(SQLITE3_ASSOC)){ 
        $result[$i] = $res; 
        $i++;
    } 

    $db->close();

    return $result;
}

function upload_avatar($file){
    global $avatars_path;
    $cmd = "convert -resize '200x200^' ".$file['tmp_name']." ".$avatars_path.$file['name'];
    system($cmd);
    return $file['name'];
}

function upload_photo($file){
    global $photos_path;
    $cmd = "convert -resize '300x300^' ".$file['tmp_name']." ".$photos_path.$file['name'];
    system($cmd);
    return $file['name'];
}

function print_avatar($filename){
    global $avatars_path;
    $finfo = finfo_open(FILEINFO_MIME_TYPE); 
    $mime = finfo_file($finfo, $avatars_path.$filename);
    return "data:".$mime.";base64,".base64_encode(file_get_contents($avatars_path.$filename));
}

function print_photo($filename){
    global $photos_path;
    $finfo = finfo_open(FILEINFO_MIME_TYPE); 
    $mime = finfo_file($finfo, $photos_path.$filename);
    return "data:".$mime.";base64,".base64_encode(file_get_contents($photos_path.$filename));
}

?>