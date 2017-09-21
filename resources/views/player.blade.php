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
                <a href="/">Back</a>
                <?php 
				

				$videos = DB::table("videos") -> where ("id",$id) ->  get();
				?>
   
                      	
                         <div id="warmup_video"></div>
                        <script>

					
					function play_a_video(){
						var playerInstance = jwplayer("warmup_video");
					// jwplayer('warmup_video').setup({
							playerInstance.setup({
								
									 //'html5player': '/Scripts/JWPlayer/jwplayer.html5.js',
							  		//'flashplayer': '/Scripts/JWPlayer/jwplayer.flash.swf',
									 //file:"vid/videoplayback2.mp4",
									 //file:blob_url,
								 		//type: "mp4",
									  //height: 435,
									  width: "50%",
									  aspectratio: "16:9",
									  autostart:false,
									  primary: "flash",
										stagevideo: false,
									    playbackRateControls: [0.75, 1, 1.25, 1.5],
									playlist:[{	
										sources: [{
												file: "{{ url('/videos/') }}/<?php echo  $videos[0]->id;?>/<?php echo  $videos[0]->name;?>-720-1280.mp4",
												label: "720p HD",
												"default": "true",
												type: "mp4",
											  },{
												file:"{{ url('/videos/') }}/<?php echo  $videos[0]->id;?>/<?php echo  $videos[0]->name;?>-480-854.mp4",  
												label: "480p SD",
												type: "mp4",
											  },{
												file:"{{ url('/videos/') }}/<?php echo  $videos[0]->id;?>/<?php echo  $videos[0]->name;?>-360-640.mp4",    
												label: "360p web",
												type: "mp4",
											  },{
												file:"{{ url('/videos/') }}/<?php echo  $videos[0]->id;?>/<?php echo  $videos[0]->name;?>-240-426.mp4",  
												label: "240p web",
												type: "mp4",
											  },{
												file:"{{ url('/videos/') }}/<?php echo  $videos[0]->id;?>/<?php echo  $videos[0]->name;?>-144-256.mp4",    
												label: "144p web",
												type: "mp4",
											  }
											  ]	
										  }],
											
							
					  });						
					}
					play_a_video();

					  </script>
						<style>
.jw-skin-stormtrooper .jw-display-icon-container {
border-radius: .5em !important;
position: relative !important;
z-index: -1 !important;
}
.jw-display-icon-container {
   pointer-events: all !important;
 }	
/* .jw-flag-audio-player.jw-flag-small-player .jw-text-duration, .jw-flag-audio-player.jw-flag-small-player .jw-text-elapsed, .jw-hidden {
display: block;
}*/
/* .jw-flag-audio-player.jw-flag-small-player .jw-text-duration, .jw-flag-audio-player.jw-flag-small-player .jw-text-elapsed, .jw-hidden {
display: block;
}*/
 			
				</style>
                        
                </div>
                

             </div>
        </div>
    </body>
</html>
