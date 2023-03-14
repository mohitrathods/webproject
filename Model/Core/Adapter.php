<?php
class Adapter {
    public $config = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'databasename' => 'project-mohit-rathod'
    ];

    public $connect = null;
    public function connect(){
        if ($this->connect = null) {
            return $this->connect;
        }
        //else
        $connect = mysqli_connect(
            $this->config['host'],
            $this->config['username'],
            $this->config['password'],
            $this->config['databasename']
        );
        return $connect;
    }

    //FETCH ALL
    public function fetchAll($query){
        $connect = $this->connect();
        $result = mysqli_query($connect, $query);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return $result;
    }
}
?>