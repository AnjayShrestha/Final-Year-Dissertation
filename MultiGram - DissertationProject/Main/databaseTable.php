<?php
//creating class for database table as DbTable.
	class DatabaseTable{
			public $pdo ; public $tblName;
			function __construct($pdo, $tblName){
				$this->pdo = $pdo;
				$this->tblName = $tblName;
			}
			function submit($entry, $pk=''){
    			try{
        			$this->insert($entry);
   					}
				catch(Exception $e)
					{
       			 	$this->edit($entry, $pk);
    				}
			}
            // function to insert data in table
			function Insert($entry) {
    			$keys = array_keys($entry);

    			$values = implode(', ', $keys);
    			$valuesWithColon = implode(', :', $keys);

    			$stmt = $this->pdo->prepare('INSERT INTO '. $this->tblName .' ('.$values.') VALUES (:'.$valuesWithColon.')');

    			$stmt->execute($entry);
            }

function Update($entry, $pk){
$qry= "update '$tblName' set ";
$param=[];
foreach ($entry as $key => $value){
    $param[]=$key."= :".$key;
}
$qry .=implode(', ',$param);
$qry .= " WHERE $pk= :pk";
$entry['pk'] = $entry[$pk];
$stmt = $pdo->prepare($qry);
$stmt->execute($entry);
}
//function to delete table information.
function delete($area, $id) {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $this->tblName . ' WHERE '. $area . ' = :id');
        $result = [
                'id' => $id
        ];
        $stmt->execute($result);
        return $stmt;
}

//funtion to search accordingly.
function search($area, $data) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->tblName . ' WHERE ' . $area . ' = :data');
        $result = [
                'data' => $data
        ];
        $stmt->execute($result);
        return $stmt;
}

//function to show information in desc order.
function descOrder($area) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->tblName . ' ORDER BY ' . $area . ' DESC');
        $stmt->execute();
        return $stmt;
}
//function to search all the information of single table. 
function searchAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->tblName );

        $stmt->execute();

        return $stmt;
}

}
 ?>
