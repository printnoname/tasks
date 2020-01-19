<?php
namespace Core;

class Paginator {
    
    private $page; 
    private $perPage;
    private $totalPages;
    
    public function __construct($perPage = 3, $page = 1, $totalPages = 1) {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalPages = $totalPages;
    }
    
    public function getCurrentPage() {
        return $this->page;
    }

    public function getPerPage() {
        return $this->perPage;
    }

    public function getOffset() {
        return ($this->getCurrentPage() - 1) * $this->getPerPage();
    }

    public function getTotalPages(){
        return $this->totalPages;
    }
}
