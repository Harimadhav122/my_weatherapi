<?php 

include("./partials/header.php");

$weather="";

$error="";

if(array_key_exists("city",$_GET)) {
    
    $file_headers = @get_headers("http://api.apixu.com/v1/current.json?key=87adae526fa248809b361907191506&q=".urlencode($_GET['city'])."");
    
    if($file_headers[0] == 'HTTP/1.1 400 Bad Request') {
        
    $exists = false;
    
    $error="Could not found city - please try again.";
    
 }else {
        
   
   $urlContents=file_get_contents("http://api.apixu.com/v1/current.json?key=87adae526fa248809b361907191506&q=".urlencode($_GET['city'])."");
   
   $weatherArray=json_decode($urlContents, true);
   
   if($weatherArray['current']['condition']['code']) {
       
       $weather="The weather in ".$_GET['city']." is currently '".$weatherArray['current']['condition']['text']."'. ";
       
       $temp=intval(($weatherArray['current']['temp_c']));
       
       $weather.="The temperature is ".$temp."&deg;C and humidity is ".$weatherArray['current']['humidity']."% and the wind speed is ".$weatherArray['current']['wind_kph']."kph.";
       
   } else {
       
       $error="Could not found city - please try again.";
       
   }
   
 }
   
}

?>

<div class="container">
    <h1>What's the Weather?</h1>
    
    <form>
  <fieldset class="form-group">
    <label for="city"><h4>Enter the name of a city</h4></label>
    <input type="text" class="form-control mt-3 mb-4" name="city" id="city" placeholder="Eg.London,Tokyo" value="<?php echo $_GET['city']; ?>">
    </fieldset>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div id="weather">
    
    <?php
    
         if($weather) {
             
             echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
             
         } elseif($error) {
             
             echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
         }
    
    ?>
    
</div>
</div>    

<?php include("./partials/footer.php"); ?>
