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
 * thiefsmarket.view.php
 *
 * This is your "view" file.
 *
 * The method "build_page" below is called each time the game interface is displayed to a player, ie:
 * _ when the game starts
 * _ when a player refreshes the game page (F5)
 *
 * "build_page" method allows you to dynamically modify the HTML generated for the game interface. In
 * particular, you can set here the values of variables elements defined in thiefsmarket_thiefsmarket.tpl (elements
 * like {MY_VARIABLE_ELEMENT}), and insert HTML block elements (also defined in your HTML template file)
 *
 * Note: if the HTML of your game interface is always the same, you don't have to place anything here.
 *
 */
  
  require_once( APP_BASE_PATH."view/common/game.view.php" );
  
  class view_thiefsmarket_thiefsmarket extends game_view
  {
    function getGameName() {
        return "thiefsmarket";
    }    
  	function build_page( $viewArgs )
  	{		
  	    // Get players & players number
        $players = $this->game->loadPlayersBasicInfos();
        $players_nbr = count( $players );

        /*********** Place your code below:  ************/

        /*
        
        // Examples: set the value of some element defined in your tpl file like this: {MY_VARIABLE_ELEMENT}

        // Display a specific number / string
        $this->tpl['MY_VARIABLE_ELEMENT'] = $number_to_display;

        // Display a string to be translated in all languages: 
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::_("A string to be translated");

        // Display some HTML content of your own:
        $this->tpl['MY_VARIABLE_ELEMENT'] = self::raw( $some_html_code );
        
        */
        
        /*
        
        // Example: display a specific HTML block for each player in this game.
        // (note: the block is defined in your .tpl file like this:
        //      <!-- BEGIN myblock --> 
        //          ... my HTML code ...
        //      <!-- END myblock --> 
        

        $this->page->begin_block( "thiefsmarket_thiefsmarket", "myblock" );
        foreach( $players as $player )
        {
            $this->page->insert_block( "myblock", array( 
                                                    "PLAYER_NAME" => $player['player_name'],
                                                    "SOME_VARIABLE" => $some_value
                                                    ...
                                                     ) );
        }
        
        */

        $this->tpl['LOOT'] = self::_("Loot");
        $this->tpl['LOOT_POOL'] = self::_("Loot Pool");

        // Arrange players so that player loot and hand is displayed first
        // $player_pos = $this->game->getPlayersPosition();

        $posPlayers= $this->game->getPlayersPosition();

        $this->page->begin_block("thiefsmarket_thiefsmarket", "player_loot");
        $this->page->begin_block("thiefsmarket_thiefsmarket", "player");

        $counter = 0;
        $clear = 'none';

        foreach($posPlayers as $player)
        {
          if ($counter === 0) {
            $player_name = self::_("My");
            $css_classes = "player_loot is_player";
          } else {
            $player_name = $player['player_name'];
            $css_classes = "player_loot";
          }

          if ($counter === 3) {
            $clear = 'left';
          } else {
            $clear = 'none';
          }

          $this->page->insert_block("player_loot", array(
            "PLAYER_ID"     => $player['player_id'],
            "PLAYER_NAME"   => $player_name,
            "PLAYER_COLOR"  => $player['player_color'],
            "PLAYER_CLASS"  => $css_classes,
            "CLEAR"         => $clear
          ));

          $this->page->insert_block("player", array(
            "PLAYER_ID"     => $player['player_id'],
            "PLAYER_NAME"   => $player['player_name'],
            "PLAYER_COLOR"  => $player['player_color']
          ));

          $counter++;
        }

        /*********** Do not change anything below this line  ************/
  	}
  }
  

