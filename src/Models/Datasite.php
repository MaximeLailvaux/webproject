<?php



use Illuminate\Database\Eloquent\Model as Eloquent;

class Datasite extends Eloquent {

    // Eléments de notre Site
    
    
	


    private $author; 
    private $title;
    private $date_creation ;
    private $place ;
    private $place_creation;
	private $description ;
    private $img ;

    public function getDescription(){
    	return $description;

    }




    
}
?>


