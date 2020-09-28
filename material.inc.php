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
 * material.inc.php
 *
 * Thief's Market game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */


/*

Example:

$this->card_types = array(
    1 => array( "card_name" => ...,
                ...
              )
);

*/

// Total no. of cards in the market
$this->markets = array(
  "A" => 13, 
  "B" => 12, 
  "C" => 11
);

// Dice state
$this->dice_state = array(
  0 => 'green',
  1 => 'white',
  2 => 'blue',
  3 => 'red',
  4 => 'yellow',
  5 => 'infamy'
);

// All cards information
//  ID: ID used to identify this card
//  Name: Name of the card
//  Market: Market type (A/B/C)
//  VP: Number of victory points
//  Position: Position of the card in the sprite
//  Cost: Cost of the card to purchase
//  Symbols: The card symbols
//  ActionType: The type of actions, used to determine which phase card can/will activate
//  Action: The specific action of the card
//  Is_promo: Whether the card is a promo card or not
//  Description: Card description used for tooltip

$this->deck = array(
  array(
    "id"            => 0,
    "name"          => clienttranslate("Alchemical Lab"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 0,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 0, "red" => 2),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_red_gem",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [RED] dice from your pile to the [WHITE]/ [BLUE]/ [GREEN] side."),
  ),
  array(
    "id"            => 1,
    "name"          => clienttranslate("Bondsman"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 1,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 0, "red" => 2),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_red_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [RED] dice from your pile to the [GOLD] side."),
  ),
  array(
    "id"            => 2,
    "name"          => clienttranslate("Coercion Coordinator"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 2,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_blue_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may spend 1 [BLUE] dice from your pile to gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 3,
    "name"          => clienttranslate("Corrupt Official"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 3,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "increase_buy_white",
    "is_promo"      => false,
    "description"   => clienttranslate("You can purchase an additional card from the market if your loot pile contains 1 or more [WHITE] dice at the end of the 'Splitting the Loot' phase. This may be used at the same turn you purchased this card, if applicable. You must still pay any costs as normal when purchasing additional card."),
  ),
  array(
    "id"            => 4,
    "name"          => clienttranslate("Disgruntled Minion"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 4,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "increase_buy_red",
    "is_promo"      => false,
    "description"   => clienttranslate("You can purchase an additional card from the market if your loot pile contains 1 or more [RED] dice at the end of the 'Splitting the Loot' phase. This may be used at the same turn you purchased this card, if applicable. You must still pay any costs as normal when purchasing additional card."),
  ),
  array(
    "id"            => 5,
    "name"          => clienttranslate("Fence"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 5,
    "cost"          => array("green" => 0, "white" => 2, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_white_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [WHITE] dice from your pile to the [GOLD] side."),
  ),
  array(
    "id"            => 6,
    "name"          => clienttranslate("Glamer"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 6,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 2, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_blue_gem",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [BLUE] dice from your pile to the [WHITE] / [GREEN] / [RED] side."),
  ),
  array(
    "id"            => 7,
    "name"          => clienttranslate("Guy In a Trenchcoat"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 7,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "increase_buy_blue",
    "is_promo"      => false,
    "description"   => clienttranslate("You can purchase an additional card from the market if your loot pile contains 1 or more [BLUE] dice at the end of the 'Splitting the Loot' phase. This may be used at the same turn you purchased this card, if applicable. You must still pay any costs as normal when purchasing additional card."),
  ),
  array(
    "id"            => 8,
    "name"          => clienttranslate("Local Celebrity"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 8,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_white_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may spend 1 [WHITE] dice from your pile to gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 9,
    "name"          => clienttranslate("Nearby Safehouse"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 9,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 1, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "building_1_2",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, if you have 1 card with the [BUILDING] icon (next to the card name), this card is worth 1 [VP]. If you have 2 or more cards with the [BUILDING] icon, this card is worth 2 [VP]."),
  ),
  array(
    "id"            => 10,
    "name"          => clienttranslate("Necklace"),
    "market"        => "A",
    "vp"            => 2,
    "position"      => 10,
    "cost"          => array("green" => 0, "white" => 2, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 2 [VP]."),
  ),
  array(
    "id"            => 11,
    "name"          => clienttranslate("Pawnbroker"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 11,
    "cost"          => array("green" => 2, "white" => 0, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_green_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [GREEN] dice from your pile to the [GOLD] side."),
  ),
  array(
    "id"            => 12,
    "name"          => clienttranslate("Philosopher's Stone"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 12,
    "cost"          => array("green" => 2, "white" => 0, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_green_gem",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [GREEN] dice from your pile to the [WHITE] / [BLUE] / [RED] side."),
  ),
  array(
    "id"            => 13,
    "name"          => clienttranslate("Public Relations Expert"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 13,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_green_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may spend 1 [GREEN] dice from your pile to gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 14,
    "name"          => clienttranslate("Shadowy Hood"),
    "market"        => "A",
    "vp"            => 2,
    "position"      => 14,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 2, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 2 [VP]"),
  ),
  array(
    "id"            => 15,
    "name"          => clienttranslate("Tailor"),
    "market"        => "A",
    "vp"            => 0,
    "position"      => 15,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_red_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may spend 1 [RED] dice from your pile to gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 16,
    "name"          => clienttranslate("Anthropomorphic Water Buffalo"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 16,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 0, "red" => 2),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_infamy_red",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you purchase any card with a [RED] gem (including this card) in the cost, you gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 17,
    "name"          => clienttranslate("Bookie"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 17,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_blue_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [BLUE] dice from your pile to the [GOLD] side."),
  ),
  array(
    "id"            => 18,
    "name"          => clienttranslate("Brooch"),
    "market"        => "B",
    "vp"            => 3,
    "position"      => 18,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 3 [VP]."),
  ),
  array(
    "id"            => 19,
    "name"          => clienttranslate("Concealed Safehouse"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 19,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 1, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "building_2_4",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, if you have 1 card with the [BUILDING] icon (next to the card name), this card is worth 2 [VP]. If you have 2 or more cards with the [BUILDING] icon, this card is worth 4 [VP]."),
  ),
  array(
    "id"            => 20,
    "name"          => clienttranslate("Deceptive Bits of Colored Glass"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 20,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_white_gem",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [WHITE] dice from your pile to the [GREEN] / [BLUE] / [RED] side."),
  ),
  array(
    "id"            => 21,
    "name"          => clienttranslate("Easily Impressed Noble"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 21,
    "cost"          => array("green" => 1, "white" => 2, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_infamy_white",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you purchase any card with a [WHITE] gem (including this card) in the cost, you gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 22,
    "name"          => clienttranslate("Executive Assistant"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 22,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 2, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "increase_buy_green",
    "is_promo"      => false,
    "description"   => clienttranslate("You can purchase an additional card from the market if your loot pile contains 1 or more green gem dice at the end of the 'Splitting the Loot' phase. This may be used at the same turn you purchased this card, if applicable. You must still pay any costs as normal when purchasing additional card."),
  ),
  array(
    "id"            => 23,
    "name"          => clienttranslate("Eyepatch of Command"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 23,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_infamy_firstplayer",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 1 [INFAMY_TOKEN] token if you have the [FP] marker at the end of every ‘Splitting the Loot’ phase."),
  ),
  array(
    "id"            => 24,
    "name"          => clienttranslate("Fortified Safehouse"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 24,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 1, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "building_2_4",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, if you have 1 card with the [BUILDING] icon (next to the card name), this card is worth 2 [VP]. If you have 2 or more cards with the [BUILDING] icon, this card is worth 4 [VP]."),
  ),
  array(
    "id"            => 25,
    "name"          => clienttranslate("Gauntlet of Evil Intent"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 25,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_infamy_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may spend 1 [INFAMY] dice from your pile to gain 1 [GOLD_TOKEN] token."),
  ),
  array(
    "id"            => 26,
    "name"          => clienttranslate("Imbalanced Scales"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 26,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_extra_gold",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you turn in 1 or more of your [GOLD] dice for [GOLD_TOKEN] token(s), you gain an additional 1 [GOLD_TOKEN] token. ONLY 1 additional token is gained regardless of how many dice were used."),
  ),
  array(
    "id"            => 27,
    "name"          => clienttranslate("Legitimate Jeweller"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 27,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "activation",
    "action"        => "convert_gold_gem",
    "is_promo"      => false,
    "description"   => clienttranslate("Once per round, you may turn 1 [GOLD] dice from your pile to the [WHITE] / [BLUE] / [GREEN] / [RED] side."),
  ),
  array(
    "id"            => 28,
    "name"          => clienttranslate("Lucky Animal Appendage"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 28,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent_opponent",
    "action"        => "stolen_loot_noroll",
    "is_promo"      => false,
    "description"   => clienttranslate("When your loot pile is stolen during the 'Splitting the Loot' phase, do not reroll 1 of the dice that were returned to the Loot Pool. Right before the purchasing phase, you may reroll 1 of the dice in your final loot pile."),
  ),
  array(
    "id"            => 29,
    "name"          => clienttranslate("Menacing Monocle"),
    "market"        => "B",
    "vp"            => 3,
    "position"      => 29,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 3 [VP]"),
  ),
  array(
    "id"            => 30,
    "name"          => clienttranslate("Provisioned Safehouse"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 30,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 1, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "building_2_4",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, if you have 1 card with the [BUILDING] icon (next to the card name), this card is worth 2 [VP]. If you have 2 or more cards with the [BUILDING] icon, this card is worth 4 [VP]."),
  ),
  array(
    "id"            => 31,
    "name"          => clienttranslate("Rumor-Monger"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 31,
    "cost"          => array("green" => 2, "white" => 1, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_infamy_green",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you purchase any card with a [GREEN] gem (including this card) in the cost, you gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 32,
    "name"          => clienttranslate("Sticky-Fingered Dockhand"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 32,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 2, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 1, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent",
    "action"        => "gain_infamy_blue",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you purchase any card with a [BLUE] gem (including this card) in the cost, you gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 33,
    "name"          => clienttranslate("Unlabeled Potion"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 33,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "immediate",
    "action"        => "gain_free_card",
    "is_promo"      => false,
    "description"   => clienttranslate("When you buy this card, immediately discard it and gain the next card that would be dealt from the top of the deck (if possible) at no cost."),
  ),
  array(
    "id"            => 34,
    "name"          => clienttranslate("Wicked Clutches"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 34,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "recurrent_opponent",
    "action"        => "stolen_gain_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("When your loot pile is stolen during the 'Splitting the Loot' phase, you gain 1 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 35,
    "name"          => clienttranslate("Mimetic Stew"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 35,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "immediate_special",
    "action"        => "copy_card",
    "is_promo"      => true,
    "description"   => clienttranslate("When you gain this card, immediately choose an opponent card to copy. The change is permanent."),
  ),
  array(
    "id"            => 36,
    "name"          => clienttranslate("Narrow Alleyway"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 36,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "recurrent",
    "action"        => "gain_5loot_2infamy",
    "is_promo"      => true,
    "description"   => clienttranslate("At the end of the 'Splitting the Loot' phase, if any other player has 5 or more loot in their final pile, gain 2 [INFAMY_TOKEN] token."),
  ),
  array(
    "id"            => 37,
    "name"          => clienttranslate("Wut"),
    "market"        => "B",
    "vp"            => 0,
    "position"      => 37,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 1, "thief" => 1, "building" => 1, "tools" => 1, "compass" => 1, "wishlist" => 1),
    "actionType"    => "",
    "action"        => "",
    "is_promo"      => true,
    "description"   => clienttranslate("No effect."),
  ),
  array(
    "id"            => 38,
    "name"          => clienttranslate("Big Haul"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 38,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "immediate",
    "action"        => "gain_infamy_loot",
    "is_promo"      => false,
    "description"   => clienttranslate("When you gain this card, gain a number of [INFAMY_TOKEN] tokens equal to the number of loots that are in your final loot pile during the 'Splitting the Loot' phase this round."),
  ),
  array(
    "id"            => 39,
    "name"          => clienttranslate("Collecting Golem"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 39,
    "cost"          => array("green" => 0, "white" => 2, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 1, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "wand_infinite2_3",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, this card is worth 3 [VP] for every set of 2 [WAND] icons you have (next to the card name)."),
  ),
  array(
    "id"            => 40,
    "name"          => clienttranslate("Crown"),
    "market"        => "C",
    "vp"            => 6,
    "position"      => 40,
    "cost"          => array("green" => 0, "white" => 1, "blue" => 2, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 6 [VP]"),
  ),
  array(
    "id"            => 41,
    "name"          => clienttranslate("Exit Strategy"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 41,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "activation_infinite",
    "action"        => "convert_gold_2infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("You may exchange 1 [GOLD_TOKEN] token for 2 [INFAMY_TOKEN] tokens. You may do this as many times per turn."),
  ),
  array(
    "id"            => 42,
    "name"          => clienttranslate("Fur Coat"),
    "market"        => "C",
    "vp"            => 4,
    "position"      => 42,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 4 [VP]"),
  ),
  array(
    "id"            => 43,
    "name"          => clienttranslate("Giant Belt Buckle"),
    "market"        => "C",
    "vp"            => 4,
    "position"      => 43,
    "cost"          => array("green" => 0, "white" => 0, "blue" => 0, "red" => 2),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 4 [VP]"),
  ),
  array(
    "id"            => 44,
    "name"          => clienttranslate("Insurance Racket"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 44,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "recurrent",
    "action"        => "increase_buy_cheaper",
    "is_promo"      => false,
    "description"   => clienttranslate("You can purchase an additional card each turn. All of your card purchases cost 1 dice less (of your choice)."),
  ),
  array(
    "id"            => 45,
    "name"          => clienttranslate("Island Estate"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 45,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 0, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "recurrent",
    "action"        => "gain_extra_infamy",
    "is_promo"      => false,
    "description"   => clienttranslate("Whenever you turn in 1 or more of your [INFAMY] dice for [INFAMY_TOKEN] token(s), you gain an additional 1 [INFAMY_TOKEN] token. ONLY 1 additional token is gained regardless of how many dice were used."),
  ),
  array(
    "id"            => 46,
    "name"          => clienttranslate("Loyalty Program"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 46,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "scoring_endgame",
    "action"        => "total_cards_vp",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, this card is worth 1 [VP] for every card you have purchased (not including this card)."),
  ),
  array(
    "id"            => 47,
    "name"          => clienttranslate("Political Campaign"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 47,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "scoring_endgame",
    "action"        => "infamy_infinite_1",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, this card is worth 1 [VP] for every set of 2 [INFAMY_TOKEN] tokens you have."),
  ),
  array(
    "id"            => 48,
    "name"          => clienttranslate("Scepter"),
    "market"        => "C",
    "vp"            => 6,
    "position"      => 48,
    "cost"          => array("green" => 0, "white" => 2, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 1, "compass" => 0, "wishlist" => 0),
    "actionType"    => "scoring_immediate",
    "action"        => "",
    "is_promo"      => false,
    "description"   => clienttranslate("Gain 6 [VP]"),
  ),
  array(
    "id"            => 49,
    "name"          => clienttranslate("The Heist"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 49,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 0, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "immediate",
    "action"        => "gain_infamy_loot",
    "is_promo"      => false,
    "description"   => clienttranslate("When you gain this card, gain a number of [INFAMY_TOKEN] tokens equal to the number of loots that are in your final loot pile during the 'Splitting the Loot' phase this round."),
  ),
  array(
    "id"            => 50,
    "name"          => clienttranslate("Treasure Map"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 50,
    "cost"          => array("green" => 2, "white" => 0, "blue" => 1, "red" => 0),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 1, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "compass_7_5",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, this card is worth 7 [VP] unless if any other player has a card with the [COMPASS] symbol. In which case this card is worth 5 [VP]"),
  ),
  array(
    "id"            => 51,
    "name"          => clienttranslate("Treasure Map"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 51,
    "cost"          => array("green" => 1, "white" => 0, "blue" => 0, "red" => 2),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 1, "wishlist" => 0),
    "actionType"    => "scoring_endgame",
    "action"        => "compass_7_5",
    "is_promo"      => false,
    "description"   => clienttranslate("At the end of the game, this card is worth 7 [VP] unless if any other player has a card with the [COMPASS] symbol. In which case this card is worth 5 [VP]"),
  ),
  array(
    "id"            => 52,
    "name"          => clienttranslate("Purported Curse"),
    "market"        => "C",
    "vp"            => 0,
    "position"      => 52,
    "cost"          => array("green" => 1, "white" => 1, "blue" => 1, "red" => 1),
    "symbols"       => array("wand" => 0, "thief" => 0, "building" => 0, "tools" => 0, "compass" => 0, "wishlist" => 1),
    "actionType"    => "scoring_endgame",
    "action"        => "wand_infinite_1",
    "is_promo"      => true,
    "description"   => clienttranslate("At the end of the game, this card is worth 1 [VP] for every [WAND] icons that other player have."),
  )
);




