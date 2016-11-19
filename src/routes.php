<?php

// Routes



$app->get('/', function ($request, $response, $args) {

	$this->db;
    $paintings = Datasite::all();
    return $this->renderer->render($response, 'homepage.phtml', ["datasites"=>$paintings]);

});


$app->get('/paint/{id}', function ($request, $response, $args) {

     $this->db;

     $var=(int) $args['id'];
     $painting = Datasite::find($var);

    return $this->renderer->render($response, 'paintings.phtml', ["datasite"=>$painting]);
});

$app->get('/delete/[{id}]', function ($request, $response, $args) {

     $this->db;

     $var=(int) $args['id'];

     $paintings = Datasite::destroy($var);

     $paintings = Datasite::all();
    return $this->renderer->render($response, 'homepage.phtml', ["datasites"=>$paintings]);

});

$app->get('/update/[{id}]', function ($request, $response, $args) {

     $this->db;

     $var=(int) $args['id'];

     $painting = Datasite::find($var);
    return $this->renderer->render($response, 'update.phtml', ["datasite"=>$painting]);

});

$app->post('/update/[{id}]', function ($request, $response, $args) {

     $this->db;

     $var=(int) $args['id'];

     $data = Datasite::find($var);
     $data->author=$_POST["author"];
     $data->description=$_POST["description"];
     $data->title=$_POST["title"];
     $data->date_creation=$_POST["date_creation"];
     $data->place=$_POST["place"];
     $data->place_creation=$_POST["place_creation"];
     
     $data->save();



    $paintings = Datasite::all();
    return $this->renderer->render($response, 'homepage.phtml', ["datasites"=>$paintings]);

});



$app->post('/create', function ($request, $response, $args) {


	$type_file = $_FILES['imgFile']['type'];

    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png'))
    {
    	echo "<script>alert(\"File invalid\")</script>"; 
        $this->db;
    $paintings = Datasite::all();
    return $this->renderer->render($response, 'homepage.phtml', ["datasites"=>$paintings]);
    }



     
     if(isset($_FILES['imgFile']))
{ 
     $dossier = './public/Images/';
     $fichier = basename($_FILES['imgFile']['name']);
   if(move_uploaded_file($_FILES['imgFile']['tmp_name'], $dossier . $fichier))
                {
 
                    $_SESSION['mess'] = 'Fiche enregistrée !';
                $size = GetImageSize( $dossier . $fichier );
                    $width = $size[ 0 ];
                    $height = $size[ 1 ];
                    $dest_h = 150;
                    $dest_w = 200;
                    $miniature = ImageCreateTrueColor( $dest_w, $dest_h);
                    $image = ImageCreateFromJpeg( $dossier . $fichier );
                    ImageCopyResampled( $miniature, $image, 0, 0, 0, 0, $dest_w, $dest_h, $width, $height );
                    ImageJpeg( $miniature, $dossier . 'thumb_' . $fichier, 100 );
                }
                else
                {
                    $_SESSION['mess'] = 'Echec de l\'upload de l\'image !';
                }

}




    $this->db;

    $data = new Datasite();
    $data->author=$_POST["author"];
    $data->description=$_POST["description"];
    $data->title=$_POST["title"];
    $data->date_creation=$_POST["date_creation"];
    $data->place=$_POST["place"];
    $data->place_creation=$_POST["place_creation"];    
    $data->img=$_FILES['imgFile']['name'];
    
    $data->save();


    $paintings = Datasite::all();
    return $this->renderer->render($response, 'homepage.phtml', ["datasites"=>$paintings]);
     
    });


$app->get('/create', function ($request, $response, $args) {

 return $this->renderer->render($response, 'create.phtml', $args);
});


$app->get('/contact', function ($request, $response, $args) {

 return $this->renderer->render($response, 'contact.phtml', $args);
});


$app->get('/install', function ($request, $response, $args) {
    $capsule = new \Illuminate\Database\Capsule\Manager;

	$this->db;

	$capsule::schema()->dropIfExists('datasites');
    $capsule::schema()->create('datasites', function (\Illuminate\Database\Schema\Blueprint $table) {
        $table->increments('id');
        $table->string('author');
        $table->longText('description');
        $table->string('title');
        $table->string('date_creation');
        $table->string('place');
        $table->string('place_creation');
        $table->string('img');
        $table->timestamps();
    });

    $data = new Datasite();
    $data->author="Léonard de Vinci";
    $data->description="La Joconde, ou Portrait de Mona Lisa, est un tableau de l'artiste italien Léonard de Vinci, réalisé entre 1503 et 1506, qui représente un portrait mi-corps, probablement celui de la florentine Lisa Gherardini, épouse de Francesco del Giocondo.";
    $data->title="La Joconde";
    $data->date_creation="1503";
    $data->place="Musée du Louvre";
    $data->place_creation="Florence";
    $data->img="Joconde.jpg";
    $data->save();

    $var = new Datasite();
    $var->author="Edvard Munch";
    $var->description="Le Cri est une œuvre expressionniste de l'artiste norvégien Edvard Munch dont il existe cinq versions réalisées entre 1893 et 1917.";
    $var->title="Le Cri";
    $var->date_creation="1893–1893";
    $var->place="Galerie nationale d'Oslo, Musée Munch";
    $var->place_creation="Norvège";
    $var->img="cri.jpg";
    $var->save();

    $aa = new Datasite();
    $aa->author="Vincent van Gogh";
    $aa->description="La Nuit étoilée est une peinture de l'artiste peintre post-impressionniste néerlandais Vincent van Gogh";
    $aa->title="La Nuit étoilée";
    $aa->date_creation="juin 1889";
    $aa->place="Museum of Modern Art";
    $aa->place_creation="Saint-Rémy-de-Provence, France";
    $aa->img="NuitEtoile.jpg";
    $aa->save();

    $bb = new Datasite();
    $bb->author="Paul Cézanne";
    $bb->description="Dans la version à deux personnages, la composition est totalement différente. L'arrière-plan est presque complètement sombre et seules quelques bandes claires offrent un indice sur la localisation, probablement la terrasse couverte d'un café. Chaque détail du tableau a sa fonction pour l'effet d'ensemble. Rien n'est laissé au hasard. Refusant toute mise en scène naturaliste ou représentation anecdotique, Cézanne parvient ici à réaliser une composition soigneusement conçue, constituée de lignes axiales et de correspondances chromatiques et formelles, dans laquelle sont immortalisées de la même manière monumentalité et intimité.";
    $bb->title="Les Joueurs de cartes";
    $bb->date_creation="1892–1895";
    $bb->place="Musée d'Orsay";
    $bb->place_creation="Aix-en-Provence, France";
    $bb->img="JoueurCarte.jpg";
    $bb->save();



 return $this->renderer->render($response, 'homepage.phtml', $args);

});

