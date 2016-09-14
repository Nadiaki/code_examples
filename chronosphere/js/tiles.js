"use strict";
var stage,grid=[],sphere, preloadText, queue;
var levels=[], currentLevel=-1, tileSize=50;
var pulsars=[], lasers=[] ; //these are going to be an array of objects, each containing its coordinates?
var changedTiles=[];
//moves[] will contain the moves for the chronosphere. It will always have 4 items, for each of 4 phases in a turn
var moves=[];
//variable t is being used in the slideTo function, to regulate how may times the swirl has moved the sphere
var t = 0;
var currentPhase= 0;
var timerPhase2, timerPhase3, timerPhase4, phaseTimeout;
var countDown=200;
var interval;
var hourglassBG;
var sphereHealth;
var gameRunning=true;
var levelNumber;

function preload(){
    stage = new createjs.Stage("canvas");
    preloadText = new createjs.Text("", "50px ExistenceLight", "#f6f7fb");
    stage.addChild(preloadText);
    queue = new createjs.LoadQueue(true);
    queue.installPlugin(createjs.Sound);
    queue.on("progress", queueProgress);
    queue.on("complete", queueComplete);
    queue.loadManifest([
        "img/sprites/basetiles_ss.png",
        "img/sprites/dmgtiles_ss.png",
        "img/sphere.png",
        "img/endgame.png",
        "img/ui/ui_up.png",
        "img/ui/ui_down.png",
        "img/ui/ui_left.png",
        "img/ui/ui_right.png",
        "img/ui/ui_stay.png",
        "img/ui/ui_delete.png",
        "img/ui/ui_empty.png",
        "img/ui/ui_ok.png",
        "img/ui/ui_frame.png",
        {id:"tileSprites",src:"json/environment.json"}, //basic tiles, winds, whirls, walls
        {id:"dmgSprites",src:"json/dmgtiles.json"}, //lasers and pulsars (test version)
        {id:"uiSprites",src:"json/ui.json"},//ui (controls) sprites
        {id:"levelJson",src:"json/levels/levels.json"},
        {id:"bgsound", src:"sounds/bg_music.mp3"},
        {id:"lvlsound", src:"sounds/level.wav"},
        {id:"wallsound", src:"sounds/wall.wav"},
        {id:"whirlsound", src:"sounds/whirl.wav"}

    ])
}
function queueProgress(e){
    preloadText.text= Math.round(e.progress*100)+"%";
    preloadText.textBaseline="middle";
    preloadText.textAlign="center";
    preloadText.x = stage.canvas.width/2;
    preloadText.y = stage.canvas.height/2;
    stage.update();
}
function queueComplete(){
    var t = queue.getResult("levelJson");
    for(var i=0; i< t.levels.length; i++){
        levels.push(t.levels[i])
    }

    setupLevel();
    var bgMusic= new createjs.Sound.play("bgsound");
    bgMusic.loop=-1; //infinite loop for background music


    createjs.Ticker.setFPS(30);
    createjs.Ticker.on("tick", function(e){
        stage.update(e)

    })
}

function sphereMoves(move){
    switch(move){
        case "left":
            slideTo(-1, 0);
            break;
        case "up":
            slideTo(0, -1);
            break;
        case "right":
            slideTo(1, 0);
            break;
        case "down":
            slideTo(0, 1);
            break;
        case "stay":
            break;
    }
}

function phase(){
    if(gameRunning && sphere.dead==false){
    sphereMoves(moves[currentPhase]);
    //after the sphere moves, the "enemies" perform their actions, in each phase
    //performs current phase's actions for each pulsar.
    pulsarAnimation();
    //performs current phase's actions for each laser.
    laserAnimation();
    //before next phase, check if sphere got hit
    sphereTakesDamage(grid[sphere.row][sphere.col].tileNumber);
    console.log(sphere.hp);
    // before next phase, reset changed tiles
    phaseTimeout = setTimeout(resetChangedTiles, 500);
        if (sphere.dead==false){
            currentPhase++;
            if(currentPhase==4){
                setTimeout(afterTurnReset, 500);
            }
        }

    }
}

function afterTurnReset(){
    pulsarAnimation();
    moves=[];
    displayMoves();
    currentPhase=0;
    hourglassBG.height=25;
    hourglassBG.scaleY=0;
    countDown=200;
    interval = setInterval(countDownTimer, 100);
}

function nextTurn() {
    phase();
    timerPhase2 = setTimeout(phase, 800);
    timerPhase3 = setTimeout(phase, 1800);
    timerPhase4 = setTimeout(phase, 3000);
}

function pulsarAnimation(){
    for (var p=0; p< pulsars.length; p++) {
        switch (currentPhase + 1) { //the variable goes from 0 to 3, so we use +1 for readability
            case 2:
                //add spritesheet animation for SECOND phase
                grid[pulsars[p].row][pulsars[p].col].gotoAndStop("pulsar2"); //SPRITE NAME
                grid[pulsars[p].row][pulsars[p].col].tileNumber = 22; //SPRITE NUMBER
                break;
            case 3:
                //add spritesheet animation for THIRD phase
                grid[pulsars[p].row][pulsars[p].col].gotoAndStop("pulsar3"); //SPRITE NAME
                grid[pulsars[p].row][pulsars[p].col].tileNumber = 23; //SPRITE NUMBER
                break;
            case 4:
                //add spritesheet animation for FOURTH phase
                //in the 4th phase, pulsar itself looks the same as in 3rd phase, but it deals area of effect damage, on all surrounding tiles
                for (var i = -1; i < 2; i++) {
                    for (var j = -1; j < 2; j++) {
                        if (grid[pulsars[p].row + i][pulsars[p].col + j].tileNumber == 8) {
                            grid[pulsars[p].row + i][pulsars[p].col + j].gotoAndStop("aoe");
                            grid[pulsars[p].row + i][pulsars[p].col + j].tileNumber = 24;
                            addTileToReset(pulsars[p].row + i, pulsars[p].col + j);
                        }
                    }
                }
                break;
            case 5:
                grid[pulsars[p].row][pulsars[p].col].gotoAndStop("pulsar1"); //SPRITE NAME
                grid[pulsars[p].row][pulsars[p].col].tileNumber = 21; //SPRITE NUMBER
                break;
        }
    }
}

function laserAnimation(){
    for (var l=0; l< lasers.length; l++ ) {
        switch (currentPhase+1){ //we're looking at phases, so i+1 to use 1-4 as phase numbers, instead of 0-3
            case 1: //laser shoots in 2 squares above it
                if (!tileBlocksLaser(lasers[l].row-1,lasers[l].col)){ //check if first tile would block
                    if (!tileBlocksLaser(lasers[l].row-2,lasers[l].col)){ //check if second tile would block
                        laserFires(-1,0, "laserNS", 26, l);
                        laserFires( -2,0, "laserEN", 28, l);

                    }else { //if second tile blocks laser, use sprite laserEN on first tile instead of second
                        laserFires(-1,0, "laserEN", 28, l);
                    }
                }
                break;
            case 2: //laser shoots in 2 squares to the right
                if (!tileBlocksLaser(lasers[l].row,lasers[l].col+1)){ //check if first tile would block
                    if (!tileBlocksLaser(lasers[l].row,lasers[l].col+2)){ //check if second tile would block
                        laserFires(0,1, "laserWE", 27, l);
                        laserFires(0,2, "laserEE", 29, l);
                    }else {
                        laserFires(0,1, "laserEE", 29, l);
                    }
                }
                break;
            case 3: //laser shoots in 2 squares down
                if (!tileBlocksLaser(lasers[l].row+1,lasers[l].col)){ //check if first tile would block
                    if (!tileBlocksLaser(lasers[l].row+2,lasers[l].col)){ //check if second tile would block
                        laserFires(1,0, "laserNS", 26, l);
                        laserFires(2,0, "laserES", 30, l);
                    }else{
                        laserFires(1,0, "laserES", 30, l);
                    }
                }
                break;
            case 4: //laser shoots in 2 squares to the left
                if (!tileBlocksLaser(lasers[l].row,lasers[l].col-1)){ //check if first tile would block
                    if (!tileBlocksLaser(lasers[l].row,lasers[l].col-2)){ //check if second tile would block
                        laserFires(0,-1, "laserWE", 27, l);
                        laserFires(0,-2, "laserEW", 21, l);
                    }else{
                        laserFires(0,-1, "laserEW", 21, l);
                    }
                }
                break;
        }
    }
}

// laserFires receives modifiers for row and column, sprite name, tile number, and the current position in lasers[]
function laserFires(r, c, spriteName, tilenumber, l){
    grid[lasers[l].row+r][lasers[l].col+c].gotoAndStop(spriteName);
    grid[lasers[l].row+r][lasers[l].col+c].tileNumber = tilenumber;
    addTileToReset(lasers[l].row+r, lasers[l].col+c);
}

function addTileToReset(row, col){
    changedTiles.push({row:row, col:col});
}

function resetChangedTiles(){
    for (var i=0; i<changedTiles.length; i++){
        grid[changedTiles[i].row][changedTiles[i].col].gotoAndStop("base");
        grid[changedTiles[i].row][changedTiles[i].col].tileNumber = 8;
    }
    changedTiles=[];
}

function sphereTakesDamage(tilenumber){
    switch(tilenumber){
        case 0: //canvas edge tiles 0-3
        case 1:
        case 2:
        case 3:
            sphere.hp = sphere.hp-1;
            break;
        case 10: //full damage wall
            sphere.hp = sphere.hp-2;
            break;
        case 11: //half damage wall
            sphere.hp = sphere.hp-1;
            break;
        case 24: //pulsar aoe placeholder sprite - this will need to be changed when final pulsar aoe sprites are made
            sphere.hp = sphere.hp-1;
            break;
        case 26: //lasers
        case 27:
        case 28:
        case 29:
        case 30:
        case 31:
            sphere.hp = sphere.hp-2;
            break;
    }
    stage.removeChild(sphereHealth);
    sphereHealth = new createjs.Shape;
    if (sphere.hp<=4){
        sphereHealth.graphics.beginFill("#db4453").drawRect(0,0,390*0.1*sphere.hp,40);
    }else {
        sphereHealth.graphics.beginFill("#4fc0e8").drawRect(0,0,390*0.1*sphere.hp,40);
    }
    //full health: sphereHealth.width=390;
    //if health drops to 4, change fill to #db4453
    sphereHealth.x = 1130;
    sphereHealth.y = 355;
    stage.addChild(sphereHealth);
    //sphereHealth.width = 390*0.1*sphere.hp;
    stage.update();
    if (sphere.hp<=0){
        clearInterval(interval);
        death();
        sphere.dead=true;
    }
}

function death(){
    resetGame();
    gameRunning=false;
    moves=[];
    sphere.dead=true;
    clearInterval(interval);
    currentPhase=-1;
    splashScreen();
}

function tileBlocksLaser(r,c){
    //returns true (tile blocks laser) for every tile other than the base (8)
    return grid[r][c].tileNumber != 8;
}

function isValidTile(r,c){

    switch(grid[r][c].tileNumber){
        case 0: // north edge of the board
            createjs.Sound.play("wallsound");
            sphereTakesDamage(0);
            return false;
            break;
        case 1: // east edge of the board
            createjs.Sound.play("wallsound");
            sphereTakesDamage(1);
            return false;
            break;
        case 2: // south edge of the board
            createjs.Sound.play("wallsound");
            sphereTakesDamage(2);
            return false;
            break;
        case 3: // west edge of the board
            createjs.Sound.play("wallsound");
            sphereTakesDamage(3);
            return false;
            break;
        case 4: // north west part of the swirl
            createjs.Sound.play("whirlsound");
            return true;
            break;
        case 5: // north east part of the swirl
            createjs.Sound.play("whirlsound");
            return true;
            break;
        case 6: // south east part of the swirl
            createjs.Sound.play("whirlsound");
            return true;
            break;
        case 7: // south west part of the swirl
            createjs.Sound.play("whirlsound");
            return true;
            break;
        case 8: // base tile (empty)
            return true;
            break;
        case 9: // board exit
            return true;
            break;
        case 10: //full-damage wall
            createjs.Sound.play("wallsound");
            sphereTakesDamage(10);
            return false;
            break;
        case 11: // half-damage wall
            createjs.Sound.play("wallsound");
            sphereTakesDamage(11);
            return false;
            break;
        case 12: //up wind
        case 13: //right wind
        case 14: //down wind
        case 15: //left wind
            return true;
            break;
        case 16: // empty edge of board (corner)
            return false;
            break;
        case 17:
            moves=[];
            createjs.Sound.play("lvlsound");
            setTimeout(splashScreen, 1000);
            return true;
            break;
        case 21: // pulsar in phase 1
        case 22: // pulsar in phase 2
        case 23: // pulsar in phase 3 and 4
            return false;
            break;
        case 24: // TODO: pulsar aoe damage - this will have to be changed when final aoe sprites are made
            sphereTakesDamage(24);
            return true;
            break;
        case 25: // laser generator
            return false;
            break;
        case 26: // laserNS - north and south full line laser
            sphereTakesDamage(26);
            return true;
            break;
        case 27: // laserWE - west and east full line laser
            sphereTakesDamage(27);
            return true;
            break;
        case 28: // laserEN - laser ending north
            sphereTakesDamage(28);
            return true;
            break;
        case 29: // laserEE - laser ending east
            sphereTakesDamage(29);
            return true;
            break;
        case 30: // laserES - laser ending south
            sphereTakesDamage(30);
            return true;
            break;
        case 31: // laserEW - laser ending west
            sphereTakesDamage(31);
            return true;
            break;


    }
}

function resetGame(){
    currentPhase=0;
    clearTimeout(timerPhase2);
    clearTimeout(timerPhase3);
    clearTimeout(timerPhase4);
    clearTimeout(phaseTimeout);
}

function splashScreen(){
    moves=[];
    gameRunning=false;
    clearInterval(interval);
    resetGame();
    stage.removeAllChildren();
    var splash;
    if (sphere.dead==true){
        splash = new createjs.Bitmap("img/death.png");
        currentLevel=currentLevel-0.5;
    }else if(currentLevel+1==levels.length){
        currentLevel=-1;
        splash = new createjs.Bitmap("img/endgame.png");
    }else{
        splash = new createjs.Bitmap("img/levelup.png");
    }
    stage.addChild(splash);
    stage.update();
    splash.addEventListener('click', function(){
    setupLevel();
    });
 }


//hourglass full: height 0, hourglass empty: height 150
function countDownTimer(){
    countDown--;
    //goal 150, have 25
    hourglassBG.scaleY+=0.025;
    if(countDown==0){
        clearInterval(interval);
        nextTurn();
    }
}

function setupLevel(){
    resetGame();
    stage.removeAllChildren();
    pulsars=[];
    lasers=[];
    currentLevel++;
    gameRunning=true;

//UI ELEMENTS:

    var hourglass; //sand in the hourglass (this doesn't change!!)
    hourglass = new createjs.Shape;
    hourglass.graphics.beginFill("#ffce54").drawRect(0,0,50,150);
    hourglass.x = 1175;
    hourglass.y = 625;
    stage.addChild(hourglass);

    //TODO: this should count the time to make moves - reduce height through time
    //this part covers up the sand as the time is running out
    hourglassBG = new createjs.Shape;
    hourglassBG.graphics.beginFill("#434a54").drawRect(0,0,50,25);
    hourglassBG.x = 1175;
    hourglassBG.y = 625;
    stage.addChild(hourglassBG);
    //hourglass full: height 0, hourglass empty: height 150

    interval = setInterval(countDownTimer, 100);

    var uiFrame;
    uiFrame = new createjs.Bitmap("img/ui/ui_frame.png");
    uiFrame.width = 500;
    uiFrame.height = 800;
    uiFrame.x = 1075;
    uiFrame.y = 25;
    stage.addChild(uiFrame);

    levelNumber = new createjs.Text(currentLevel+1, "37px ExistenceLight", "#FFF");
    levelNumber.y = 78;
    levelNumber.x = 1265;
    levelNumber.x = 1265;
    stage.addChild(levelNumber);

    //spheres
    //TODO: these need to be linked to life count
    var lifeOne;
    lifeOne = new createjs.Bitmap ("img/sphere.png");
    lifeOne.width = lifeOne.height = 50;
    lifeOne.x = 1325;
    lifeOne.y = 200;
    stage.addChild(lifeOne);

    var lifeTwo;
    lifeTwo = new createjs.Bitmap ("img/sphere.png");
    lifeTwo.width = lifeTwo.height = 50;
    lifeTwo.x = 1375;
    lifeTwo.y = 200;
    stage.addChild(lifeTwo);

    var lifeThree;
    lifeThree = new createjs.Bitmap ("img/sphere.png");
    lifeThree.width = lifeThree.height = 50;
    lifeThree.x = 1425;
    lifeThree.y = 200;
    stage.addChild(lifeThree);

    //health bar
     //TODO: needs to be linked to HP
    sphereHealth = new createjs.Shape;
    sphereHealth.graphics.beginFill("#4fc0e8").drawRect(0,0,390,40);
    //full health: sphereHealth.width=390;
    //if health drops to 4, change fill to #db4453
    sphereHealth.x = 1130;
    sphereHealth.y = 355;
    stage.addChild(sphereHealth);



    var uiUp;
    uiUp = new createjs.Bitmap("img/ui/ui_up.png");
    uiUp.width = uiUp.height = 50;
    uiUp.x = 1375;
    uiUp.y = 625;
    stage.enableMouseOver(uiUp);
    uiUp.cursor = 'pointer';
    stage.addChild(uiUp);
    uiUp.on("click", function(){
        if (moves.length<4 && currentPhase==0){
            moves.push("up");
            displayMoves();
        }
    });

    var uiDown;
    uiDown = new createjs.Bitmap("img/ui/ui_down.png");
    uiDown.width = uiDown.height = 50;
    uiDown.x = 1375;
    uiDown.y = 725;
    stage.enableMouseOver(uiDown);
    uiDown.cursor = 'pointer';
    stage.addChild(uiDown);
    uiDown.on("click", function(){
        if (moves.length<4 && currentPhase==0) {
            moves.push("down");
            displayMoves();
        }
    });

    var uiLeft;
    uiLeft = new createjs.Bitmap("img/ui/ui_left.png");
    uiLeft.width = uiLeft.height = 50;
    uiLeft.x = 1325;
    uiLeft.y = 675;
    stage.enableMouseOver(uiLeft);
    uiLeft.cursor = 'pointer';
    stage.addChild(uiLeft);
    uiLeft.on("click", function(){
        if (moves.length<4 && currentPhase==0) {
            moves.push("left");
            displayMoves();
        }
    });

    var uiRight;
    uiRight = new createjs.Bitmap("img/ui/ui_right.png");
    uiRight.width = uiRight.height = 50;
    uiRight.x = 1425;
    uiRight.y = 675;
    stage.enableMouseOver(uiRight);
    uiRight.cursor = 'pointer';
    stage.addChild(uiRight);
    uiRight.on("click", function(){
        if (moves.length<4 && currentPhase==0) {
            moves.push("right");
            displayMoves();
        }
    });

    var uiStay;  //TODO decide on stay or skip, use same name on "sphereMoves"
    uiStay = new createjs.Bitmap("img/ui/ui_stay.png");
    uiStay.width = uiStay.height = 50;
    uiStay.x = 1375;
    uiStay.y = 675;
    stage.enableMouseOver(uiStay);
    uiStay.cursor = 'pointer';
    stage.addChild(uiStay);
    uiStay.on("click", function(){
        if (moves.length<4 && currentPhase==0){
            moves.push("stay");
            displayMoves();
        }
    });

    var uiDelete;
    uiDelete = new createjs.Bitmap("img/ui/ui_delete.png");
    uiDelete.width = uiDelete.height = 50;
    uiDelete.x = 1375;
    uiDelete.y = 550;
    stage.enableMouseOver(uiDelete);
    uiDelete.cursor = 'pointer';
    stage.addChild(uiDelete);
    uiDelete.on("click", function(){
        if (currentPhase==0){
            moves.pop();
            displayMoves();
        }
    });

    var uiReady;
    uiReady = new createjs.Bitmap("img/ui/ui_ok.png");
    uiReady.width = uiDelete.height = 50;
    uiReady.x = 1475;
    uiReady.y = 550;
    stage.enableMouseOver(uiReady);
    uiReady.cursor = 'pointer';
    stage.addChild(uiReady);
    uiReady.on("click", function(){
        if (currentPhase==0){
            clearInterval(interval);
            nextTurn();
        }
    }
    );


    var uiPhaseOne;
    uiPhaseOne = new createjs.Bitmap("img/ui/ui_empty.png");
    uiPhaseOne.width = uiPhaseOne.height = 50;
    uiPhaseOne.x = 1125;
    uiPhaseOne.y = 550;
    stage.addChild(uiPhaseOne);

    var uiPhaseTwo;
    uiPhaseTwo = new createjs.Bitmap("img/ui/ui_empty.png");
    uiPhaseTwo.width = uiPhaseTwo.height = 50;
    uiPhaseTwo.x = 1175;
    uiPhaseTwo.y = 550;
    stage.addChild(uiPhaseTwo);

    var uiPhaseThree;
    uiPhaseThree = new createjs.Bitmap("img/ui/ui_empty.png");
    uiPhaseThree.width = uiPhaseThree.height = 50;
    uiPhaseThree.x = 1225;
    uiPhaseThree.y = 550;
    stage.addChild(uiPhaseThree);

    var uiPhaseFour;
    uiPhaseFour = new createjs.Bitmap("img/ui/ui_empty.png");
    uiPhaseFour.width = uiPhaseFour.height = 50;
    uiPhaseFour.x = 1275;
    uiPhaseFour.y = 550;
    stage.addChild(uiPhaseFour);

    var tiles_ss = new createjs.SpriteSheet(queue.getResult('tileSprites'));
    var dmg_ss = new createjs.SpriteSheet(queue.getResult('dmgSprites'));
    var level = levels[currentLevel].tiles;

    grid=[];
    for(var i=0; i < level.length; i++){
        grid.push([]);
        for(var z=0; z< level[0].length; z++){
            grid[i].push(null);
        }
    }

    var sphereRow, sphereCol;
    for(var row=0; row<level.length; row++){
        for(var col =0; col<level[0].length; col++){
            var img='';
            switch(level[row][col]){
                case 0: //north edge of the map
                    img="northwall";
                    break;
                case 1: //east edge of the map
                    img="eastwall";
                    break;
                case 2: //south edge of the map
                    img="southwall";
                    break;
                case 3: //west edge of the map
                    img="westwall";
                    break;
                case 4://north west part of the whirlwind
                    img="nwwhirl";
                    break;
                case 5://north east part of the whirlwind
                    img="newhirl";
                    break;
                case 6://south east part of the whirlwind
                    img="sewhirl";
                    break;
                case 7://south west part of the whirlwind
                    img="swwhirl";
                    break;
                case 8://basic, empty tile on the map
                    img="base";
                    break;
                case 9://map exit
                    img="exit";
                    break;
                case 10://wall that deals full damage
                    img="fullwall";
                    break;
                case 11://wall that deals half damage
                    img="halfwall";
                    break;
                case 12://wind pushing up
                    img="upwind";
                    break;
                case 13://wind pushing right
                    img="rightwind";
                    break;
                case 14://wind pushing down
                    img="downwind";
                    break;
                case 15://wind pushing left
                    img="leftwind";
                    break;
                case 16://empty tile without borders (for corners of the map wall)
                    img="empty";
                    break;
                case 17://wall tile next to the exit
                    img="eastwall";
                    break;
                case 21://pulsar in phase 1
                    img="pulsar1";
                    var pulsarItem = {row:row, col:col}; //creating an object and pushing it in an array
                    pulsars.push(pulsarItem);
                    break;
                case 22://pulsar in phase 2
                    img="pulsar2";
                    break;
                case 23://pulsar in phase 3 and 4
                    img="pulsar3";
                    break;
                case 24://aoe damage placeholder image
                    img="aoe";
                    break;
                case 25://laser generator
                    img="laserGen";
                    lasers.push({row:row,col:col}); //array of nameless objects
                    break;
                case 26://north/south full length laser beam (vertical laser beam)
                    img="laserNS";
                    break;
                case 27://west/east full length laser beam (horizontal laser beam)
                    img="laserWE";
                    break;
                case 28://ending for north laser beam
                    img="laserEN";
                    break;
                case 29://ending for east laser beam
                    img="laserEE";
                    break;
                case 30://ending for south laser beam
                    img="laserES";
                    break;
                case 31://ending for west laser beam
                    img="laserEW";
                    break;
                case 100: //sphere starting point
                    img="base";
                    sphereRow=row;
                    sphereCol=col;
                    break;
                
            } //the switch assigns image
            if (level[row][col]==8 || (level[row][col]>17 && level[row][col]<=31) ){
                var tile = new createjs.Sprite(dmg_ss, img);
            }else  {
            //if (level[row][col] <=16 || level[row][col] ==100 ){
                var tile = new createjs.Sprite(tiles_ss, img);
            }


            tile.x=col*tileSize;
            tile.y=row*tileSize;
            tile.row=row;
            tile.col=col;
            tile.tileNumber=level[row][col];
            stage.addChild(tile);
            grid[row][col]=tile;
        }
    }
    sphere = new createjs.Bitmap("img/sphere.png");
    sphere.x=sphereCol*tileSize;
    sphere.y=sphereRow*tileSize;
    sphere.row=sphereRow;
    sphere.col=sphereCol;
    sphere.hp=10;
    sphere.dead=false;


    stage.addChild(sphere);
}

function displayMoves() {
    var uiPhaseOne;
    if (moves.length>0){
        switch (moves[0]){
            case "left":
                uiPhaseOne = new createjs.Bitmap("img/ui/ui_left.png");
                break;
            case "up":
                uiPhaseOne = new createjs.Bitmap("img/ui/ui_up.png");
                break;
            case "right":
                uiPhaseOne = new createjs.Bitmap("img/ui/ui_right.png");
                break;
            case "down":
                uiPhaseOne = new createjs.Bitmap("img/ui/ui_down.png");
                break;
            case "stay":
                uiPhaseOne = new createjs.Bitmap("img/ui/ui_stay.png");
                break;
        }
    }else{
        uiPhaseOne = new createjs.Bitmap("img/ui/ui_empty.png");

    }
    uiPhaseOne.width = uiPhaseOne.height = 50;
    uiPhaseOne.x = 1125;
    uiPhaseOne.y = 550;
    stage.addChild(uiPhaseOne);

    var uiPhaseTwo;
    if (moves.length>1){
        switch (moves[1]){
            case "left":
                uiPhaseTwo = new createjs.Bitmap("img/ui/ui_left.png");
                break;
            case "up":
                uiPhaseTwo = new createjs.Bitmap("img/ui/ui_up.png");
                break;
            case "right":
                uiPhaseTwo = new createjs.Bitmap("img/ui/ui_right.png");
                break;
            case "down":
                uiPhaseTwo = new createjs.Bitmap("img/ui/ui_down.png");
                break;
            case "stay":
                uiPhaseTwo = new createjs.Bitmap("img/ui/ui_stay.png");
                break;
        }
    }else{
        uiPhaseTwo = new createjs.Bitmap("img/ui/ui_empty.png");

    }
    uiPhaseTwo.width = uiPhaseTwo.height = 50;
    uiPhaseTwo.x = 1175;
    uiPhaseTwo.y = 550;
    stage.addChild(uiPhaseTwo);

    var uiPhaseThree;
    if (moves.length>2){
        switch (moves[2]){
            case "left":
                uiPhaseThree = new createjs.Bitmap("img/ui/ui_left.png");
                break;
            case "up":
                uiPhaseThree = new createjs.Bitmap("img/ui/ui_up.png");
                break;
            case "right":
                uiPhaseThree = new createjs.Bitmap("img/ui/ui_right.png");
                break;
            case "down":
                uiPhaseThree = new createjs.Bitmap("img/ui/ui_down.png");
                break;
            case "stay":
                uiPhaseThree = new createjs.Bitmap("img/ui/ui_stay.png");
                break;
        }
    }else{
        uiPhaseThree = new createjs.Bitmap("img/ui/ui_empty.png");
    }
    uiPhaseThree.width = uiPhaseThree.height = 50;
    uiPhaseThree.x = 1225;
    uiPhaseThree.y = 550;
    stage.addChild(uiPhaseThree);

    var uiPhaseFour;
    if (moves.length>3){
        switch (moves[3]){
            case "left":
                uiPhaseFour = new createjs.Bitmap("img/ui/ui_left.png");
                break;
            case "up":
                uiPhaseFour = new createjs.Bitmap("img/ui/ui_up.png");
                break;
            case "right":
                uiPhaseFour = new createjs.Bitmap("img/ui/ui_right.png");
                break;
            case "down":
                uiPhaseFour = new createjs.Bitmap("img/ui/ui_down.png");
                break;
            case "stay":
                uiPhaseFour = new createjs.Bitmap("img/ui/ui_stay.png");
                break;
        }
    }else{
        uiPhaseFour = new createjs.Bitmap("img/ui/ui_empty.png");
    }
    uiPhaseFour.width = uiPhaseFour.height = 50;
    uiPhaseFour.x = 1275;
    uiPhaseFour.y = 550;
    stage.addChild(uiPhaseFour);





    stage.update();
}



function slideTo(colModifier, rowModifier){
    var newRow = sphere.row+rowModifier;
    var newCol = sphere.col+colModifier;
    if(isValidTile(newRow, newCol)){
        createjs.Tween.get(sphere).to({x:newCol*50,y:newRow*50},200).call(function(){
            sphere.row=newRow;
            sphere.col=newCol;
            sphere.x=newCol*tileSize;
            sphere.y=newRow*tileSize;
            //the switch checks what tile you land on after each tween.
            switch(grid[newRow][newCol].tileNumber) {
                case 4: //nw
                    if (swirl(t)){
                        t++;
                        setTimeout(slideTo(1,1), 300);

                        //slideTo(1,1);
                    }else {
                        t=0;
                    }
                    break;
                case 5: //ne
                    if (swirl(t)){
                        t++;

                        slideTo(-1,1);
                    }else {
                        t=0;
                    }
                    break;
                case 6: //se
                    if (swirl(t)){
                        t++;

                        slideTo(-1,-1);
                    }else {
                        t=0;
                    }
                    break;
                case 7: //sw
                    if (swirl(t)){
                        t++;

                        slideTo(1,-1);
                    }else {
                        t=0;
                    }
                    break;
                case 9://exit door, slide out
                    slideTo(1, 0);
                    break;
                case 12: //up
                    setTimeout(function(){
                        slideTo(0, -1);
                    }, 10);
                    break;
                case 13: //right

                    setTimeout(function(){
                        slideTo(1,0);
                    }, 10);
                    break;
                case 14: //down
                    setTimeout(function(){
                        slideTo(0, 1);
                    }, 10);
                    break;
                case 15: //left
                    setTimeout(function(){
                        slideTo(-1, 0);
                    }, 10);
                    break;

            }

        });


    }
}

function swirl(t){
    if (t == 0) {
        return true;
    }
    return false;
}


