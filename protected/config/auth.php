<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Manager',
        'children' => array(
            'guest', 
         ),
        'bizRule' => null,
        'data' => null
    ),
    'accountant' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Accountant',
        'children' => array(
            'user',          
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',         
        ),
        'bizRule' => null,
        'data' => null
    ),
);