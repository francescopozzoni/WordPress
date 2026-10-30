<html>
	<head>
		<title>Easter egg</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<style>
				@import url('https://fonts.googleapis.com/css2?family=Rubik:wght@600&display=swap');
			
				#canvas {
						display: inline;
						overflow-y: hidden;
						overflow-x: hidden;
						width: 100%;
						margin: 0;
						z-index: 200;
				}

				.center {
						display: inline;
						position: absolute;
						top: 50%;
						left: 50%;
						transform: translate(-50%, -50%);
				}
				h1 {
					font-family: 'Rubik', sans-serif;
						color: #004077;
						text-align: center;
				}
				h3 {
					font-family: 'Rubik', sans-serif;
						color: #004077;
						text-align: center;
				}
			#da-mostrare-1 {
				display: none;
			}
			#da-mostrare-2 {
				display: none;
			}
			#da-mostrare-3 {
				display: none;
				text-align: center;
			}
			#da-nascondere {
				display: inline;
			}
			#stage {
  				border: 2px solid #004077;
				margin-left:auto;
				margin-right: auto;
			}
			
			#da-mostrare-1, #cred, #da-mostrare-3, #stage {
				max-width: 100%;
			}
			

		</style>
		<div id="da-nascondere">
			<input type="button" class="center" value="Visto che sei arrivato fino a qui che ne dici di cliccarmi?" onclick="alert('Oh no!'); alert('In quale parte dell\'internet sei finito?'); alert('Ovviamente nella parte con i crediti per il sito...'); play(); Draw();">
		</div>
		<audio id="music">
		<source src="kazoo.mp3" type="audio/mpeg">
			C'era anche un bell'audio di sottofondo ma il tuo browser non lo supporta :(.
		</audio>
		<script>
			var myMusic= document.getElementById("music");
				function play() {
					myMusic.play();
				}
		</script>
	
		<div id="da-mostrare-1">
			<h1 class="center">Big credits to...<br><br><br><div id="da-mostrare-2"><img id="cred" src="./pozzo-michi.svg"></div></h1>
		</div>
		<div id="da-mostrare-3" class="center">
			<h3>E ora come in tutti gli easter egg che si rispettino ecco un piccolo ingame, se sei su un cellulare mi dispiace per te :(</h3>
			<canvas id="stage" height="400" width="520"></canvas>
		</div>
		<canvas id="canvas" style="background: transparent;"></canvas>
		<script>
				let W = window.innerWidth;
				let H = window.innerHeight;
				const canvas = document.getElementById("canvas");
				const context = canvas.getContext("2d");
				const maxConfettis = 150;
				const particles = [];

				const possibleColors = [
				"DodgerBlue",
				"OliveDrab",
				"Gold",
				"Pink",
				"SlateBlue",
				"LightBlue",
				"Gold",
				"Violet",
				"PaleGreen",
				"SteelBlue",
				"SandyBrown",
				"Chocolate",
				"Crimson"
				];

				function randomFromTo(from, to) {
				return Math.floor(Math.random() * (to - from + 1) + from);
				}

				function confettiParticle() {
				this.x = Math.random() * W; // x
				this.y = Math.random() * H - H; // y
				this.r = randomFromTo(11, 33); // radius
				this.d = Math.random() * maxConfettis + 11;
				this.color =
						possibleColors[Math.floor(Math.random() * possibleColors.length)];
				this.tilt = Math.floor(Math.random() * 33) - 11;
				this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
				this.tiltAngle = 0;

				this.draw = function() {
						context.beginPath();
						context.lineWidth = this.r / 2;
						context.strokeStyle = this.color;
						context.moveTo(this.x + this.tilt + this.r / 3, this.y);
						context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
						return context.stroke();
				};
				}
			
			
			Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}


				function Draw() {
				setTimeout(function(){ document.getElementById("da-mostrare-1").style.display = "inline"; }, 10000);
				setTimeout(function(){ document.getElementById("da-mostrare-2").style.display = "inline"; }, 17000);
				setTimeout(function(){ document.getElementById("da-mostrare-3").style.display = "inline"; }, 25000);
				setTimeout(function(){ document.getElementById("da-mostrare-1").remove()}, 25000);
				setTimeout(function(){ document.getElementById("da-mostrare-2").remove()}, 25000);
				setTimeout(function(){ document.getElementById("canvas").remove() }, 25000);
				document.getElementById("da-nascondere").style.display = "none";
					
				const results = [];

				// Magical recursive functional love
				requestAnimationFrame(Draw);

				context.clearRect(0, 0, W, window.innerHeight);

				for (var i = 0; i < maxConfettis; i++) {
						results.push(particles[i].draw());
				}

				let particle = {};
				let remainingFlakes = 0;
				for (var i = 0; i < maxConfettis; i++) {
						particle = particles[i];

						particle.tiltAngle += particle.tiltAngleIncremental;
						particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
						particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

						if (particle.y <= H) remainingFlakes++;

						// If a confetti has fluttered out of view,
						// bring it back to above the viewport and let if re-fall.
						if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
						particle.x = Math.random() * W;
						particle.y = -30;
						particle.tilt = Math.floor(Math.random() * 10) - 20;
						}
				}

				return results;
				}

				window.addEventListener(
				"resize",
				function() {
						W = window.innerWidth;
						H = window.innerHeight;
						canvas.width = window.innerWidth;
						canvas.height = window.innerHeight;
				},
				false
				);

				// Push new confetti objects to `particles[]`
				for (var i = 0; i < maxConfettis; i++) {
					particles.push(new confettiParticle());
				}

				// Initialize
				canvas.width = W;
				canvas.height = H;
			
			
/**
 * Namespace
 */
var Game      = Game      || {};
var Keyboard  = Keyboard  || {}; 
var Component = Component || {};

/**
 * Keyboard Map
 */
Keyboard.Keymap = {
  37: 'left',
  38: 'up',
  39: 'right',
  40: 'down'
};

/**
 * Keyboard Events
 */
Keyboard.ControllerEvents = function() {
  
  // Setts
  var self      = this;
  this.pressKey = null;
  this.keymap   = Keyboard.Keymap;
  
  // Keydown Event
  document.onkeydown = function(event) {
    self.pressKey = event.which;
  };
  
  // Get Key
  this.getKey = function() {
    return this.keymap[this.pressKey];
  };
};

/**
 * Game Component Stage
 */
Component.Stage = function(canvas, conf) {  
  
  // Sets
  this.keyEvent  = new Keyboard.ControllerEvents();
  this.width     = canvas.width;
  this.height    = canvas.height;
  this.length    = [];
  this.food      = {};
  this.score     = 0;
  this.direction = 'right';
  this.conf      = {
    cw   : 10,
    size : 5,
    fps  : 1000
  };
  
  // Merge Conf
  if (typeof conf == 'object') {
    for (var key in conf) {
      if (conf.hasOwnProperty(key)) {
        this.conf[key] = conf[key];
      }
    }
  }
  
};

/**
 * Game Component Snake
 */
Component.Snake = function(canvas, conf) {
  
  // Game Stage
  this.stage = new Component.Stage(canvas, conf);
  
  // Init Snake
  this.initSnake = function() {
    
    // Itaration in Snake Conf Size
    for (var i = 0; i < this.stage.conf.size; i++) {
      
      // Add Snake Cells
      this.stage.length.push({x: i, y:0});
		}
	};
  
  // Call init Snake
  this.initSnake();
  
  // Init Food  
  this.initFood = function() {
		
    // Add food on stage
    this.stage.food = {
			x: Math.round(Math.random() * (this.stage.width - this.stage.conf.cw) / this.stage.conf.cw), 
			y: Math.round(Math.random() * (this.stage.height - this.stage.conf.cw) / this.stage.conf.cw), 
		};
	};
  
  // Init Food
  this.initFood();

  // Restart Stage
  this.restart = function() {
    this.stage.length            = [];
    this.stage.food              = {};
    this.stage.score             = 0;
    this.stage.direction         = 'right';
    this.stage.keyEvent.pressKey = null;
    this.initSnake();
    this.initFood();
  };
};

/**
 * Game Draw
 */
Game.Draw = function(context, snake) {
  
  // Draw Stage
  this.drawStage = function() {
    
    // Check Keypress And Set Stage direction
    var keyPress = snake.stage.keyEvent.getKey(); 
    if (typeof(keyPress) != 'undefined') {
      snake.stage.direction = keyPress;
    }
    
    // Draw White Stage
		context.fillStyle = "white";
		context.fillRect(0, 0, snake.stage.width, snake.stage.height);
		
    // Snake Position
    var nx = snake.stage.length[0].x;
		var ny = snake.stage.length[0].y;
		
    // Add position by stage direction
    switch (snake.stage.direction) {
      case 'right':
        nx++;
        break;
      case 'left':
        nx--;
        break;
      case 'up':
        ny--;
        break;
      case 'down':
        ny++;
        break;
    }
    
    // Check Collision
    if (this.collision(nx, ny) == true) {
      snake.restart();
      return;
    }
    
    // Logic of Snake food
    if (nx == snake.stage.food.x && ny == snake.stage.food.y) {
      var tail = {x: nx, y: ny};
      snake.stage.score++;
      snake.initFood();
    } else {
      var tail = snake.stage.length.pop();
      tail.x   = nx;
      tail.y   = ny;	
    }
    snake.stage.length.unshift(tail);
    
    // Draw Snake
    for (var i = 0; i < snake.stage.length.length; i++) {
      var cell = snake.stage.length[i];
      this.drawCell(cell.x, cell.y);
    }
    
    // Draw Food
    this.drawFood(snake.stage.food.x, snake.stage.food.y);
    
    // Draw Score
    context.fillText('Score: ' + snake.stage.score, 5, (snake.stage.height - 5));
  };
  
  // Draw Cell
  this.drawFood = function(x, y) {
    context.fillStyle = '#e42313';
    context.beginPath();
    context.arc((x * snake.stage.conf.cw + 6), (y * snake.stage.conf.cw + 6), 4, 0, 2*Math.PI, false);    
    context.fill();
  };
	
	// Draw food
  this.drawCell = function(x, y) {
    context.fillStyle = '#004077';
    context.beginPath();
    context.arc((x * snake.stage.conf.cw + 6), (y * snake.stage.conf.cw + 6), 4, 0, 2*Math.PI, false);    
    context.fill();
  };
  
  // Check Collision with walls
  this.collision = function(nx, ny) {  
    if (nx == -1 || nx == (snake.stage.width / snake.stage.conf.cw) || ny == -1 || ny == (snake.stage.height / snake.stage.conf.cw)) {
      return true;
    }
    return false;    
	}
};


/**
 * Game Snake
 */
Game.Snake = function(elementId, conf) {
  
  // Sets
  var canvas   = document.getElementById(elementId);
  var context  = canvas.getContext("2d");
  var snake    = new Component.Snake(canvas, conf);
  var gameDraw = new Game.Draw(context, snake);
  
  // Game Interval
  setInterval(function() {gameDraw.drawStage();}, snake.stage.conf.fps);
};
			
			

/**
 * Window Load
 */
window.onload = function() {
  var snake = new Game.Snake('stage', {fps: 100, size: 4});
};
		</script>
	</body>
</html>
