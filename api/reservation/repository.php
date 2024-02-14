<?php
include_once "./common/exceptions/repository_exceptions.php";

class ReservationRepository {

    private $connection = null;

    public function __construct() {
        try {
            $this->connection = pg_connect("host=database port=5432 dbname=todo_db user=todo password=password");
            if (  $this->connection == null ) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception("Database connection failed :".$e->getMessage());
        }
    }

    

    public function get_reservation($id): mixed {
        $result = pg_query($this->connection, "SELECT * FROM reservation where id = $id");

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        $reservation = pg_fetch_assoc($result); 

        if (!$reservation) {
            throw new BddNotFoundException("Requested to-do does not exist");        
        }

        return $reservation;

    }

    public function delete_reservation($id): void {
       $query = pg_prepare($this->connection,"","DELETE FROM reservation WHERE id = $1");

       $result = pg_execute($this->connection, "",[$id]);
    }

    public function create_reservation($reservation_object): void {
        $query = pg_prepare($this->connection, "", "INSERT INTO reservation (date_start, date_end, client_id, prix, appartement_id) VALUES ($1, $2, $3, $4, $5)");
        $reservation_object->done = true;
        $result = pg_execute($this->connection, "", [$reservation_object->date_start, $reservation_object->date_fin, $reservation_object->client_id, $reservation_object->prix, $reservation_object->appartement_id]);

        if (!$result) {
            throw new Exception(pg_last_error());
        }

        return;
    }

    /*public function update_todo($id , $todo_object ): void {
        $query = "UPDATE todos set ";

        if (isset($todo_object->done)) {
            if ($todo_object->done == "true") {
                $query .= " done = TRUE ";
            } else if ($todo_object->done == "false") {
                $query = " done = FALSE ";
            }
        }

        if (isset($todo_object->done) && isset($todo_object->description)) {
            $query .= " , ";
        }

        if (isset($todo_object->description)) {
            $query .= " description = '".$todo_object->description."' ";
        }

        $query .= " where id = $id; ";
        $result = pg_query($this->connection,$query); 

        if (!$result) {
           throw new Exception(pg_last_error());
        }
    }
    */
}
