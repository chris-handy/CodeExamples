package{
	
	import flash.display.MovieClip;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	
	import flash.events.HTTPStatusEvent;		//HTTP Status codes - 404, 200, etc
	import flash.events.ProgressEvent;			//measure the progress of the download
	import flash.events.IOErrorEvent;			//fail to load file, can't play the mp3
	 
	import flash.net.*;		//URLRequest, URLLoader
	
	import flash.media.Sound;							//the sound object
	import flash.media.SoundChannel;			//a channel for each sound .play(), leftPeak, rightPeak, soundTransform
	import flash.media.SoundMixer;				//get the data about the sound
	import flash.media.SoundTransform;		//volume and panning
	
	import flash.geom.*;
	
	import flash.utils.*;
	import flash.events.TimerEvent;
	
	
	public class MusicPlayer extends MovieClip{
		
		private var songReq:URLRequest;
		private var loader:URLLoader = new URLLoader();
		private var songXML:XML;
		private var songPath:String = "./music/";	//the path to my mp3 files
		private var currentTrack:Number = 0;
		var numSongs:Number;
		private var vol:Number = 0.50;	//just like alpha and scale  0 - 1
		private var sound:Sound;
		private var soundChan:SoundChannel = new SoundChannel();	//max 32 channels
		private var songURL:URLRequest;
		private var isPlaying:Boolean = false;
		private var theTimer:Timer = new Timer(20);	
		private var ple:PlayListEntry;
		private var pausePosition:int = 0;
		private var isMuted:Boolean=false;
		private var volTimer:Timer = new Timer(50);
		private var currentTrackLength:String;
		private var currentTrackMilliSeconds:Number;
		
		
		
		public function MusicPlayer(){
			//constructor function for the timeline/stage
			//go fetch the xml playlist before we can really do anything
			songReq = new URLRequest("songlist.xml");
			loader.addEventListener(Event.COMPLETE, xmlBack);
			loader.load(songReq);
			//add the event handlers to various elements on the stage.
			//control buttons
			stopBtn.addEventListener(MouseEvent.MOUSE_DOWN, stopSound);
			stopBtn.addEventListener(MouseEvent.MOUSE_OVER, showCursor);
			playBtn.addEventListener(MouseEvent.CLICK, playSong);
			playBtn.addEventListener(MouseEvent.MOUSE_OVER, showCursor);
			nextBtn.addEventListener(MouseEvent.MOUSE_DOWN, nextSong);
			nextBtn.addEventListener(MouseEvent.MOUSE_OVER, showCursor);
			prevBtn.addEventListener(MouseEvent.MOUSE_DOWN, prevSong);
			prevBtn.addEventListener(MouseEvent.MOUSE_OVER, showCursor);
			muteBtn.addEventListener(MouseEvent.CLICK, muteSound);
			muteBtn.addEventListener(MouseEvent.MOUSE_OVER, showCursor);
			//volume controls
			volControl.volGrabBar.addEventListener(MouseEvent.MOUSE_DOWN, moveVolSlider);
			volControl.addEventListener(MouseEvent.MOUSE_DOWN, clickMoveVolSlider);
			volControl.volGrabBar.addEventListener(MouseEvent.MOUSE_UP, noMoveVolSlider);
			stage.addEventListener(MouseEvent.MOUSE_UP, noMoveVolSlider);
			volControl.addEventListener(MouseEvent.MOUSE_OVER, showGrabBar);
			volControl.addEventListener(MouseEvent.MOUSE_OUT, hideGrabBar);
			//seekbar controls
			seekBar.grabBar.addEventListener(MouseEvent.MOUSE_DOWN, startTrackingPosition);
			seekBar.grabBar.addEventListener(MouseEvent.MOUSE_UP, stopTrackingPosition);
			stage.addEventListener(MouseEvent.MOUSE_UP, stopTrackingPositionStage);
			
			volControl.volGrabBar.visible=false;
			//to simulate mouse release outside
			seekBar.grabBar.useHandCursor = true;
			seekBar.grabBar.buttonMode = true;
			//get the hand instead of the arrow when you are ontop of the grabbar
			volTimer.addEventListener(TimerEvent.TIMER, updateVolBar);
			theTimer.addEventListener(TimerEvent.TIMER, moveGrabBar);
			volTimer.start();
		}
		
/***********************************************************
	
							XML/LOADING THE SONG

************************************************************/

		public function xmlBack(ev:Event):void
		{
			trace(loader.data);	//loading the data	//put the data from the URLLoader into our XML variable
			songXML = new XML(ev.target.data);	//storing the data in a variable
			numSongs = songXML.song.length();	//getting the length of the <songs>tags in the xml
			var songName:String = songXML.song[currentTrack].track.text();	//putting the file name into it's own variable to be loaded in a method
			//songXML.song[currentTrack].artist.text() would be the name of the artist from the XML
			loadSong(songName);
			
			for(var i=0; i<numSongs; i++)
			{	//adding the playlist things based on the length of the numSongs variable
				//first PlayListEntry object should be at (205, 54)
				ple = new PlayListEntry();
				ple.x = 54;
				ple.y = (25.70 * i) + 205;
				ple.mouseChildren = false;	//ignore clicking on the text field
				ple.buttonMode = true;
				ple.hasMouseCursor = true;
				ple.trackName.text = songXML.song[i].songName.text() + ' by ' + songXML.song[i].artist.text() ;	//same as label
				ple.trackNum = i;	//save the track number as a reference for the xml. same as data
				addChild(ple);
				ple.addEventListener(MouseEvent.CLICK, pickSongClick);
			}
		}
		
		public function pickSongClick(ev:MouseEvent):void
		{	//add the method to change songs based on what song the user clicks on in the playlist
			soundChan.stop();
			currentTrack = MovieClip(ev.target).trackNum;
			var songName:String = songXML.song[currentTrack].track.text();
			//get the number from the list...go to the XML and get the track
			trace("click " + songName);
			loadSong(songName);
		}
		
		public function loadSong(song:String):void
		{		//our method to load the song
			song = songPath + song;		//add the path to the name of the song ('song' is the string from the songName property which is the name for the mp3)
			sound = new Sound();		//putting the Sound(); method into a property;
			sound.load(new URLRequest(song));	//loading the song into the sound Method
			sound.addEventListener(ProgressEvent.PROGRESS, trackSongLoad);		//progress and io error occur on the sound object
			sound.addEventListener(IOErrorEvent.IO_ERROR, errorHandler);
			soundChan = sound.play(0);		//play the song
			currentTrackLength = songXML.song[currentTrack].length.text();
			var parts:Array = currentTrackLength.split(":");
			currentTrackMilliSeconds = ((parseInt(parts[0]) * 60 ) + parseInt(parts[1])) * 1000;
			trace( currentTrackMilliSeconds );
			soundChan.soundTransform = new SoundTransform(vol);		//adjust the volume of the song when it's being loaded
			trkTitle_txt.text = songXML.song[currentTrack].songName.text();		//put the name of the artist on the stage...
			soundChan.addEventListener(Event.SOUND_COMPLETE, songDonePlaying);		//sound complete occurs on the sound channel
			this.addEventListener(Event.ENTER_FRAME, trackSongPlaying);		//we will start the music playing automatically as we have no buttons on the stage.
			isPlaying=true;
			playBtn.gotoAndStop("pause");
			
		}
		
		public function errorHandler(ev:IOErrorEvent):void 
		{	//if there is an error playing the song, this method will run.
            trace("The sound could not be loaded: " + ev.text);
        }
		
		public function trackSongLoad(ev:ProgressEvent):void
		{		//call this as the progress of the song load occurs
			//trace(ev.bytesLoaded, ev.bytesTotal);
			var pctLoad:Number = ev.bytesLoaded / ev.bytesTotal;
			seekBar.loadBar.scaleX = pctLoad;	//change the loadBar scaling
			if( pctLoad > .99){
				removeEventListener(ProgressEvent.PROGRESS, trackSongLoad);
			}
			
		}
		
/***********************************************

				BUTTON METHODS
				
******************************************************/

		public function stopSound(ev:MouseEvent):void
		{		//method for the stop button
				trace("stopping the song");
				soundChan.stop();
				pausePosition = 0;	
				isPlaying = false;
				this.removeEventListener(Event.ENTER_FRAME, trackSongPlaying);	//
				seekBar.grabBar.x = 0;		//setting the seekBar grabBar to the beginning
				playBtn.gotoAndStop("play");	
				
				totalTime.text = "00:00";
				currentTime.text = "00:00";
		}
		
		
		public function playSong(ev:MouseEvent):void
		{		//method for the Play button
			if(isPlaying)	//adding a conditional to see if the song is playing or not and switching the button 
			{
				trace("pausing the song");
				pausePosition = soundChan.position;		//setting the position in the song to that point where the user clicked pause
				soundChan.stop();
				playBtn.gotoAndStop("play");
				isPlaying = false;
			}else{
				trace("playing");
				soundChan = sound.play(pausePosition);	//when the user clicks play again, the song plays from the point where the user clicked pause
				playBtn.gotoAndStop("pause");
				soundChan.soundTransform = new SoundTransform(vol);
				isPlaying = true;
			}
			
		}
		
		public function muteSound(ev:MouseEvent):void
		{		//method for the mute button
			if(isMuted)		//adding the conditional to see if the sound is muted or not
			{	
				isMuted = false;
				trace("sound on");
				soundChan.soundTransform = new SoundTransform(vol);	//setting the volume to the original volume declared in the global property
				muteBtn.gotoAndStop("soundOn");
				//volTimer.addEventListener(TimerEvent.TIMER, updateVolBar);
			}else{
				isMuted = true;
				trace("muting the sound");
				//volTimer.removeEventListener(TimerEvent.TIMER, updateVolBar);
				soundChan.soundTransform = new SoundTransform(0);	//setting the volume to 0
				muteBtn.gotoAndStop("soundOff");				
			}
		}
				
		public function nextSong(ev:MouseEvent):void
		{		//method for the next song
			currentTrack++;		//go to the next track as defined in the currentTrack property
			if(currentTrack >= numSongs){	//conditional to test if the currentTrack is greater than the length of the number of songs
				currentTrack = 0;
			}
			//trace( "\t" + "Next track: " + songReq[currentTrack] );			
			if( isPlaying ){		//if the song isPlaying, then stop the current sound, make it so it isn't playing then call the loadSong method
				soundChan.stop();
				try{
					sound.close();	//THIS KILLS THE DOWNLOAD TOO
				}catch(e:Error){
					//could not find the stream or was working on localfilesystem
					trace(e.message);
				}
				isPlaying = false;
				
			}
			loadSong(songXML.song[currentTrack].track.text());//loading the next song as per currentTrack++
		}
		
		public function prevSong(ev:MouseEvent):void
		{		//method for the previous song
			numSongs = songXML.song.length();	//putting the number of <song> tags in a variable
			currentTrack--;			//going back a song
			if(currentTrack < 0){	//conditional to test if the currentTrack is less than the length of the number of songs
				currentTrack = numSongs-1;
			}
			//trace( "\t" + "Next track: " + songReq[currentTrack] );
			if( isPlaying ){		//if the song isPlaying, then stop the current sound, make it so it isn't playing then call the loadSong method
				soundChan.stop();
				isPlaying = false;
			}
			loadSong(songXML.song[currentTrack].track.text());		//loading the next song as per currentTrack++
		}
	
/*****************************************************

					TRACKING SONG PLAYING/SEEKBAR
	
*********************************************************/
		
		
		public function trackSongPlaying(ev:Event):void
		{		//keep track of where the grabBar should be (unless the user is moving it)
			//trace( sound.length, soundChan.position);
			
			if(sound.length > 0 && isPlaying ){		//a conditional to set the seekBar.grabBar based on how much of the song is loaded
				//just in case we don't have a length for the song yet
				var pct:Number = soundChan.position / currentTrackMilliSeconds;		//get the length of how much of the song has been loaded based on the 'position' of the time in the song based on the total length
				var totalWidth:Number = (seekBar.loadBar.width - seekBar.grabBar.width);	//length of the seekBar
				seekBar.grabBar.x = totalWidth * pct;	//tracking the x of the seekBar.grabBar based on the song streaming
			}
			
			if(isPlaying && soundChan.position >=0)
			{	//conditional to add the time played and total time of the songs to the text fields on the stage
				var pctPlayed:Number = soundChan.position / sound.length;	//the percent of the song that's played already				
				var seconds:Number = Math.floor(soundChan.position/1000);	//divide the milliseconds by 1000 to get the number of seconds				
				var minutes:Number = Math.floor(seconds/60);	//diving the seconds by 60 to get the minutes
				var ttlSecs:Number = Math.floor(sound.length/1000);		//getting the total number of seconds by dividing the length of the song by 1000
				var ttlMins:Number = Math.floor(ttlSecs/60);		//getting the total number of minutes by dividing the length of the song by 1000
				//use Math.floor to get rid of the decimal places
				//getting the properties of the current time being played of the songs
				seconds = seconds - (60 * minutes);	//remove the extra seconds. EG: show 1:30 instead of 90
				var strSeconds:String;	
				if(seconds <10)
				{	//conditional to output the seconds as a legible and neat string
					strSeconds = "0" + seconds.toString();	//add the zero in the front of the number IF it is less than ten
				}else{
					strSeconds = seconds.toString();
				}
				
				var strMinutes:String;
				if(minutes <10)
				{	//conditional to output the minutes as a legible and neat string
					strMinutes = "0" + minutes.toString();	//add the zero in the front of the number IF it is less than ten
				}else{
					strMinutes = minutes.toString();
				}
				
				//getting the properties of the total time of the song
				ttlSecs = ttlSecs - (60 * ttlMins); //remove the extra seconds. EG: show 1:30 instead of 90
				var strSecondsTotal:String;
				if(ttlSecs <10)
				{ 	//conditional to output the seconds as a legible and neat string
					strSecondsTotal = "0" + ttlSecs.toString();	//add the zero in the front of the number IF it is less than ten
				}else{
					strSecondsTotal = ttlSecs.toString();
				}
				
				var strMinutesTotal:String;
				if(ttlMins<10)
				{		//conditional to output the minutes as a legible and neat string
					strMinutesTotal = "0" + ttlMins.toString();		//add the zero in the front of the number IF it is less than ten
				}else{
					strMinutesTotal = ttlMins.toString();
				}
				
				//putting the total and current times' properties into there own properties as strings
				var currentTimeString:String = strMinutes + ":" + strSeconds;
				var totalTimeString:String = strMinutesTotal + ":" + strSecondsTotal;
				
				//putting the concatenated properties into the text fields
				totalTime.text = totalTimeString;
				currentTime.text = currentTimeString;
			}
		}
		
		public function songDonePlaying(ev:Event):void
		{		//method for going to the next song after the song is done playing
			currentTrack++;	//finished playing the current track so go to the next
			if(currentTrack >= songXML.song.length())
			{
				currentTrack = 0;	//loop back to the beginning of the playList
			}
			var songName:String = songXML.song[currentTrack].track.text();
			//songXML.song[currentTrack].artist.text() would be the name of the artist from the XML
			loadSong(songName);
		}
		
		public function startTrackingPosition(ev:MouseEvent):void
		{			//method that is run when the user clicks on the seekBar.grabBar to drag it
			this.removeEventListener(Event.ENTER_FRAME, trackSongPlaying);	//stop the automatic moving of the grabBar
			var bounds:Rectangle = new Rectangle(0, 0, (seekBar.loadBar.width-seekBar.grabBar.width), 0);	//putting a bounding box around the width of the seekBar so the user can't go beyond it
			seekBar.grabBar.startDrag(0, bounds);	//this lets us move the drag bar
			theTimer.start();	//now we need to keep checking the position of the grabBar so we can change the position in the song
			soundChan.removeEventListener(Event.SOUND_COMPLETE, songDonePlaying);
		}
		
		public function moveGrabBar(ev:TimerEvent):void
		{		//the method to track where the song is once the user clicks on the grabBar
			//This function will run every 20 milliseconds (5 times per second)
			var xpos:Number = seekBar.grabBar.x;	//the x position of the grabBar
			//trace(xpos);
			var pct:Number = xpos / (seekBar.loadBar.width-seekBar.grabBar.width);
			var time:Number = pct * sound.length;
			//sc.position = time;	//position is READONLY so we can't change it this way
			soundChan.stop();
			soundChan = sound.play(time);
		}
		
		public function stopTrackingPositionStage(ev:MouseEvent):void
		{		//method that continues to play the song when the grabBar is stopped dragging on the Stage
			theTimer.stop();
			seekBar.grabBar.stopDrag();
			//when done, start moving the grabBar again
			this.addEventListener(Event.ENTER_FRAME, trackSongPlaying);
			soundChan.addEventListener(Event.SOUND_COMPLETE, songDonePlaying);
		}
		
		public function stopTrackingPosition(ev:MouseEvent):void
		{	//method that continues to play the song when the grabBar is stopped dragging
			theTimer.stop();
			seekBar.grabBar.stopDrag();
			//when done, start moving the grabBar again
			this.addEventListener(Event.ENTER_FRAME, trackSongPlaying);
			soundChan.addEventListener(Event.SOUND_COMPLETE, songDonePlaying);
		}

/*******************************************************

						VOLUME CONTROLS
						
*******************************************************/

		public function moveVolSlider(ev:MouseEvent):void
		{		//method that allows the volume slider to drag within the bounding box to set the volume
				var v:MovieClip = MovieClip(ev.target);		//the movie clip that was clicked on
				var sliderBounds:Rectangle = new Rectangle(0, 0, 230.95 , 0  );		//the bounding box to set the volume
				v.startDrag(false, sliderBounds);
				v.addEventListener(MouseEvent.MOUSE_MOVE, setVolume);
		}
		
		public function noMoveVolSlider(ev:MouseEvent):void
		{		//method that stops dragging once the volume slider is let go
			if( isPlaying ){
				//var v:MovieClip = MovieClip(ev.target);
				vol = -1 * (volControl.volGrabBar.x / 230.95);		//calculate the volume based on the width of the volControl
				soundChan.soundTransform = new SoundTransform(vol);
			}
			volControl.volGrabBar.removeEventListener(MouseEvent.MOUSE_MOVE, setVolume);
			volControl.volGrabBar.stopDrag();
			
		}
		
		public function setVolume(ev:MouseEvent):void
		{		//method to set the volume
			if( isPlaying){
				var v:MovieClip = MovieClip(ev.target);
				vol = -1 * (v.x / 230.95);		//calculate the volume based on the width of the seekBar
				soundChan.soundTransform = new SoundTransform(vol);
				//sc.soundTransform.volume = vol;
			}
		}
		
		public function clickMoveVolSlider(ev:MouseEvent):void
		{		//method to move the slider by clicking, and setting the volume as well
			volControl.volGrabBar.x = ev.localX;
			vol = -1 * (ev.localX / 230.95);	//calculate the volume based on the width of the seekBar
			soundChan.soundTransform = new SoundTransform(vol);
			var sliderBounds:Rectangle = new Rectangle(0, 0, 230.95, 0);
			volControl.volGrabBar.startDrag(false, sliderBounds);
			volControl.volGrabBar.addEventListener(MouseEvent.MOUSE_MOVE, setVolume);
		}
		
		public function showGrabBar(ev:MouseEvent):void
		{		//method to show the grabBar when the user hovers over the slider
			volControl.volGrabBar.visible=true;
		}
		
		public function hideGrabBar(ev:MouseEvent):void
		{		//method to hide the grabBar when the user hovers off the slider
			volControl.volGrabBar.visible=false;
		}
		
		public function updateVolBar(ev:TimerEvent):void
		{
			if(!isMuted)
			{
				vol = -1 * (volControl.volGrabBar.x / 230.95);		//calculate the volume based on the width of the volControl
				soundChan.soundTransform = new SoundTransform(vol);
				volControl.slider.width  = volControl.volGrabBar.x;
				volTimer.addEventListener(TimerEvent.TIMER, updateVolBar);
			}else{
				soundChan.soundTransform = new SoundTransform(0);
				volControl.slider.width  = volControl.volGrabBar.x;
				volControl.volGrabBar.removeEventListener(MouseEvent.MOUSE_MOVE, setVolume);
			}
			
		}
/**************************************************

					HOVER/ASTHETIC CONTROLS
					
******************************************************/
			
		public function showCursor(ev:MouseEvent):void
		{
			var v:MovieClip = MovieClip(ev.target);
			v.buttonMode = true;
			v.hasMouseCursor = true;
		}
	}
}