<?php 
include_once "service.php";
include_once "reservation.php";


class ReservationController {

    private $service;

    function __construct() {
        $this->service = new ReservationService();
    }

    /*function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                if (isset($req->uri[3])) {
                    $this->get_todo($req, $res);
                    break;
                }
                $this->get_todos($req, $res);
            break;

            case "PATCH":
               $res->content = $this->update_todo($req, $res); 
            break;
            
            case "DELETE":
                $this->delete_todo($req, $res);
            break;

            case "POST":
                $this->create_todo($req, $res);
            break;
        }
        */
    function dispatch($req, $res) {
        switch ($req->method) {
            case "GET":
                $this->get_reservation($req, $res);
            break;

            case "DELETE":
                $this->delete_reservation($req, $res);
            break;

            case "POST":
                $this->create_reservation($req, $res);
            break;
        }

    }

    function create_reservation($req, $res) {
        $reservation_object = new Reservation();
        $reservation_object->date_start = $req->body->date_start;
        $reservation_object->date_end = $req->body->date_end;
        $reservation_object->client_id = $req->body->client_id;
        $reservation_object->appartement_id = $req->body->appartement_id;
        
        $new_reservation = $this->service->create_reservation($reservation_object);
    }
  

    function get_reservation($req, $res) {
        if (!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = '{"message":"Cannot get without ID"}';
        }
        $reservation = $this->service->get_reservation($req->uri[3]);
        $res->content = $reservation;
    }

    function delete_reservation($req, $res) {
        if (!isset($req->uri[3])) {
            $res->status = 400;
            $res->content = '{"message":"Cannot delete without ID"}';
        }

        $this->service->delete_reservation($req->uri[3]);
    }
}

?>
