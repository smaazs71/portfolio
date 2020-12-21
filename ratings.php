<?php
//     To Rate
// https://statutable-drunks.000webhostapp.com/ratings.php?sender=rate&ux=5&responsiveness=5&design=4&average=4.66

//     To Review
// https://statutable-drunks.000webhostapp.com/ratings.php?sender=review&ux=5&responsiveness=5&design=4&average=4.66

function newRating()
{
    $ratings = json_decode(file_get_contents(__DIR__ . '/ratingData.json'), true);

    if($_GET['sender'] == "visit"){
        $ratings[0]['visits'] = $ratings[0]['visits'] + 1; 
        file_put_contents(__DIR__ . '/ratingData.json', json_encode($ratings, JSON_PRETTY_PRINT));
        return $ratings[0]['visits'];
    }

    if($_GET['sender'] == "review")
        return $ratings[0];
        
    if($_GET['sender'] != "rate")
        return "Invalid Device ID";
    // $data['id'] = rand(1000000, 2000000);

echo(count($ratings));

    $id = 1000000;
    for($i = 0; $i < count($ratings); $i++){
        if($ratings[$i]['id'] > $id)
            $id = $ratings[$i]['id'];
    }
    // foreach ($ratings as $i => $rating) {
    //     if ($rating['id'] > $id) {
    //         $id = $rating['id'];
    //     }
    // }

    $id = $id + 1;
    
    $data = [
        'id' => $id,
        'UX' => (int)$_GET['ux'],
        'Responsiveness' => (int)$_GET['responsiveness'],
        'Design' => (int)$_GET['design'],
        'average' => (float)$_GET['average']
    ];


    if($data['average'] < 1.5){
        $ratings[0]['star1'] = $ratings[0]['star1'] + 1; 
    }elseif($data['average'] < 2.5){
        $ratings[0]['star2'] = $ratings[0]['star2'] + 1; 
    }elseif($data['average'] < 3.5){
        $ratings[0]['star3'] = $ratings[0]['star3'] + 1; 
    }elseif($data['average'] < 4.5){
        $ratings[0]['star4'] = $ratings[0]['star4'] + 1; 
    }else{
        $ratings[0]['star5'] = $ratings[0]['star5'] + 1; 
    }
    
    $ratings[0]['avgStar'] = ( $ratings[0]['avgStar'] * $ratings[0]['count'] + $data['average'] ) / ( $ratings[0]['count'] + 1 );
    
    $ratings[0]['uxAvg'] = ( $ratings[0]['uxAvg'] * $ratings[0]['count'] + $data['UX'] ) / ( $ratings[0]['count'] + 1 );
    
    $ratings[0]['resposiveAvg'] = ( $ratings[0]['resposiveAvg'] * $ratings[0]['count'] + $data['Responsiveness'] ) / ( $ratings[0]['count'] + 1 );
    
    $ratings[0]['designAvg'] = ( $ratings[0]['designAvg'] * $ratings[0]['count'] + $data['Design'] ) / ( $ratings[0]['count'] + 1 );
    
    $ratings[0]['count'] = $ratings[0]['count'] + 1; 

    // $ratings[] = $data;
    array_push($ratings, $data);

    file_put_contents(__DIR__ . '/ratingData.json', json_encode($ratings, JSON_PRETTY_PRINT));

    return $data;
}

$message = newRating();
echo json_encode($message);
?>