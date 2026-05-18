<?php

class TripDTO {
    public int $id;
    public string $name;
    public float $distance;
    public int $duration;
    public string $duration_unit;
    public int $difficulty_id;
    public string $difficulty_name;
    public string $location;
    public string $route_url;
    public ?string $attractions;
    public ?string $suitable_for;
    public int $no_dogs;
    public ?string $notes;
    public ?string $images;
    public string $created_at;
    public int $created_by;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->distance = $data['distance'];
        $this->duration = $data['duration'];
        $this->duration_unit = $data['duration_unit'];
        $this->difficulty_id = $data['difficulty_id'];
        $this->difficulty_name = $data['difficulty_name'] ?? '';
        $this->location = $data['location'];
        $this->route_url = $data['route_url'];
        $this->attractions = $data['attractions'] ?? null;
        $this->suitable_for = $data['suitable_for'] ?? null;
        $this->no_dogs = $data['no_dogs'];
        $this->notes = $data['notes'] ?? null;
        $this->images = $data['images'] ?? null;
        $this->created_at = $data['created_at'];
        $this->created_by = $data['created_by'] ?? 0;
    }
}