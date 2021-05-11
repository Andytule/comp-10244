<?php

class Camp implements JsonSerializable
{
    private $id;
    private $name;
    private $url;
    private $longitude;
    private $latitude;
    private $address;
    private $community;

    function __construct($id, $name, $url, $longitude, $latitude, $address, $community)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->community = $community;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

?>