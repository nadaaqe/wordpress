<?php

$nav = $this->el('ul', [

    'class' => [
        'el-nav',
        'uk-margin[-{switcher_margin}] {@switcher_position: top|bottom}',
        'uk-{switcher_style: thumbnav} [uk-flex-nowrap {@switcher_thumbnail_nowrap}]',
    ],

    $props['switcher_style'] == 'tab' ? 'uk-tab' : 'uk-switcher' => [
        'connect: #{connect};',
        'animation: uk-animation-{switcher_animation};',
        'media: @{switcher_grid_breakpoint} {@switcher_position: left|right} {@switcher_style: tab};',
    ],

    'uk-margin' => ['1{@switcher_style: thumbnav} {@!switcher_thumbnail_nowrap}'],
]);

$nav_horizontal = [
    'uk-subnav {@switcher_style: subnav-.*}',
    'uk-{switcher_style: subnav.*}',
    'uk-tab-{switcher_position: bottom} {@switcher_style: tab}',
    'uk-flex-{switcher_align: right|center}',
    'uk-child-width-expand {@switcher_align: justify}',
];

$nav_vertical = [
    'uk-nav uk-nav-[primary {@switcher_style_primary}][default {@!switcher_style_primary}] [uk-text-left {@text_align}] {@switcher_style: subnav.*}',
    'uk-tab-{switcher_position} {@switcher_style: tab}',
    'uk-thumbnav-vertical {@switcher_style: thumbnav}',
];

$nav_switcher = in_array($props['switcher_position'], ['top', 'bottom'])
    ? ['class' => $nav_horizontal]
    : ['class' => $nav_vertical,
        'uk-toggle' => $props['switcher_style'] != 'tab' ? [
            "cls: {$this->expr(array_merge($nav_vertical, $nav_horizontal), $props)};",
            'mode: media;',
            'media: @{switcher_grid_breakpoint};',
        ] : false,
    ];

?>

<?= $nav($props, $nav_switcher) ?>
    <?php foreach ($children as $child) :

        // Display
        foreach (['meta', 'content', 'image', 'link', 'label', 'thumbnail'] as $key) {
            if (!$props["show_{$key}"]) { $child->props[$key] = ''; }
        }

        // Image
        $image = $this->el('image', [
            'class' => [
                'uk-text-{switcher_thumbnail_svg_color}' => $props['switcher_thumbnail_svg_inline'] && $props['switcher_thumbnail_svg_color'] && $this->isImage($child->props['thumbnail'] ?: $child->props['image']) == 'svg',
            ],
            'src' => $child->props['thumbnail'] ?: $child->props['image'],
            'alt' => $child->props['label'] ?: $child->props['title'],
            'width' => $props['switcher_thumbnail_width'],
            'height' => $props['switcher_thumbnail_height'],
            'uk-svg' => (bool) $props['switcher_thumbnail_svg_inline'],
            'thumbnail' => true,
        ]);

        $thumbnail = $image->attrs['src'] && $props['switcher_style'] == 'thumbnav' ? $image($props) : '';
    ?>
    <li class="uk-width-1-4@m uk-width-1-2@s uk-width-1-1  " >
          <div class="uk-inline-clip uk-width-1-1 uk-card uk-height-1-1  uk-card-default uk-card-body" href="#">
              <?= $thumbnail ?: $child->props['label'] ?: $child->props['title'] ?> 
             <h3 class="el-title uk-margin-top uk-margin-remove-bottom">  
             <?= $child->props['label'] ?:  $child->props['title'] ?> </h3>
          <div>
    </li>
    <?php endforeach ?>
</ul>
