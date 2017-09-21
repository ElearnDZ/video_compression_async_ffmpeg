<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script type='text/javascript' src='https://content.jwplatform.com/libraries/6LUuBf8g.js'></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif                
        <form action="/video" method="post" enctype="multipart/form-data">

 <table class="table table-bordered">    
{{ csrf_field() }}
 <tr>       
<td>
<input type="file" name="video_name" id="video_name">
</td>
<td>
<input type="submit" value="Upload">
</td>
</tr>


</table>
</form>        
                <?php 
				$videos = DB::table("videos") -> get();
				?>
   <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
         <th>View</th>
      </tr>
    </thead>
    <tbody>
    <?php
    foreach($videos as $vid){
	?>
      <tr>
        <td><?php echo  $vid->id;?></td>
        <td><?php echo  $vid->name;?></td>
        <td><?php echo  $vid->status;?></td>
         <td>
         <?php if($vid->status=='Play'){?>
         <a href="{{ url('/play/') }}/<?php echo  $vid->id;?>">Play
         <img src="{{ url('videos/') }}/<?php echo  $vid->id;?>/<?php echo  $vid->pic;?>_1.jpg" width="50" height="50">
         <?php }else{ echo "Processing";}?>
         </td>
      </tr>
      <?php 
	}
	  ?>
       
    </tbody>
  </table>
                          
                </div>
                

             </div>
        </div>
    </body>
</html>
