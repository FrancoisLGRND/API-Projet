<?php 
include_once "repository.php";

class ReservationService {

    private $repository;

    function __construct() {
        $this->repository = new ReservationRepository();
    }

    function create_reservation($reservation_object) {
        $date1 = DateTime::createFromFormat('Y-m-d', $reservation_object->date_start);
        $date2 = DateTime::createFromFormat('Y-m-d', $reservation_object->date_end);


        $diff = $date1->diff($date2);
        $reservation_object->prix = $diff->days * 50;
        

        return $this->repository->create_reservation($reservation_object);
    }

    function get_reservation($id) {
        return $this->repository->get_reservation($id);
    }

    function delete_reservation($id) {
        $this->repository->delete_reservation($id);
    }
}


?>
