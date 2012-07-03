package{
	
	import com.google.maps.Map;
	import com.google.maps.LatLng;
	import com.google.maps.MapEvent;
	import com.google.maps.MapMoveEvent;
	import com.google.maps.MapType;
	import com.google.maps.controls.*;
	import com.google.maps.overlays.*;
	import com.google.maps.InfoWindowOptions;
	import com.google.maps.MapMouseEvent;
	
	//import com.google.maps.*;
	import flash.display.MovieClip;
	import flash.geom.Point;
	
	import flash.display.MovieClip;
	import flash.display.StageAlign;
	import flash.display.StageScaleMode;
	//for full screening
	import flash.display.StageDisplayState;
	import flash.events.FullScreenEvent;
	
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	import flash.events.HTTPStatusEvent;
	import flash.events.MouseEvent;
		
	//import flash.net.URLLoader;
	//import flash.net.URLRequest;
	import flash.net.*;
	
	import flash.text.*;
	
	//http://code.google.com/intl/en/apis/maps/documentation/flash/reference.html
	//Use this to look up what imports you need and what methods you can use.

	public class myMap extends MovieClip{
		
		private var map:Map = new Map();
		//
		
		private var myXML:XML;
		private var url:URLRequest = new URLRequest("locations.xml");
		private var loader:URLLoader = new URLLoader();
		
		
		//var age:Number = 7;
		//var r:Recto = new Recto();
		
		public function myMap(){
			//builds the main timeline and our swf
			map.key = "ABQIAAAAzHvm_f23U5xKgbnXqpk2kxSgjUPgtM2EGxZnzVCDddbqes0bARQxSJ-s_PYAfWU4uVURf5gcNkMjwg";
			//map.setSize(new Point(stage.stageWidth, stage.stageHeight));
			map.setSize(new Point(700, 500));
			map.addEventListener(MapEvent.MAP_READY, onMapReady);
			//map.addEventListener(MapMoveEvent.MOVE_END, doneMoving);
			this.addChild(map);
			//map.width = 700;
		    //map.height = 500;
			
			/*mycircle_mc.x = 700;
			mycircle_mc.y = 200;
			mycircle_mc.alpha = 0.5;*/
			loader.addEventListener(Event.COMPLETE, LoadXML);
			
			
		}
		
		/*public function doneMoving(ev:MapMoveEvent):void{
			var c:MyCircle = new MyCircle();
			c.x = Math.random() * this.stage.stageWidth;
			c.y = Math.random() * this.stage.stageHeight;
			c.alpha = 0.8;
			c.scaleX = c.scaleY = Math.random() * 2;
			this.stage.addChild(c);
		}*/
		
		public function onMapReady(ev:MapEvent):void{
			map.setCenter(new LatLng(49.267805,-95.449219), 4, MapType.NORMAL_MAP_TYPE);
			
			/**
			CONTROLS
			PositionControl
			ZoomControl 
			MapTypeControl 
			ScaleControl
			OverviewMapControl 
			
			MAPTYPES
			HYBRID_MAP_TYPE
			NORMAL_MAP_TYPE
			PHYSICAL_MAP_TYPE
			SATELLITE_MAP_TYPE
			**/
			map.addControl(new ZoomControl());
			map.addControl(new PositionControl());
			map.addControl(new MapTypeControl());
			map.addControl(new ScaleControl());
			
			map.enableScrollWheelZoom();
			loader.load(url);


		}
		
		
		
		//var Lat = 
		//var Lng = 
		
		public function LoadXML(e:Event):void{
			//XML loaded
			myXML = XML(loader.data);
			var menuItems:XMLList = new XMLList( myXML.location);
			//loop through menuItems 
			//add a movieclip with a text field for EACH menu item
			//menuItems now has a length property that can be used to loop through the xml
			for(var x:uint=0; x<menuItems.length(); x++){
				//trace(x + " " +  menuItems[x].text() );
				addMyItem(menuItems[x], x);
				
			}	
			/**
			var myStr:String = "Bubba";
			addMyItem("Steve", 2);
			addMyItem(myStr, 0);
			addMyItem("Joanne", 3);
			**/
		}
		
		public function addMyItem(loc:XML, num:uint):void{
			//called each time we want to add a menu item to the page
			//lbl is the label for the menu item
			// num is the number of the menu item eg: 0, 1, 2, 3...
			//trace( myXML.item[num].text() + " " + lbl + " " + num);
			var m:Menu = new Menu();
			m.lat = loc.lat.text();
			m.lng = loc.long.text();
			
			var t:TextField = new TextField();
			
			m.infoHTML =loc.title.text()+ '<br/>' + loc.address.text()+ '<br/>' +loc.phone.text(); 
			
			t.mouseEnabled = false;
			m.addChild(t);	//put the TextField in the movieclip
			t.text = loc.title.text();
			t.width=m.width;
			t.y=15;
			var tf:TextFormat=new TextFormat();
			tf.align=TextFormatAlign.CENTER;
			t.setTextFormat(tf);
			m.buttonMode= true;
			m.useHandCursor = true;

			
			
			this.stage.addChild(m);		//put the movieclip on the stage
			// vertical menu X position stays the same
			// horizontal menu Y position stays the same
			var fixW:Number = 140;
			var xPos:Number = (fixW * num) + 75;
			//50, 150, 250, 350
			m.x = xPos;
			m.y = 510;
			//flip the m.x and m.y for a vertical menu
			m.addEventListener(MouseEvent.CLICK, uClickedItem);
			m.addEventListener(MouseEvent.MOUSE_OVER, hoverStyle);
			m.addEventListener(MouseEvent.MOUSE_OUT, removeHoverStyle);
			addMarker(m.lat, m.lng, m.infoHTML);
			
		}
		
		public function hoverStyle(e:MouseEvent):void
		{
		var m:MovieClip = MovieClip(e.target);
		m.gotoAndStop("animate");
		}
		public function removeHoverStyle(e:MouseEvent):void
		{
		var m:MovieClip = MovieClip(e.target);
		m.gotoAndStop(1);
		}
		
		public function uClickedItem(e:MouseEvent):void{
			
			map.panTo(new LatLng(e.target.lat, e.target.lng));
			map.setZoom(14);
			
			//trace();

		}	
		
		public function addMarker(lat:Number, lng:Number, info:String):void{
			
			var latlng:LatLng = new LatLng(lat, lng);
			var marker:Marker = new Marker(latlng);
			//marker.infoHTML = info;
			map.addOverlay(marker);
			var options:MarkerOptions = new MarkerOptions({  
										  strokeStyle: {
											color: 0x999999
										  },
										  fillStyle: {
											color: 0x002277,
											alpha: 0.8
										  },
										  label: "Loc",
										  labelFormat: {
											bold: true,
											color:0x000000
										  },
										  tooltip:"Click to view address",
										  radius: 12,
										  hasShadow: true,
										  clickable: true,
										  draggable: false,
										  gravity: 0.5,
										  distanceScaling: true
										});
			marker.setOptions(options);
			marker.addEventListener(MapMouseEvent.CLICK, function(e:MapMouseEvent):void{
							e.target.openInfoWindow( new InfoWindowOptions({ contentHTML: info	}));   
						});
		}
		
		public function infoBox(e:MapMouseEvent):void{
			e.target.openInfoWindow(
				 new InfoWindowOptions({ 
					height: 10,
					width: 10,
					contentHTML: e.target.infoHTML					
									   }));
			
			//setDefaultOptions(defaults:InfoWindowOptions): void{
		}
		
	}	
}

