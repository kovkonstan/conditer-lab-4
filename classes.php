<?php



class Item {
    private $id;
    private $type;
    private $name;
    private $date;
    private $count;
    function __construct ($id,$type,$name,$count,$date){
        $this->type=$type;
        $this->id=$id;
        $this->name=$name;
        $this->date=$date;
        $this->count=$count;
    }
    function GetID () {
        return $this->id;
    }
    
    function SetID($id) {
       $this->id=$id;
    }	
    
    function GetType ()
    {
        return $this->type;
    }
    
    function SetType($type)
    {
         $this->type=$type;
    }
    
    function GetName () {
        return $this->name;
    }
    
    function SetName($name) {
       $this->name=name;
    }
    
    function GetCount () {
        return $this->count;
    }
    
    function SetCount($count) {
       $this->count=count;
    }
    
    function GetDate () {
        return $this->date;
    }
    
    function SetDate($date) {
       $this->date=date;
    }
    
    
}



class Link
{
    private $sql;
	private $users;
    
    function __construct($host,$user,$pw,$db) {
        $this->sql=new mysqli;
        $this->sql->connect($host,$user,$pw);
        $this->sql->select_db('sklad');
        $this->sql->query("SET NAMES 'UTF8'");
		$this->users = array("admin"=>"admin", "ivanov"=>"ivanov", 
			"petrov" => "petrov", "sidorov" => "sidorov");		
    }
    
    function query($query)
    {
        $result=$this->sql->query($query);
        return $result;
    }
	
	function Login($user, $pass)
	{		
		foreach($this->users as $us=>$psw)
		{
			if($user == $us)
			{
				if($pass == $psw)
				{
					return "OK";
				}
				else return "INVALID_PASS";				
			}		
		}
		return "NOT_USER";
	}
	
	function LoginIsExist($user)
	{		
		foreach($this->users as $us=>$psw)
		{
			if($user == $us)
			{
				return "OK";			
			}		
		}
		return "NOT_USER";
	}
    
    function GetTypes()
    {
        $query="SELECT id,type_name FROM types";
        $result=$this->query($query);
        if ($result !=NULL)
        while ( $row=mysqli_fetch_array($result))
       {
          $ids[]=$row; 
       }
       return $ids;
    }
    
    
    function AddType($name)
    {
        $query="INSERT INTO types VALUES (NULL,'$name')";
        $result=$this->query($query);
        if ($result==FALSE || $result==NULL) return FALSE;
        else return TRUE;
    }
    
    
    
    
   function GetItem($id) 
   {
       $query="SELECT  `items`.`id` ,  `items`.`name` ,  `items`.`count` ,  `items`.`date` ,  `types`.`type_name` 
               FROM items, TYPES 
               WHERE  `items`.`id` =$id
               AND  `types`.`id` =  `items`.`type_id` ";
       $result=$this->sql->query($query);
       if ($result !=NULL) {
           $row=mysqli_fetch_array($result);
           $item=new Item($row['id'],$row['type_name'],$row['name'],$row['count'],$row['date']);
           return $item;
       }
       else return false;
   }
   
    function GetItems() 
   {
       $query="SELECT id from items order by id desc";
       $result=$this->query($query);
       if ($result !=NULL) {
       while ($row= mysqli_fetch_array($result))
           $arr[]=$this->GetItem($row['id']);
       return $arr;
       }
       else return false;
   }
   
   function GetItemsByPage($page, $itemsByPage) 
	{
		if ($itemsByPage ==NULL) $itemsByPage = 5;
		if ($page ==NULL) $page = 1;
		
	   $query="SELECT id from items order by id desc";
	   $result=$this->query($query);
	   if ($result !=NULL) {
	   while ($row= mysqli_fetch_array($result))
		   $arr[]=$this->GetItem($row['id']);
	   
	   $countOfItems = count($arr);
	   $countOfPages = ceil($countOfItems/$itemsByPage);
	   $resultArr;
	   
	   $counter = $itemsByPage;
	   if(($page-1)*$itemsByPage + $itemsByPage > $countOfItems)
	   {
		   $counter = $countOfItems - ($page-1)*$itemsByPage;
	   }
	   
	   for ($i = 0; $i < $counter; $i++)
	   {

		   $resultArr[] = $arr[($page-1)*$itemsByPage + $i];
		   						   		
	   }
	   
	   $res = array(
	   "array" => $resultArr,
	   "page" => $page,
	   "itemsByPage" => $itemsByPage,
	   "countOfPages" => $countOfPages);
	   
	   return $res;
	   }
	   else return false;
	}
   
   
   
   function AddItem ($item)
   {
       $name=$item->GetName();
       $count=$item->GetCount();
       $type=$item->GetType();
       $query="INSERT INTO items VALUES (NULL,$type,'$name',DEFAULT,$count)";
       $result=$this->sql->query($query);
       if ($result==NULL) return FALSE;
        else return true;
   }

   function DeleteItem ($id)
   {
       
       $query="DELETE FROM items where id=$id";
       $this->query($query);
   }
   
   function UpdateItem ($count,$id)
   {
          $query="UPDATE goods set  count=$count,date=DEFAULT where id=$id";
          if ($this->query($query) !=FALSE) return TRUE;
     else echo 'ERROR';
   }
   
   function GetAllCount()
   {
      $query="SELECT count from items";
      $count=0;
      $result=$this->query($query);
      if ($result !=NULL) {
          while ($row=mysqli_fetch_array ($result))
              $count+=$row['count'];
          return $count;
      } 
     else return 0; 
   }
   
   
 function __destruct() {
    $this->sql->close();
}
}

?>
