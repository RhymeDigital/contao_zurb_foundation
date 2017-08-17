<?php

/**
 * Zurb Foundation integration for Contao Open Source CMS
 *
 * Copyright (C) 2017 Rhyme Digital
 *
 * @package    Zurb_Foundation
 * @link       http://rhyme.digital
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */
 
 
$GLOBALS['TL_LANG']['FOUNDATION'] = array
(
    'TABS' => array
	(
		'DIRECTION' => array
		(
			'' 			=> 'Horizontal',
			'vertical'	=> 'Vertical'
		),
	),
    'SCSS' => array
	(
		'BREAKPOINT' => array
		(
			'medium'		=> '640',
			'large'	        => '1024',
			'xlarge'		=> '1200',
			'xxlarge'	    => '1440',
		),
	),
    /**
     * CSS Selector Categories
     */
    'CSS' => array
    (
        'VISIBILITY' => array
        (

            'SHOW'    => array
            (
                'show-for-small',
                'show-for-medium',
                'show-for-large',
                'show-for-xlarge',
                'show-for-xxlarge',
                'show-for-small-only',
                'show-for-medium-only',
                'show-for-large-only',
                'show-for-xlarge-only',
                'show-for-xxlarge-only',
            ),
            'HIDE'    => array
            (
                'hide-for-small',
                'hide-for-medium',
                'hide-for-large',
                'hide-for-xlarge',
                'hide-for-xxlarge',
                'hide-for-small-only',
                'hide-for-medium-only',
                'hide-for-large-only',
                'hide-for-xlarge-only',
                'hide-for-xxlarge-only',
            ),
            'ORIENTATION'    => array
            (
                'show-for-landscape',
                'show-for-portrait',
            ),
            'TOUCH'    => array
            (
                'show-for-touch',
                'hide-for-touch',
            ),
        ),
    ),
    'ICONS' => array
    (
        'address-book',
        'alert',
        'align-center',
        'align-justify',
        'align-left',
        'align-right',
        'anchor',
        'annotate',
        'archive',
        'arrow-down',
        'arrow-left',
        'arrow-right',
        'arrow-up',
        'arrows-compress',
        'arrows-expand',
        'arrows-in',
        'arrows-out',
        'asl',
        'asterisk',
        'at-sign',
        'background-color',
        'battery-empty',
        'battery-full',
        'battery-half',
        'bitcoin-circle',
        'bitcoin',
        'blind',
        'bluetooth',
        'bold',
        'book-bookmark',
        'book',
        'bookmark',
        'braille',
        'burst-new',
        'burst-sale',
        'burst',
        'calendar',
        'camera',
        'check',
        'checkbox',
        'clipboard-notes',
        'clipboard-pencil',
        'clipboard',
        'clock',
        'closed-caption',
        'cloud',
        'comment-minus',
        'comment-quotes',
        'comment-video',
        'comment',
        'comments',
        'compass',
        'contrast',
        'credit-card',
        'crop',
        'crown',
        'css3',
        'database',
        'die-five',
        'die-four',
        'die-one',
        'die-six',
        'die-three',
        'die-two',
        'dislike',
        'dollar-bill',
        'dollar',
        'download',
        'eject',
        'elevator',
        'euro',
        'eye',
        'fast-forward',
        'female-symbol',
        'female',
        'filter',
        'first-aid',
        'flag',
        'folder-add',
        'folder-lock',
        'folder',
        'foot',
        'foundation',
        'graph-bar',
        'graph-horizontal',
        'graph-pie',
        'graph-trend',
        'guide-dog',
        'hearing-aid',
        'heart',
        'home',
        'html5',
        'indent-less',
        'indent-more',
        'info',
        'italic',
        'key',
        'laptop',
        'layout',
        'lightbulb',
        'like',
        'link',
        'list-bullet',
        'list-number',
        'list-thumbnails',
        'list',
        'lock',
        'loop',
        'magnifying-glass',
        'mail',
        'male-female',
        'male-symbol',
        'male',
        'map',
        'marker',
        'megaphone',
        'microphone',
        'minus-circle',
        'minus',
        'mobile-signal',
        'mobile',
        'monitor',
        'mountains',
        'music',
        'next',
        'no-dogs',
        'no-smoking',
        'page-add',
        'page-copy',
        'page-csv',
        'page-delete',
        'page-doc',
        'page-edit',
        'page-export-csv',
        'page-export-doc',
        'page-export-pdf',
        'page-export',
        'page-filled',
        'page-multiple',
        'page-pdf',
        'page-remove',
        'page-search',
        'page',
        'paint-bucket',
        'paperclip',
        'pause',
        'paw',
        'paypal',
        'pencil',
        'photo',
        'play-circle',
        'play-video',
        'play',
        'plus',
        'pound',
        'power',
        'previous',
        'price-tag',
        'pricetag-multiple',
        'print',
        'prohibited',
        'projection-screen',
        'puzzle',
        'quote',
        'record',
        'refresh',
        'results-demographics',
        'results',
        'rewind-ten',
        'rewind',
        'rss',
        'safety-cone',
        'save',
        'share',
        'sheriff-badge',
        'shield',
        'shopping-bag',
        'shopping-cart',
        'shuffle',
        'skull',
        'social-500px',
        'social-adobe',
        'social-amazon',
        'social-android',
        'social-apple',
        'social-behance',
        'social-bing',
        'social-blogger',
        'social-delicious',
        'social-designer-news',
        'social-deviant-art',
        'social-digg',
        'social-dribbble',
        'social-drive',
        'social-dropbox',
        'social-evernote',
        'social-facebook',
        'social-flickr',
        'social-forrst',
        'social-foursquare',
        'social-game-center',
        'social-github',
        'social-google-plus',
        'social-hacker-news',
        'social-hi5',
        'social-instagram',
        'social-joomla',
        'social-lastfm',
        'social-linkedin',
        'social-medium',
        'social-myspace',
        'social-orkut',
        'social-path',
        'social-picasa',
        'social-pinterest',
        'social-rdio',
        'social-reddit',
        'social-skillshare',
        'social-skype',
        'social-smashing-mag',
        'social-snapchat',
        'social-spotify',
        'social-squidoo',
        'social-stack-overflow',
        'social-steam',
        'social-stumbleupon',
        'social-treehouse',
        'social-tumblr',
        'social-twitter',
        'social-vimeo',
        'social-windows',
        'social-xbox',
        'social-yahoo',
        'social-yelp',
        'social-youtube',
        'social-zerply',
        'social-zurb',
        'sound',
        'star',
        'stop',
        'strikethrough',
        'subscript',
        'superscript',
        'tablet-landscape',
        'tablet-portrait',
        'target-two',
        'target',
        'telephone-accessible',
        'telephone',
        'text-color',
        'thumbnails',
        'ticket',
        'torso-business',
        'torso-female',
        'torso',
        'torsos-all-female',
        'torsos-all',
        'torsos-female-male',
        'torsos-male-female',
        'torsos',
        'trash',
        'trees',
        'trophy',
        'underline',
        'universal-access',
        'unlink',
        'unlock',
        'upload-cloud',
        'upload',
        'usb',
        'video',
        'volume-none',
        'volume-strike',
        'volume',
        'web',
        'wheelchair',
        'widget',
        'wrench',
        'x-circle',
        'x',
        'yen',
        'zoom-in',
        'zoom-out',
    ),
);
