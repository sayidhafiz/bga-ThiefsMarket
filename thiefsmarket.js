/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * Thief's Market implementation : © Sayid Hafiz <sayidhafiz@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * thiefsmarket.js
 *
 * Thief's Market user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo","dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",
    "ebg/stock",
],
function (dojo, declare) {
    return declare("bgagame.thiefsmarket", ebg.core.gamegui, {
        constructor: function(){
            console.log('thiefsmarket constructor');
            var self = this;


            this.cards          = [];
            this.playerHand     = [];
            this.tableLoot      = [];
            this.playerLoot     = [];
            this.lootLocation   = [];

            this.cardWidth      = 110;
            this.cardHeight     = 154;
            this.cardByRow      = 8;

            this.lootSize       = 45;
            this.lootRow        = 9;

            this.marketInfo     = [
                {"type": "A", "total_cards": 16},
                {"type": "B", "total_cards": 22}, 
                {"type": "C", "total_cards": 15}
            ];


            this.cardInfo       = {};
            this.deck           = {};
            this.market         = {};
            this.diceState      = {};

            // https://codeburst.io/the-only-way-to-detect-touch-with-javascript-7791a3346685
            window.addEventListener('touchstart', function() {
                self.isTouchScreen = true;
            });

        },
        
        /*
            setup:
            
            This method must set up the game user interface according to current game situation specified
            in parameters.
            
            The method is called each time the game interface is displayed to a player, ie:
            _ when the game starts
            _ when a player refreshes the game page (F5)
            
            "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
        */
        
        setup: function( gamedatas )
        {
            console.log( "Starting game setup" );
            // dojo.destroy('debug_output');

            var self = this;

            console.log("CARD INFO:");
            console.log(gamedatas.card_info);

            console.log("DECK:");
            console.log(gamedatas.deck);

            console.log("MARKET:");
            console.log(gamedatas.market);

            console.log("PLAYER CARDS:");
            console.log(gamedatas.player_cards);

            console.log("TABLE LOOTS:");
            console.log(gamedatas.table_loots);

            console.log("PLAYER LOOTS:");
            console.log(gamedatas.player_loots);

            console.log("ALL LOOTS:");
            console.log(gamedatas.loots);

            console.log("===================");

            this.cardInfo   = gamedatas.card_info;
            this.deck       = gamedatas.deck;
            this.marketPile = gamedatas.market;
            this.diceState  = gamedatas.dice_state;

            this.translatableTexts = {
                'cancel'                        : _('Cancel'),
                'confirm'                       : _('Confirm'),
                'confirmSelectionButton'        : _('Confirm Selection'),
                'endTurnButton'                 : _('End Turn'),
            }

            /*
             * Create Cards for Market
             */

            //  Loop through each market
            for (var i in this.marketInfo) {
                var market = this.marketInfo[i].type;
                
                this.cards[market] = new ebg.stock();
                this.cards[market].create(this, $('market_cards_' + market.toLowerCase()), this.cardWidth, this.cardHeight);
                this.cards[market].image_items_per_row = this.cardByRow;
                this.cards[market].setSelectionMode(0);
                this.cards[market].item_margin = 10;
                this.cards[market].onItemCreate = dojo.hitch( this, 'addCardDetails' );

                // dojo.connect( this.cards[market], 'onChangeSelection', this, 'onPlayerPurchaseCard' );

                // Init cards for market
                // Add the respective market(A,B,C) cards to the stock
                for (var id in this.cardInfo) {
                    var card_market = this.cardInfo[id].market;
                    if (card_market === market) {
                        this.cards[card_market].addItemType(id, 0, g_gamethemeurl + 'img/tm_deck_blank.jpg', this.cardInfo[id].position);
                    }
                }

                // Show the cards in the market pile according to gamedatas
                if (this.marketPile.hasOwnProperty(market)) {
                    for (var card_generated_id in this.marketPile[market]) {
                        var id = this.marketPile[market][card_generated_id].type_arg;

                        // This is the dealt cards in each Market
                        this.cards[market].addToStockWithId(id, card_generated_id);
                    }
                }

                // Number of cards in deck
                if (gamedatas.count_cards.hasOwnProperty('deck_' + market.toLowerCase())) {
                    dojo.place(this.format_block('jstpl_card_left', {
                        'market'    : market.toLowerCase(),
                        'nbr'       : gamedatas.count_cards['deck_' + market.toLowerCase()]
                    }), 'drawpile_' + market.toLowerCase());

                    dojo.removeClass('deck_' + market.toLowerCase(), 'empty_deck');
                } else {
                    dojo.place(this.format_block('jstpl_card_left', {
                        'market'    : market.toLowerCase(),
                        'nbr'       : 0
                    }), 'drawpile_' + market.toLowerCase());

                    dojo.addClass('deck_' + market.toLowerCase(), 'empty_deck');
                }

                if (gamedatas.count_cards.hasOwnProperty('market_' + market.toLowerCase())) {
                    dojo.removeClass('deck_' + market.toLowerCase(), 'empty_row');
                } else {
                    dojo.addClass('deck_' + market.toLowerCase(), 'empty_row');
                }
            }

            /*
             * Create Loot
             */
            // lootLocation is all the different location that loots will be displayed
            this.lootLocation.push(0); // We used 0 to represent the "Center" pool location

            // The remaining location are for each players
            for (var player_id in gamedatas.players) {
                this.lootLocation.push(player_id);
            }

            // This is for each of the location in "Splitting the Loot" phase
			// Create the stock locations
            for (var i in this.lootLocation) {
                var location = this.lootLocation[i];
				this.tableLoot[location]=this.createLootStock( $('loot_box_' + location));
				this.addAllStockItems(this.tableLoot[location],gamedatas.loots);
                

                

                // Show the loots in each location based on gamedatas				
                for (var j in gamedatas.table_loots) {
                    if (location == gamedatas.loots[j].location_arg) {
                        var id = gamedatas.loots[j].id;
						var type=gamedatas.loots[j].type_arg;
						if(type==99){type=8;}
                        this.tableLoot[location].addToStockWithId(type, id);
                    }
                }
            }
            
            // Setting up player boards
            for( var player_id in gamedatas.players )
            {
                var player = gamedatas.players[player_id];

                /*
                * Create Cards for Player
                */
                this.playerHand[player_id] = new ebg.stock();
                this.playerHand[player_id].create(this, $('player_cards_' + player_id), this.cardWidth, this.cardHeight);
                this.playerHand[player_id].image_items_per_row = this.cardByRow;
                this.playerHand[player_id].setSelectionMode(1);
                this.playerHand[player_id].item_margin = 10;
                this.playerHand[player_id].onItemCreate = dojo.hitch( this, 'addCardDetails' );

                // Add all possible cards to the stock
                for (var id in this.cardInfo) {
                    this.playerHand[player_id].addItemType(id, 0, g_gamethemeurl + 'img/tm_deck_blank.jpg', this.cardInfo[id].position);
                }

                // Add cards to player hand according to gamedatas
                for (var card_generated_id in gamedatas.player_cards[player_id]) {
                    var id = gamedatas.player_cards[player_id][card_generated_id].type_arg;
                    this.playerHand[player_id].addToStockWithId(id, card_generated_id);
                }

                /*
                * Create Loots for Player
                */
                this.playerLoot[player_id] = this.createLootStock($('player_loot_box_' + player_id));
                this.addAllStockItems(this.playerLoot[player_id], gamedatas.loots);


                // Add loots to player hand according to gamedatas
                if (gamedatas.player_loots.hasOwnProperty(player_id)) {
                    for (var i in gamedatas.player_loots[player_id]) {
                        var id = gamedatas.player_loots[player_id][i].id;
						var type=gamedatas.player_loots[player_id][i].type_arg;
						if(type==99){type=8;}
                        this.playerLoot[player_id].addToStockWithId(type, id);
                    }
                }
            }


            // Setup game notifications to handle (see "setupNotifications" method below)
            this.setupNotifications();

            console.log( "Ending game setup" );
        },


        ///////////////////////////////////////////////////
        //// Game & client states
        
        // onEnteringState: this method is called each time we are entering into a new game state.
        //                  You can use this method to perform some user interface changes at this moment.
        //
        onEnteringState: function( stateName, args )
        {
            console.log( 'Entering state: ' + stateName );
            console.log(args);
            console.log('Current Active Player: ' + this.isCurrentPlayerActive());
            
            switch( stateName )
            {
                case 'playerSplitLoot':
                    dojo.query("#thiefmarket_game").addClass('phase_1');
                    dojo.query("#thiefmarket_game").removeClass('phase_2');;
                    if (this.isCurrentPlayerActive()) {
                        console.log('Table Loot: ');
                        console.log(this.tableLoot);
                        for (var location in this.tableLoot) {
                            this.tableLoot[location].setSelectionMode(2);
                            dojo.connect( this.tableLoot[location], 'onChangeSelection', this, 'onPlayerSelectLoot' );
                        }
                    }
                    break;
                case 'playerMakePurchases':
					dojo.query("#thiefmarket_game").removeClass('phase_1');
                    dojo.query("#thiefmarket_game").addClass('phase_2');;
					if (this.isCurrentPlayerActive()) {		
					}
            }
			
        },

        // onLeavingState: this method is called each time we are leaving a game state.
        //                 You can use this method to perform some user interface changes at this moment.
        //
        onLeavingState: function( stateName )
        {
            console.log( 'Leaving state: '+stateName );
            
            switch( stateName )
            {
            
            /* Example:
            case 'myGameState':
            
                break;
           */
            case 'dummmy':
                break;
            }               
        }, 

        // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
        //                        action status bar (ie: the HTML links in the status bar).
        //        
        onUpdateActionButtons: function( stateName, args )
        {
            console.log( 'onUpdateActionButtons: '+stateName );
            console.log(args);

            if( this.isCurrentPlayerActive() )
            {            
                switch( stateName )
                {
/*               
                Example:

                case 'myGameState':
                    
                    // Add 3 action buttons in the action status bar:
                    
                    this.addActionButton( 'button_1_id', _('Button 1 label'), 'onMyMethodToCall1' ); 
                    this.addActionButton( 'button_2_id', _('Button 2 label'), 'onMyMethodToCall2' ); 
                    this.addActionButton( 'button_3_id', _('Button 3 label'), 'onMyMethodToCall3' ); 
                    break;
*/
                    case 'playerSplitLoot':
                        this.addActionButton('confirm_take_loot', this.translatableTexts.confirmSelectionButton, 'onConfirmPlayerTakeLoot')
                        break;
					 case 'playerMakePurchases':
						this.addActionButton('pass_market', _('Pass'), 'onPassMarket')
                        break;

                }
            }
        },        

        ///////////////////////////////////////////////////
        //// Utility methods
        
		createLootStock:function(locID)
		{
			var stockElement = new ebg.stock();
			stockElement.create(this,  locID, this.lootSize, this.lootSize);
			stockElement.image_items_per_row = this.lootRow;
			stockElement.setSelectionMode(2);
			stockElement.item_margin = 5;
			stockElement.onItemCreate = dojo.hitch( this, 'addLootDetails' );
			return stockElement;
		},
		
		//Adds loot items to stock
		addAllStockItems:function(stockElement,loots)
		{
			for(var j=0;j<9;j++){
                stockElement.addItemType(j, 0, g_gamethemeurl + 'img/tm_loot.png', j);
				}	
		},
        /*
        
            Here, you can defines some utility methods that you can use everywhere in your javascript
            script.
        
        */

        // /** @Override */
        // format_string_recursive : function(log, args) {
        //     try {
        //         if (log && args && !args.processed) {
        //             args.processed = true;
        //             if (!this.isSpectator)
        //                 args.You = this.divYou(); // will replace ${You} with colored version
        //             var keys = [ 'ressources', 'side_type', 'old_side_type', 'sides_types', 'sides_rolled', 'gold', 'vp', 'moonshard', 'fireshard', 'ancientshard', 'loyalty' ];
        //             for ( var i in keys) {
        //                 var key = keys[i];
        //                 if (typeof args[key] == 'string') {
        //                     var res = this.getIcons(key, args);
        //                     if (res) args[key] = res;
        //                 }
        //             }
                    
        //             if (args.hasOwnProperty('ousted_player_name')) {
        //                 args['ousted_player_name'] = '<span style="font-weight:bold;color:#' + args['ousted_player'] + '">' + args['ousted_player_name'] + '</span>';
        //             }
        //         }
        //     } catch (e) {
        //         console.error(log, args, "Exception thrown", e.stack);
        //     }
        //     return this.inherited(arguments);
        // },

        // getIcons : function(key, args) {
        //     switch (key) {
        //         case 'ressources':
        //         case 'gold':
        //         case 'vp':
        //         case 'moonshard':
        //         case 'fireshard':
        //         case 'ancientshard':
        //         case 'loyalty':
        //             args[key] = this.ressourcesTextToIcon( args[key] );
        //             break;
        //         case 'old_side_type':
        //         case 'side_type':
        //             args[key] = this.getSideIcon( args[key] );
        //         break;
        //         case 'sides_types':
        //             var sides  = args[key].split(", ");
        //             for (var i in sides)
        //             {
        //                 var side = sides[i];

        //                 sides[i] = this.getSideIcon( side );
        //             }
        //             args[key] = sides.join(", ");
        //             break;
        //         case 'sides_rolled':
        //             var sides  = args[key].split(",");
        //             for (var i in sides)
        //             {
        //                 var side = sides[i];

        //                 sides[i] = this.getSideIcon( side );
        //             }
        //             args[key] = sides.join(" ");    
        //         break;
        //     }
            
        //     return args[key];
        // },

        escapeRegExp: function (str) {
          return str.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // $& means the whole matched string
        },

        // Keyword for loot
        lootTextToIcon: function(text) {
            var loot_icons = {
                '[GREEN]'           : 'green_die',
                '[WHITE]'           : 'white_die',
                '[BLUE]'            : 'blue_die',
                '[RED]'             : 'red_die',
                '[INFAMY]'          : 'infamy_die',
                '[GOLD]'            : 'gold_die',
                '[INFAMY_TOKEN]'    : 'infamy_token',
                '[GOLD_TOKEN]'      : 'gold_token',
                '[FP]'              : 'first_player'
            };

            return this.dataToIcon(loot_icons, 'jstpl_loot_icon', text);
        },

        // Keyword for symbols
        symbolTextToIcon: function(text) {
            var symbols_icons = {
                '[WAND]'            : 'wand',
                '[THIEF]'           : 'thief',
                '[BUILDING]'        : 'building',
                '[TOOLS]'           : 'tools',
                '[COMPASS]'         : 'compass',
                '[WISHLIST]'        : 'wishlist',
                '[VP]'              : 'vp'
            };

            return this.dataToIcon(symbols_icons, 'jstpl_symbol_icon', text);
        },

        // Search for specific keyword and change them to html icon
        dataToIcon: function(data_source, template, text) {
            for (var search in data_source) {
                text = text.replace(
                    new RegExp(this.escapeRegExp(search), 'g'), 
                    this.format_block(template, {
                        'type' : data_source[ search ]
                    })
                );
            }

            return text;
        },

        // Add card details
        //  - class
        //  - name
        //  - tooltip
        addCardDetails: function(card_info, card_id, div_id)
        {
            this.addCardClass(div_id);
            this.addCardName(card_id, div_id);
            this.addCardTooltip(card_id, div_id);
        },

        // Add class to the card
        addCardClass: function(div_id)
        {
            dojo.addClass( dojo.byId(div_id), "card_sprite");
        },

        // Add the card name
        addCardName: function(card_id, div_id)
        {
            var card_data = this.getCardDetails(card_id);
            var count = 0;

            for (var i in card_data.symbols) {
                count += card_data.symbols[i];
            }

            var card_name_el = this.format_block('jstpl_tm_card_name', {
                'symbol_count': count > 1 ? 'double_symbol' : 'single_symbol',
                'card_name': card_data.name,
            });

            dojo.place(card_name_el, dojo.byId(div_id));
        },

        // Add tooltip to the cards
        addCardTooltip: function(card_id, div_id)
        {
            var card_data = this.getCardDetails(card_id);
            this.addTooltipHtml( div_id, this.getCardTooltip( card_data ) );
        },

        // Add details to each loot
        addLootDetails: function(card_info, card_id, div_id)
        {
            this.addLootClass(div_id);
        },

        // Add class to the loot
        addLootClass: function(div_id)
        {
            dojo.addClass( dojo.byId(div_id), "loot");
        },

        // Get card details given the card id and optionally the property
        getCardDetails: function(card_id, property = null) {
            if (property !== null) {
                return this.cardInfo[card_id][property];
            } else {
                return this.cardInfo[card_id];
            }
        },

        // Returns tooltip for the card
        getCardTooltip : function( data ) {
            var symbols = this.cardTooltipSymbols(data);
            var cost    = this.cardTooltipCosts(data);
            var vp      = "VP: " + data.vp + " [VP]";
            
            return this.format_block('jstpl_tooltip_card', {
                'title'         : _(data.name),
                'symbols'       : this.replaceTextWithIcons(symbols),
                'cost'          : this.replaceTextWithIcons(cost),
                'vp'            : this.replaceTextWithIcons(vp),
                'description'   : this.replaceTextWithIcons( _(data.description) )
                // 'cost'        : this.translatableTexts.tooltipCardCost + this.replaceTextWithIcons( cost ),
                // 'vp'          : this.translatableTexts.tooltipCardVP + this.replaceTextWithIcons( vp ),
                // 'description' : this.replaceTextWithIcons( _( data.description ) )
            });
        },

        // format symbols text for the tooltip
        cardTooltipSymbols: function(data) {
            var symbols = "Card Icon: ";

            if (data.symbols['wand']) {
                symbols += '[WAND]';
            }
            if (data.symbols['thief']) {
                symbols += '[THIEF]';
            }
            if (data.symbols['building']) {
                symbols += '[BUILDING]';
            }
            if (data.symbols['tools']) {
                symbols += '[TOOLS]';
            }
            if (data.symbols['compass']) {
                symbols += '[COMPASS]';
            }
            if (data.symbols['wishlist']) {
                symbols += '[WISHLIST]';
            }

            return symbols;
        },

        // format costs text for the tooltip
        cardTooltipCosts: function(data) {
            var cost = "Cost: ";

            if (data.cost['green']) {
                cost += data.cost['green'] + " [GREEN] ";
            }
            if (data.cost['white']) {
                cost += data.cost['white'] + " [WHITE] ";
            }
            if (data.cost['blue']) {
                cost += data.cost['blue'] + " [BLUE] ";
            }
            if (data.cost['red']) {
                cost += data.cost['red'] + " [RED] ";
            }

            return cost;
        },

        // replaces certain keyword (eg. [VP]) to icons
        replaceTextWithIcons: function(text) {
            text = this.lootTextToIcon(text);
            text = this.symbolTextToIcon(text);

            return text;
        },

        buyCard: function(player_id, type, id, location) {
            console.log("PLAYER ID:");
            console.log(player_id);

            console.log("ACTIVE PLAYER ID:");
            console.log(this.getActivePlayerId());

            if (player_id == this.getActivePlayerId()) {
                this.playerHand[player_id].addToStockWithId(type, id);
                this.cards[location].removeFromStockById(id);
            }
        },

        // onPlayerTakeLoot: function(player_id, id, location) {
        //     if (player_id == this.getActivePlayerId()) {
        //         this.tableLoot[player_id].addToStockWithId(id, id);
        //         this.tableLoot[location].removeFromStockById(id);
        //     }
        // },

        // drawMarketCard: function(deck_id, card_id, symbol_count, card_name)
        // {
        //     dojo.place(
        //         this.format_block('jstpl_tm_card', {
        //             deck_id: deck_id,
        //             card_id: card_id,
        //             card_symbol_count: symbol_count,
        //             card_name: card_name
        //         }), 'card_wrapper'
        //     );


        //     this.placeOnObject('deck_'+deck_id, '.dealtcards');
        //     this.slideToObject('deck_'+deck_id, '.dealtcards');
        // },


        ///////////////////////////////////////////////////
        //// Player's action
        
        /*
        
            Here, you are defining methods to handle player's action (ex: results of mouse click on 
            game objects).
            
            Most of the time, these methods:
            _ check the action is possible at this game state.
            _ make a call to the game server
        
        */
        
        /* Example:
        
        onMyMethodToCall1: function( evt )
        {
            console.log( 'onMyMethodToCall1' );
            
            // Preventing default browser reaction
            dojo.stopEvent( evt );

            // Check that this action is possible (see "possibleactions" in states.inc.php)
            if( ! this.checkAction( 'myAction' ) )
            {   return; }

            this.ajaxcall( "/thiefsmarket/thiefsmarket/myAction.html", { 
                                                                    lock: true, 
                                                                    myArgument1: arg1, 
                                                                    myArgument2: arg2,
                                                                    ...
                                                                 }, 
                         this, function( result ) {
                            
                            // What to do after the server call if it succeeded
                            // (most of the time: nothing)
                            
                         }, function( is_error) {

                            // What to do after the server call in anyway (success or failure)
                            // (most of the time: nothing)

                         } );        
        },
        
        */

        onPlayerPurchaseCard: function (evt)
        {
            console.log(evt);
            var location = evt.slice(-1).toUpperCase();
            console.log(location);
            var items;
            if (this.cards.hasOwnProperty(location)) {
                items = this.cards[location].getSelectedItems();   
                console.log(items);
            }
            this.buyCard(this.player_id, items[0].type, items[0].id, location);
        },

        onPlayerSelectLoot: function (evt)
        {
            console.log(evt);
            // dojo.stopEvent(evt);
            var selected_location = evt.split("_").slice(-1);
            console.log(selected_location);
            var items;
            for (var location in this.tableLoot) {
                if (location != selected_location) {
                    this.tableLoot[location].unselectAll();
                }
            }
        },
		onPassMarket:function()
		{
					this.ajaxcall("/thiefsmarket/thiefsmarket/PassMarket.html", {}, this, function( result ) {}, function( is_error ) {} );
			
		},
        onConfirmPlayerTakeLoot: function()
        {
			var itemIDs=new Array();
            var items;
			//Aggragate chosen items
            for (var location in this.tableLoot) {
                if (this.tableLoot[location].getSelectedItems().length > 0) {
                    items = this.tableLoot[location].getSelectedItems();
                }
            }
		    
			for(x in items)
				{itemIDs.push(items[x].id);}
			if(itemIDs.length>0)
			{
				if ( this.isCurrentPlayerActive() ) {
					this.ajaxcall("/thiefsmarket/thiefsmarket/TakeLoot.html", { items:itemIDs.join(",")}, this, function( result ) {}, function( is_error ) {} );
					}

				console.log(items);
			}
			else
				{this.showMessage( "You must select some loot","info");}	
		},

        
        ///////////////////////////////////////////////////
        //// Reaction to cometD notifications

        /*
            setupNotifications:
            
            In this method, you associate each of your game notifications with your local method to handle it.
            
            Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
                  your thiefsmarket.game.php file.
        
        */
        setupNotifications: function()
        {
            console.log( 'notifications subscriptions setup' );
            
            // TODO: here, associate your game notifications with local methods
            
            // Example 1: standard notification handling
            // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
            
            // Example 2: standard notification handling + tell the user interface to wait
            //            during 3 seconds after calling the method in order to let the players
            //            see what is happening in the game.
             dojo.subscribe( 'lootTaken', this, "notif_lootTaken" );
			 dojo.subscribe( 'lootReturnedToPool', this, "notif_lootReturned" );
			 dojo.subscribe( 'startMarketPhase', this, "notif_marketPhase" );


            // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
            // 
        },  
        
        // TODO: from this point and below, you can write your game notifications handling methods
        
        /*
        Example:
        
        notif_cardPlayed: function( notif )
        {
            console.log( 'notif_cardPlayed' );
            console.log( notif );
            
            // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call
            
            // TODO: play the card in the user interface.
        },    
        
        */
		
		//with a couple changes lootTaken and lootReturnedToPool could reuse code.
		notif_lootTaken: function( notif )
		{
			//move the loot to the proper placement
			for(i in notif.args.items)
			{
			  lootID=notif.args.items[i];
			  var type;
			  var location=notif.args.location;
			  loot=this.tableLoot[notif.args.location].items;
			  for(j in loot )
			  { if (loot[j].id==lootID) {type=loot[j].type;}}
			  from="loot_box_"+ location+"_item_"+lootID;
				
			  this.tableLoot[notif.args.player_id].addToStockWithId(type, lootID,from);
			  this.tableLoot[location].removeFromStockById(lootID);
			}
		},
		
		notif_lootReturned: function(notif)
		{
			for(i in notif.args.items)
			{
				type=notif.args.items[i].type_arg;
				debugger;
				var location=notif.args.location;
				if(type==99)
				{type=8}
				id=notif.args.items[i].id;
				//This perhaps can be a shuffle animation
				
				
				if(location!=null)
				{
					from="loot_box_"+ location+"_item_"+id;
					this.tableLoot[0].addToStockWithId(type,id,from);
					this.tableLoot[location].removeFromStockById(id);		
				}
				else {this.tableLoot[0].addToStockWithId(type,id);}
			}
		},
		
		notif_marketPhase: function(notif)
		{			
			for(i in this.tableLoot)
			{
				if(i!=0)
				{
					for(j=0;j<this.tableLoot[i].items.length;j++)
					{
						type=this.tableLoot[i].items[j].type;
						id=this.tableLoot[i].items[j].id;
						this.playerLoot[i].addToStockWithId(type,id);
					}
					this.tableLoot[i].removeAll();
				}
			}
			
		}
		
   });             
});
