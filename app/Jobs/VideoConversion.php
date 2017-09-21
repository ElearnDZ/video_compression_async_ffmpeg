<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use DB;
use Request;
//use Log;


class VideoConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $Video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($Video='')
    {
		$this -> Video = $Video;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		ini_set("max_execution_time",36000);
		///usr/bin/ffmpeg
		
		if(Request::ip()=='127.0.0.1' || Request::ip()=='::1'){
			$ffmpeg =  FFMpeg::create(array(
						    'ffmpeg.binaries'  => public_path().'/bin/ffmpeg.exe',
						    'ffprobe.binaries' => public_path().'/bin/ffprobe.exe',
							 'timeout'   => 36000,
							 'ffmpeg.threads'   => 12,
							));
			
		}else{
			$ffmpeg =  FFMpeg::create(array(
						    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
						    'ffprobe.binaries' => '/usr/bin/ffprobe',
							 'timeout'   => 36000,
							 'ffmpeg.threads'   => 12,
							));
			
		}
		//open video					
		$video = $ffmpeg->open( $this -> Video['source'] );
		if(Request::ip()=='127.0.0.1' || Request::ip()=='::1'){
			$ffprobe = \FFMpeg\FFProbe::create(array( 'ffprobe.binaries' => public_path().'/bin/ffprobe.exe'));
		}else{
			$ffprobe = \FFMpeg\FFProbe::create(array( 'ffprobe.binaries' => '/usr/bin/ffprobe'));	
			
		}
		
		$bit_rate = $ffprobe ->streams( $this -> Video['source'] ) -> videos() -> first() ->get('bit_rate');
		$bit_rate = ($bit_rate/1000);
		$bit_rate = round($bit_rate/2.4);
        $duration = $ffprobe ->streams( $this -> Video['source'] ) -> videos() -> first() ->get('duration');
        $duration = round($duration /4);
		// fetch pic from video
		//$video ->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10))->save($this -> Video['pic']);	
        $i=1;
        $duration_new = $duration;
        while($i<4){
            $video ->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($duration_new))->save($this -> Video['pic'].'_'.$i.'.jpg');       
            $i++;
            $duration_new =  $duration_new + $duration;
        }
		
		// define audio available driver
		$format = new X264( 'libmp3lame');
		/*$format->on('progress', function ($video, $format, $percentage) {
			// $percentage==100 then update 
			//echo "$percentage % transcoded.'<br>'";
			//Log::info('This is some useful information.'.$percentage);
			if(trim($percentage)==100 || trim($percentage)==99){
				@unlink($this -> Video['source']);
			}
		});*/
		if($bit_rate=='' || $bit_rate<1){
			$bit_rate = 100;	
		}
		//$format	->setKiloBitrate($bit_rate)	->setAudioChannels(2)->setAudioKiloBitrate(128);
		//$video->save($format, $this -> Video['destination']);
		
		//720,1280
		$format	->setKiloBitrate(round($bit_rate))	->setAudioChannels(2)->setAudioKiloBitrate(128);
		$seven_twenty = new Dimension(1280, 720);
		$video->filters()->resize($seven_twenty)->synchronize();
		$video->save($format, $this -> Video['destination'].'-720-1280.mp4');

		//480,854
		$format	->setKiloBitrate(round($bit_rate))	->setAudioChannels(2)->setAudioKiloBitrate(128);
		$four_eighty = new Dimension(854, 480);
		$video->filters()->resize($four_eighty)->synchronize();
		$video->save($format, $this -> Video['destination'].'-480-854.mp4');

		//360,640
		/*$format->on('progress', function ($video, $format, $percentage) {
			 //$percentage==100 then update 
			//echo "$percentage % transcoded.'<br>'";
			//Log::info('This is some useful information.'.$percentage);
			if(trim($percentage)==100 || trim($percentage)==99){
				@unlink($this -> Video['source']);
				DB::update('update videos set status ="Play" where id = ?', [$this -> Video['id']]);
			}
		});	*/	
		$format	->setKiloBitrate(round($bit_rate)) -> setAudioChannels(2) -> setAudioKiloBitrate(128);
		$three_sixty = new Dimension(640, 360);
		$video->filters()->resize($three_sixty)->synchronize();
		$video->save($format, $this -> Video['destination'].'-360-640.mp4');

		//240,426
		$format	->setKiloBitrate(round($bit_rate)) -> setAudioChannels(2) -> setAudioKiloBitrate(128);
		$two_fourty = new Dimension(426, 240);
		$video->filters()->resize($two_fourty)->synchronize();
		$video->save($format, $this -> Video['destination'].'-240-426.mp4');

		//144,256
		$format->on('progress', function ($video, $format, $percentage) {
			// $percentage==100 then update 
			//echo "$percentage % transcoded.'<br>'";
			//Log::info('This is some useful information.'.$percentage);
			if(trim($percentage)==100 || trim($percentage)==99){
				@unlink($this -> Video['source']);
				DB::update('update videos set status ="Play" where id = ?', [$this -> Video['id']]);
			}
		});
		
		$format	->setKiloBitrate(round($bit_rate)) -> setAudioChannels(2) -> setAudioKiloBitrate(128);
		$one_fourty_four = new Dimension(256, 144);
		$video->filters()->resize($one_fourty_four)->synchronize();
		$video->save($format, $this -> Video['destination'].'-144-256.mp4');
	
    }
    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }	
	

	
}
