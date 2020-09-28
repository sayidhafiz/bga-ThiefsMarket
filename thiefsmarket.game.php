<?php
 /**
  *------
  * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
  * Thief's Market implementation : © Sayid Hafiz <sayidhafiz@gmail.com>
  * 
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  * 
  * thiefsmarket.game.php
  *
  * This is the main file for your game logic.
  *
  * In this PHP file, you are going to defines the rules of the game.
  *
  */


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );


class ThiefsMarket extends Table
{
	function __construct( )
	{
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();
        
        self::initGameStateLabels( array(
                "firstPlayerId"     => 10,
                "nbPlayers"         => 11,
                "nbTurns"           => 12,
                "turnPlayerId"      => 13,
                "currentPlayerNum"  => 14,
                "is_promo"          => 101,
        ) );

        $this->cards = self::getNew( "module.common.deck" );
        $this->cards->init("card");

        $this->loots = self::getNew( "module.common.deck" );
        $this->loots->init("loot");
	}
	
    protected function getGameName( )
    {
		// Used for translations and stuff. Please do not modify.
        return "thiefsmarket";
    }	

    /*
        setupNewGame:
        
        This method is called only once, when a new game is launched.
        In this method, you must setup the game according to the game rules, so that
        the game is ready to be played.
    */
    protected function setupNewGame( $players, $options = array() )
    {    
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos          = self::getGameinfos();
        $default_colors     = $gameinfos['player_colors'];
        $nb_players         = count( $players );

        // Deck Management
        // $is_promo = $this->getGameStateValue("is_promo");
        $is_promo = false;
        
        $this->setGameStateInitialValue( "nbPlayers", $nb_players);
 
        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar, player_score) VALUES ";
        $values = array();
        foreach( $players as $player_id => $player )
        {
            $color = array_shift( $default_colors );
            $values[] = "('".$player_id."','$color','".$player['player_canal']."','".addslashes( $player['player_name'] )."','".addslashes( $player['player_avatar'] )."',0)";
        }
        $sql .= implode( $values, ',' );
        self::DbQuery( $sql );
        self::reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
        self::reloadPlayersBasicInfos();
        
        /************ Start the game initialization *****/

        // Init global values with their initial values
        //self::setGameStateInitialValue( 'my_first_global_variable', 0 );
        
        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)

        // TODO: setup the initial game situation here

        /*
         *  SETUP CARDS
         */

        // Cards array init
        $card_arr = array();
        
        // Determine whether to add or remove promo cards
        foreach($this->deck as $id => $card_info) {
            $market = $card_info['market'];

            if ($is_promo) {
                // Include promo cards
                $card_arr[$market][] = array(
                    'type'      => $card_info['market'],
                    'type_arg'  => $card_info['position'], 
                    'nbr'       => 1
                );
            } else {
                // Do not include promo cards
                if (!$card_info['is_promo']) {
                    $card_arr[$market][] = array(
                        'type'      => $card_info['market'],
                        'type_arg'  => $card_info['position'],
                        'nbr'       => 1
                    );
                }
            }
        }

        // Setup the deck and market pile for the game
        foreach($this->markets as $market => $size) {
            // Create the deck of cards for each market row
            $this->cards->createCards($card_arr[$market], 'deck_' . strtolower($market));

            // Shuffle each market deck
            $this->cards->shuffle('deck_' . strtolower($market));

            // Get total no. of cards in each market deck to determine how many to discard for the setup
            $total_cards = $this->cards->countCardInLocation('deck_' . strtolower($market));

            // Number of cards to discard
            $nr_discard = $total_cards - $this->markets[$market];

            // Discard cards down for the game setup
            $this->cards->pickCardsForLocation($nr_discard, 'deck_' . strtolower($market), 'discard_' . strtolower($market), true);

            // Deal 5 starting cards in Market A
            if ($market === 'A') {
                $this->cards->pickCardsForLocation(5, 'deck_a', 'market_a');
            }
        }
            

        /*
         *  SETUP LOOTS
         */

        // Setup Loot Pool
        $dice_nbr = $this->getTotalDice();
        

        // Loot array init
        $loot_arr = array();

        // Create the first player loot
        $loot_arr[] = array(
            'type'      => 'first_player',
            'type_arg'  => 99,
            'nbr'       => 1
        );

        // Create the dice
        for($i = 0; $i < $dice_nbr; $i++) {
            $dice_state = bga_rand(0, 5); // random dice value
            $loot_arr[] = array(
                'type'      => 'dice',
                'type_arg'  => $dice_state,
                'nbr'       => 1
            );
        }

        // Token array init
        $token_arr = array();

        // Create the infamy token
        $token_arr[] = array(
            'type'      => 'token',
            'type_arg'  => 6,
            'nbr'       => 33
        );

        // Create the gold token
        $token_arr[] = array(
            'type'      => 'token',
            'type_arg'  => 7,
            'nbr'       => 33
        );

        // Loot location 0 = loot is at middle pool
        $this->loots->createCards($loot_arr, 'table', 0);
        $this->loots->createCards($token_arr);

        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();

        /************ End of the game initialization *****/
    }

    /*
        getAllDatas: 
        
        Gather all informations about current game situation (visible by the current player).
        
        The method is called each time the game interface is displayed to a player, ie:
        _ when the game starts
        _ when a player refreshes the game page (F5)
    */
    protected function getAllDatas()
    {
        $result = array();
    
        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!
    
        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players']              = self::getCollectionFromDb( $sql );

        // Card related data
        $result['card_info']            = $this->deck; // from materials
        $result['deck']                 = $this->getDeckCards();
        $result['market']               = $this->getMarketCards();
        $result['player_cards']         = $this->getPlayerCards();
        $result['count_cards']          = $this->cards->countCardsInLocations();
        // $result['player_card_count']    = $this->cards->countCardsByLocationArgs('hand');

        // Loot related data
        $result['dice_state']           = $this->dice_state; // from materials
        $result['table_loots']          = $this->getTableLoots();
        $result['player_loots']         = $this->getPlayerLoots();
        $result['loots']                = $this->getAllLoots();
		$result['pool']					= $this->getPools();
		
        // TODO: Gather all information about current game situation (visible by player $current_player_id).
  
        return $result;
    }

    /*
        getGameProgression:
        
        Compute and return the current game progression.
        The number returned must be an integer beween 0 (=the game just started) and
        100 (= the game is finished or almost finished).
    
        This method is called each time we are in a game state with the "updateGameProgression" property set to true 
        (see states.inc.php)
    */
    function getGameProgression()
    {
        // TODO: compute and return the game progression

        return 0;
    }


//////////////////////////////////////////////////////////////////////////////
//////////// Utility functions
////////////    

    /*
        In this space, you can put any utility methods useful for your game logic
    */

    // Return players info but rearranged according to who is
    // playing. This is to set the main player play area to always
    // be positioned at the top for better UI/UX
    function getPlayersPosition()
    {
        $result = array();

        $players = self::loadPlayersBasicInfos();
        $players_nbr = count( $players );

        $nextPlayer = self::createNextPlayerTable( array_keys($players) );
        $mainPlayer = self::getCurrentPlayerId(); // this is the player that is playing

        if (!isset($nextPlayer[$mainPlayer]))
        {
            // Spectator mode: doesn't really matter the positioning
            $player_id = $nextPlayer[0];
        }
        else {
            $player_id = $mainPlayer;
        }

        $counter = 0;
        while ($counter < $players_nbr) {
            $result[$player_id] = $players[$player_id];
            $player_id = $nextPlayer[$player_id];
            $counter++;
        }

        return $result;
    }

    function getTotalDice() {
        $nb_players = $this->getGameStateValue( "nbPlayers");
        $result = 0;

        switch ($nb_players) {
            case 3:
                $result = 10;
                break;
            case 4:
                $result = 11;
                break;
            case 5:
                $result = 13;
                break;
            default:
                $result = 10;
        }

        return $result;
    }

    // Roll dice, returns dice state between 0 - 5
    function rollDice($id) {
        $dice_value = bga_rand(0, 5);
        $sql = "UPDATE loot SET card_type_arg = ".$dice_value." WHERE card_id = " . $id;
        self::DbQuery( $sql );
    }

    // Takes all dice from player hands and return to table
    // Roll all dice
    function resetDiceLoots() {
        if ($this->loots->countCardInLocation('table') <= $this->getTotalDice() ) {
            // means player holding onto unused dice
            $tableLoot  = $this->loots->getCardsOfTypeInLocation('dice', null, 'hand');

            foreach($tableLoot as $x => $loot) {
                $this->rollDice($loot['id']);
                $this->loots->moveCard($loot['id'], 'table');
            }

            $first_player = array_slice($this->loots->getCardsOfType("first_player"),0,1)[0];
			
            if(count($first_player) > 0) {
                $this->loots->moveCard($first_player['id'],'table');
            }
			$newReturnedItems=$this->loots->getCardsInLocation('table',0);
			       self::notifyAllPlayers( "lootReturnedToPool", clienttranslate( 'Loot Dice rolled' ), array(
			'items' => $newReturnedItems, 
			
			'numDice'=>count($newReturnedItems)));

			
        }
    }

    // Get each market deck
    function getDeckCards() {
        $result = array();

        foreach($this->markets as $market => $marketTotal) {
            $result[$market] = $this->cards->getCardsInLocation('deck_' . strtolower($market));
        }

        return $result;
    }

    // Get each market pile cards
    function getMarketCards() {
        $result = array();

        foreach($this->markets as $market => $marketTotal) {
            $result[$market] = $this->cards->getCardsInLocation('market_' . strtolower($market));
        }

        return $result;
    }

    // Get player cards
    function getPlayerCards() {
        $result = array();
        $players = self::loadPlayersBasicInfos();

        foreach( $players as $player_id => $player )
        {
            $result[$player_id] = $this->cards->getCardsInLocation('hand', $player_id);
        }

        return $result;
    }

    // Get loots on the table
    function getTableLoots() {
        return $this->loots->getCardsInLocation('table', null, 'type_arg');
    }

    //
	function getPools(){
		return $this->loots->getCardsInLocation('pool', null, 'type_arg');
    }
	

    // Get player loots
    function getPlayerLoots() {
        $result = array();
        $players = self::loadPlayersBasicInfos();

        foreach( $players as $player_id => $player )
        {
            $result[$player_id] = $this->loots->getCardsInLocation('hand', $player_id, 'type_arg');
        }

        return $result;
    }

    // Get all loots
    function getAllLoots() {
        $result = array();
        $players = self::loadPlayersBasicInfos();

        $tableLoot  = $this->loots->getCardsInLocation('table', null, 'type_arg');
        $tokens     = $this->loots->getCardsInLocation('deck');

        foreach($tableLoot as $x => $loot) {
            array_push($result, $loot);
        }

        foreach($tokens as $x => $token) {
            array_push($result, $token);
        }

        foreach( $players as $player_id => $player )
        {
            $playerLoot[$player_id] = $this->loots->getCardsInLocation('hand', $player_id, 'type_arg');
            foreach($playerLoot[$player_id] as $x => $loot) {
                array_push($result, $loot);
            }
        }

        return $result;
    }
    
	
	

//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
//////////// 

    /*
        Each time a player is doing some game action, one of the methods below is called.
        (note: each method below must match an input method in thiefsmarket.action.php)
    */

    /*
    
    Example:
    */
    function TakeLoot( $items)
    {
		//****************************************************************************************************
		//   ******************* Valid Move Checking Section ****************************************
		//****************************************************************************************************
        // Check that this is the player's turn and that it is a "possible action" at this game state (see states.inc.php)
        self::checkAction( 'takeLoot' ); 
        
		
		
		//Can't pass -- no taking zero loot
		if(count($items)==0)
			{throw new feException( self::_("You must select some loot"), true );}
		//Loot must be chosen from only one location the javascript should enforce this, but it's best to inforce this on this side
		$location=self::lootLocation($items);
		if($location==-2)
			{throw new feException( self::_("loot may only be stolen from one location"), true );}
		
		//if last player to grab loot from the middle all loot must be taken
		if($location==0)
		{
			 
		$nbplayers = $this->getGameStateValue("nbPlayers");
		if($nbplayers-1<=self::playersWhoHaveLoot())
			{ if (count($items)!=$this->loots->countCardInLocation('table',0))
				{  throw new feException( self::_("All loot must be taken"), true );}
			}
		}
		//if taking from another player must not take everything
		if($location!=0)
		{ 
			if($this->loots->countCardInLocation('table',$location)==count($items))
			{  throw new feException( self::_("Must return at least one loot when stealing loot"), true );}
		}		  
			
	
		//********************************   END CHECKS ************************************

		//Do Work			
        $player_id = self::getActivePlayerId();
        $this->loots->moveCards($items,"table", $player_id);
		
        
        // Notify all players about the loot taken
        self::notifyAllPlayers( "lootTaken", clienttranslate( '${player_name} has chosen loot' ), array(
            'player_id' => $player_id,
            'player_name' => self::getActivePlayerName(),
			'items' => $items ,
			'location'=> $location
        ) );
		
		//If stealing rereroll remaining loot
		if($location!=0)
		{
			$returnedItems= $this->loots->getCardsInLocation("table",$location);
			foreach($returnedItems as $x=>$item  )
				{if($item["type"]!="first_player") //don't reroll the first player token
					{self::rollDice($item["id"]);}
				}
			$newReturnedItems= $this->loots->getCardsInLocation("table",$location);		
			$this->loots->moveAllCardsInLocation( "table", "table", $location, 0 );
            self::notifyAllPlayers( "lootReturnedToPool", clienttranslate( '${numDice} returned to pool' ), array(
            'player_id' => $player_id,
            'player_name' => self::getActivePlayerName(),
			'items' => $newReturnedItems, 
			'location'=> $location,
			'numDice'=>count($newReturnedItems)));

		}
		
          $this->gamestate->nextState( 'nextPlayerSplitLoot' );
    }
	
	function passMarket()
	{
		self::checkAction( 'passMarket' ); 
	    $this->gamestate->nextState( 'nextPlayerMakePurchases' );
        
	}
	
    
    function lootLocation($items)
	{
		$itemList=join(",",$items);
		$sql = "SELECT card_location_arg as lootLocations fROM `loot` WHERE card_location='table' and card_id in ($itemList) group by card_location_arg;" ;
        $lootLocations   = self::getObjectListFromDB( $sql,true );
		if(count($lootLocations)==1) {return $lootLocations[0];}
		return -2;		
	}
    
	function playersWhoHaveLoot()
	{
		$sql = "SELECT count(DISTINCT card_location_arg) as lootLocations fROM `loot` WHERE card_location='table' and not card_location_arg=0";
        $nbrOfLootLocations   = self::getObjectListFromDB( $sql,true )[0];	
		return($nbrOfLootLocations);
	}
	
//////////////////////////////////////////////////////////////////////////////
//////////// Game state arguments
////////////

    /*
        Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
        These methods function is to return some additional information that is specific to the current
        game state.
    */

    /*
    
    Example for game state "MyGameState":
    
    function argMyGameState()
    {
        // Get some values from the current game situation in database...
    
        // return values:
        return array(
            'variable1' => $value1,
            'variable2' => $value2,
            ...
        );
    }    
    */


//////////////////////////////////////////////////////////////////////////////
//////////// Game state actions
////////////

    /*
        Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
        The action method of state X is called everytime the current game state is set to X.
    */
    
    /*
    
    Example for game state "MyGameState":

    function stMyGameState()
    {
        // Do some stuff ...
        
        // (very often) go to another gamestate
        $this->gamestate->nextState( 'some_gamestate_transition' );
    }    
    */
	function stNextPlayerSplitLoot()
	{
		    //if all players have loot go to market phase
		    	$nbrPlayers = $this->getGameStateValue( "nbPlayers");
		if($nbrPlayers==self::playersWhoHaveLoot())
			{$this->gamestate->nextState( 'beginMakingPurchases' );}
		else
		{	
			//skip players who have Loot
			$player_id = self::getActivePlayerId();	
			while($this->loots->countCardInLocation('table',$player_id)!=0)
				{$player_id = self::activeNextPlayer();}			
			self::giveExtraTime( $player_id );
			$this->gamestate->nextState( 'playerSplitLoot' );
		}
	}    
    function stBeginSplitLoot()
    {

        $this->resetDiceLoots();
        $this->gamestate->nextState('playerSplitLoot');
    }
	
	function stBeginMakingPurchases()
	{
		 // self::activeNextPlayer();
		 
		 //set the person who got the first player token as next
		   $firstPlayer= array_slice($this->loots->getCardsOfType("first_player"),0,1)[0];
			  $this->gamestate->changeActivePlayer( $firstPlayer["location_arg"] );
		  $this->setGameStateInitialValue( "firstPlayerId", $firstPlayer["location_arg"]);
	     	
		  $this->gamestate->nextState('playerMakePurchases');
		  $players = self::loadPlayersBasicInfos();
		  
		  //move everything from the table to the hand
	    foreach( $players as $player_id => $player)
			{$this->loots->moveAllCardsInLocation('table','hand',$player_id,$player_id);}
			
		self::notifyAllPlayers( "startMarketPhase", clienttranslate( 'Market phase has started' ), array());
	}
	
	function stNextPlayerMakePurchases()
	{
         //check if everyone has had a chance to buy		
		$player_id = self::activeNextPlayer();			
		if($player_id==$this->getGameStateValue( "firstPlayerId"))
		   { $this->gamestate->nextState('beginSplitLoot');}
		else {$this->gamestate->nextState('playerMakePurchases');}
	}

//////////////////////////////////////////////////////////////////////////////
//////////// Zombie
////////////

    /*
        zombieTurn:
        
        This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
        You can do whatever you want in order to make sure the turn of this player ends appropriately
        (ex: pass).
        
        Important: your zombie code will be called when the player leaves the game. This action is triggered
        from the main site and propagated to the gameserver from a server, not from a browser.
        As a consequence, there is no current player associated to this action. In your zombieTurn function,
        you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message. 
    */

    function zombieTurn( $state, $active_player )
    {
    	$statename = $state['name'];
    	
        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState( "zombiePass" );
                	break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive( $active_player, '' );
            
            return;
        }

        throw new feException( "Zombie mode not supported at this game state: ".$statename );
    }
    
///////////////////////////////////////////////////////////////////////////////////:
////////// DB upgrade
//////////

    /*
        upgradeTableDb:
        
        You don't have to care about this until your game has been published on BGA.
        Once your game is on BGA, this method is called everytime the system detects a game running with your old
        Database scheme.
        In this case, if you change your Database scheme, you just have to apply the needed changes in order to
        update the game database and allow the game to continue to run with your new version.
    
    */
    
    function upgradeTableDb( $from_version )
    {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345
        
        // Example:
//        if( $from_version <= 1404301345 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        if( $from_version <= 1405061421 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        // Please add your future database scheme changes here
//
//


    }    
}
