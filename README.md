# Video Compression And Conversion Asynchronous ffmpeg Laravel 5.4

This artical will help you to compress videos and convert into mp4 format and reduce its size keeping the video quality same. This will return the following dimensions of videos
````
- 720,1280
- 480,854
- 360,640
- 240,426
- 144,256
````
you can make your own custom size to convert videos according to your requirement. for define your own custom size please add your dimension here app/jobs/VideoConversion.php
This will not slow down your website speed the compression process will run automatcially and once it is finished it will upload videos to desired directory.

# Requirements
- PHP 7.0 or above.
- Curl library installed.
- Composer Installed

# Implementation
````
- Clone the code from  the given repository
- Configure it in your localhost server i.e xampp,appache etc
- Create a database name "homestead"
- Run php artisan migrate in composer
- now run the cloned directory in browser i.e http://localhost/video_compression_async_ffmpeg
- upload your desired video
- compression process will start
````
once the compression process is complete you will find the compressed video with play button with jwplayer with all above mentioned video dimensions.


# Linux
````
- For Linux and other platform you need to install ffmpeg and set its path in app/jobs/VideoConversion.php 
````
# OS
````
- ffmpeg-3.3.3-win64-static.zip search and downlaod
- OR
- Downlaod from (version 3.3.3) https://ffmpeg.zeranoe.com/builds/
- Place ffmpeg.exe,ffplay.exe,ffprobe.exe files in public/bin/

````
#Downlaod ffmpeg 
````
- https://www.ffmpeg.org/download.html
- version 3.3.3

````