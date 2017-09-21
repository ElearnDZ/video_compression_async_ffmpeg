<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Jobs\VideoConversion;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use GuzzleHttp\Client;
use DB;
use Request;
class VideoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		 $this->middleware('guest')->except('logout');
    }
	public function index(){
		
		ini_set("post_max_size","1024M");
		ini_set("upload_max_filesize","1024M");
		$name = str_replace(" ","_",$_FILES['video_name']['name']);
		$nextId = DB::table('videos')->max('id') + 1;
		if(!file_exists(public_path()."/videos/".$nextId."/")){
		 	 mkdir(public_path()."/videos/".$nextId."/",0777);	
		}
		copy($_FILES['video_name']['tmp_name'],public_path()."/videos/".$nextId."/".$name);
		$path_parts = pathinfo(public_path()."/videos/".$name);
		$destination = $path_parts['filename'];
		
		$Video = array(
						"source"=>public_path().'/videos/'.$nextId.'/'.$name,
						"destination"=>public_path().'/videos/'.$nextId.'/'.$destination,
						"pic"=>public_path().'/videos/'.$nextId.'/'.$destination,
						"id"=>$nextId
					);
		DB::table('videos')->insert(
			['name' => $destination, 'status' => 'processing','pic'=>$destination,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
		);					
				
		$job = (new VideoConversion($Video))
				->onConnection('async') 
				->onQueue('processing');;
        dispatch($job);		
	    return redirect('/')->with('status', 'Video Compression and conversion is in processing!');
		//echo "job is done";
		

	}
	
	public function readvideo($id,$id1){
		
	
		ini_set('memory_limit', '1024M');
		if($id==1){
			 $file = public_path()."/vid/videoplayback.mp4";
		}else{
		 $file = public_path()."/vid/out-144-100.mp4";
		}
		
		  $file_size = filesize($file);
		  $file_pointer = fopen($file, "rb");
		  $data = fread($file_pointer, $file_size);
		  if($id1>0){
		  	header("Content-type: video/mp4");
		  }
		 
		  echo $data;
		
	}
	
	public function play($id){
		 return view('player',array("id"=>$id));
		
		
	}

}
