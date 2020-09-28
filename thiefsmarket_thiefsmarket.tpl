{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- Thief's Market implementation : © Sayid Hafiz <sayidhafiz@gmail.com>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    thiefsmarket_thiefsmarket.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->

<div id="thiefmarket_game">

    <div id="loot_table" class="whiteblock">
<div id=lootWrapper style="postion:absolute;">
        <div id="loot_pool">
            <div class="loot_title">
                <h3>{LOOT_POOL}</h3>
            </div>
            <div id="available_loots">
                <div id="loot_box_0" class="loot_wrapper">
                </div>
            </div>
        </div>

        <!-- BEGIN player_loot -->
        <div id="player_loot_{PLAYER_ID}" class="{PLAYER_CLASS}" style="{CLEAR}">
            <div class="loot_title" style="color:#{PLAYER_COLOR}">
                <h3>{PLAYER_NAME} {LOOT} <input class="takebutton invisible" id="takebutton{PLAYER_ID}" type=button value="Take"></h3>
            </div>
            <div class="loot_box">
                <div id="loot_box_{PLAYER_ID}" class="loot_wrapper">
				
                </div>
            </div>
        </div>
        <!-- END player_loot -->
    </div>
</div>
    <div id="market">

        <div id="deck_a" class="market_row">
            <div id="drawpile_a" class="drawpile">
                <div id="deck_a_back" class="back card_sprite"></div>
                <!-- <h3>13</h3> -->
            </div>
            <div id="market_cards_a" class="dealtcards">
                <!-- <div class="card_wrapper">
                    <div id="card_a_1" class="front card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="front card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="front card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="front card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="front card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

        <div id="deck_b" class="market_row">
            <div id="drawpile_b" class="drawpile">
                <div id="deck_b_back" class="back card_sprite"></div>
                <!-- <h3>12</h3> -->
            </div>
            <div id="market_cards_b" class="dealtcards">

            </div>
        </div>

        <div id="deck_c" class="market_row">
            <div id="drawpile_c" class="drawpile">
                <div id="deck_c_back" class="back card_sprite"></div>
                <!-- <h3>11</h3> -->
            </div>
            <div id="market_cards_c" class="dealtcards">

            </div>
        </div>

    </div>

    <div id="players_table">
        <!-- BEGIN player -->
        <div id="player_table_{PLAYER_ID}" class="player_hand whiteblock">
            <h3 style="color:#{PLAYER_COLOR}">{PLAYER_NAME}</h3>
            <div class="player_info_wrapper">
                <div class="player_summary">
                    <div class="tracker">
                        <div class="icon_sprite icon_buy_count"></div>
                        1
                    </div>
                    <div class="tracker">
                        <div class="loot_sprite icon_gold"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="loot_sprite icon_infamy"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_thief"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_wishlist"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_wand"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_building"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_compass"></div>
                        0
                    </div>
                    <div class="tracker">
                        <div class="icon_sprite icon_tools"></div>
                        0
                    </div>
                </div>
            </div>
            <div id="player_loots" class="player_loot_box">
                <div id="player_loot_box_{PLAYER_ID}" class="loot_wrapper">
  
                </div>
            </div>
            <div id="player_cards_{PLAYER_ID}" class="player_cards">
                <!-- <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div>
                <div class="card_wrapper">
                    <div id="card_a_1" class="card_sprite">
                        <div class="card_name_wrapper single_symbol">
                            <span class="card_name">Alchemical Lab</span>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- END player -->
    </div>

</div>


<script type="text/javascript">
    // Javascript HTML templates


    var jstpl_tm_card = '<div class="card_wrapper">\
        <div id="card_${market}_${card_id}" class="front card_sprite" style="background-position:-${x}px -${y}px"></div>\
    </div>';

    var jstpl_tm_card_name = '<div class="card_name_wrapper ${symbol_count}">\
        <span class="card_name">${card_name}</span>\
    </div>';

    var jstpl_tm_loot = '<div id="loot_${loot_counter}" \
        class="loot ${is_first_player} ${is_dice} ${loot_class_name}">\
    </div>';

    var jstpl_tm_player_loot = '<div id="player_loot_${loot_counter}" \
        class="loot ${is_first_player} ${is_dice} ${loot_class_name}">\
    </div>';

    var jstpl_card_left = '<h3 class="card_counter" id="card_counter_${market}">${nbr}</h3>';

    var jstpl_symbol_icon = '<div class="symbol symbol_${type}" alt="${type}"></div>';
    var jstpl_loot_icon = '<div class="loot_icon loot_icon_${type}" alt="${type}"></div>';

    var jstpl_tooltip_card = '<div class="tooltip-container">\
		<span class="tooltip-title">${title}</span>\
		<span class="tooltip-message">${symbols}</span>\
		<span class="tooltip-message">${cost}</span>\
		<span class="tooltip-message">${vp}</span>\
		<hr/>\
		<span class="tooltip-message">${description}</span>\
	</div>';


    // This is purely for UX purpose
    //  float the market if screen size is wide enough
    //  so that the loot pool can be beside the market
    // 
    //  This method is used because it only applies to
    //  really wide screen and there is no class applied
    //  for such situation by bga.

    var marketFloat = false;

    var threshold = 1368;

    if (window.innerWidth >= threshold) {
        document.getElementById("market").style.float = 'left';
        marketFloat = true;
    }

    var onresize = function (e) {
        var width = e.target.outerWidth;

        if (width >= threshold && !marketFloat) {
            document.getElementById("market").style.float = 'left';
            marketFloat = true;
        }

        if (width < threshold && marketFloat) {
            document.getElementById("market").style.float = 'none';
            marketFloat = false;
        }
    }
    window.addEventListener("resize", onresize);
</script>

{OVERALL_GAME_FOOTER}