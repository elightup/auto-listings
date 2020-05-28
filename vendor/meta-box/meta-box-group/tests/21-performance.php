<?php
add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = array(
        'title'    => 'Modules',
        'fields' => array(
            array(
                'id'         => 'modules',
                'type'       => 'group',
                'clone'      => true,
                'sort_clone' => true,
                'fields' => array(
                    // TYPE
                    array(
                        'name'        => 'Type',
                        'id'          => 'module_type',
                        'type'        => 'select_advanced',
                        'placeholder' => 'Choisissez un type',
                        'options'     => array(
                            'menu-image'      => 'Menu image',
                            'image-full'      => 'Image largeur',
                            'carousel'        => 'Carrousel',
                            'half-horizontal' => 'Demi horizontal',
                            'pushs'           => 'Visuels pushs',
                            'pushs-offset'    => 'Visuels décalés',
                            'pushs-link'      => 'Pushs avec lien',
                            'introduction'    => 'Introduction',
                            'quote'           => 'Citation',
                            'portraits'       => 'Portraits',
                            'gallery'         => 'Galerie',
                            'paragraphs'      => 'Paragraphes',
                            'separation'      => 'Séparation',
                            'illustration'    => 'Illustration',
                            'pushs-product'   => 'Mise en avant produits',
                        ),
                    ),

                    // IMAGE MAIN SIZE RECOS
                    array(
                        'type' => 'heading',
                        'name' => 'Visuel principal',
                        'desc' => 'Format conseillé : 720 x 928 px.',
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'half-horizontal'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'type' => 'heading',
                        'name' => 'Visuel principal',
                        'desc' => 'Format conseillé : 1440 x 650 px.',
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'illustration'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'type' => 'heading',
                        'name' => 'Visuel principal',
                        'desc' => 'Format conseillé : 1440 x 872 px.',
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'type' => 'heading',
                        'name' => 'Visuel principal',
                        'desc' => 'Format conseillé : 263 x 263 px.',
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'quote'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'type' => 'heading',
                        'name' => 'Visuel principal',
                        'desc' => 'Format conseillé : 644 x 483 px.',
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'paragraphs'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // IMAGE MAIN
                    array(
                        'name'             => 'Ficher visuel',
                        'id'               => 'module_img_main',
                        'type'             => 'image_advanced',
                        'max_file_uploads' => 1,
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'quote'),
                                array('module_type', '=', 'paragraphs'),
                                array('module_type', '=', 'illustration'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // IMG MAIN POSITION
                    array(
                        'name'    => 'Position visuel principal',
                        'id'      => 'module_img_main_position',
                        'type'    => 'radio',
                        'options' => array(
                            'left'  => 'Gauche',
                            'right' => 'Droite',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'paragraphs'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // IMG MAIN DIVIDER
                    array(
                        'id'      => 'divider_1',
                        'type'    => 'divider',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'quote'),
                                array('module_type', '=', 'paragraphs'),
                                array('module_type', '=', 'illustration'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // VIDEO MAIN
                    array(
                        'name'    => 'Vidéo principale',
                        'id'      => 'module_video_main',
                        'type'    => 'url',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'paragraphs'),
                                array('module_type', '=', 'illustration'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'name'    => 'Titre de la vidéo',
                        'id'      => 'module_video_main_title',
                        'type'    => 'text',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'paragraphs'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    array(
                        'name'    => 'Sous-titre de la vidéo',
                        'id'      => 'module_video_main_subtitle',
                        'type'    => 'text',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'paragraphs'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // ID CULINARIUM
                    array(
                        'name'    => 'Bloc ID Culinarium',
                        'id'      => 'module_id_culinarium',
                        'type'    => 'switch',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // TITLE TEXT
                    array(
                        'name'    => 'Titre (texte)',
                        'id'      => 'module_title_text',
                        'type'    => 'wysiwyg',
                        'options' => array(
                            'media_buttons' => false,
                            'wpautop'       => false,
                            'textarea_rows' => '5',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                                array('module_type', '=', 'introduction'),
                                array('module_type', '=', 'separation'),
                                array('module_type', '=', 'pushs-product'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // TITLE IMAGE
                    array(
                        'name'             => 'Titre (image)',
                        'id'               => 'module_title_img',
                        'type'             => 'image_advanced',
                        'max_file_uploads' => 1,
                        'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 470 x 294 px maximum.'),
                        'visible'          => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                                array('module_type', '=', 'introduction'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // DESCRIPTION
                    array(
                        'name'    => 'Description',
                        'id'      => 'module_desc',
                        'type'    => 'wysiwyg',
                        'options' => array(
                            'media_buttons' => false,
                            'wpautop'       => false,
                            'textarea_rows' => '10',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                                array('module_type', '=', 'introduction'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // GROUPE DESCRIPTIONS MULTIPLES
                    array(
                        'name'       => 'Blocs description',
                        'id'         => 'module_desc_multiple',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'fields'     => array(

                            array(
                                'name'    => 'Titre',
                                'id'      => 'module_desc_multiple_subtitle',
                                'type'    => 'wysiwyg',
                                'raw'     => false,
                                'options' => array(
                                    'textarea_rows' => 5,
                                    'media_buttons' => false,
                                    'wpautop'       => false
                                )
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_desc_multiple_text',
                                'type'    => 'wysiwyg',
                                'raw'     => false,
                                'options' => array(
                                    'textarea_rows' => 5,
                                    'media_buttons' => false,
                                    'wpautop'       => false
                                )
                            ),
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'pushs-product'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_LABEL
                    array(
                        'name'    => 'Libellé CTA',
                        'id'      => 'module_link_label',
                        'type'    => 'text',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_URL_EXT
                    array(
                        'name'    => 'CTA lien externe',
                        'id'      => 'module_link_url_ext',
                        'type'    => 'url',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_URL_INT
                    array(
                        'name'       => 'CTA lien interne',
                        'id'         => 'module_link_url_int',
                        'type'       => 'post',
                        'post_type'  => array('post', 'page', 'product', 'recipe', 'masterclass', 'technical-move', 'trend', 'advisor', 'chef', 'event', 'recipe-booklet', 'white-paper', 'contest', 'contest-ce2'),
                        'field_type' => 'select_advanced',
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_URL_INT_CUSTOM
                    array(
                        'name'    => 'CTA lien interne personnalisé',
                        'id'      => 'module_link_url_int_custom',
                        'type'    => 'url',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'pushs'),
                                array('module_type', '=', 'pushs-offset'),
                                array('module_type', '=', 'pushs-link'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_PDF
                    array(
                        'name'    => 'CTA lien PDF',
                        'id'      => 'module_link_pdf',
                        'type'    => 'file_advanced',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'half-horizontal'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // LINK_COLOR
                    array(
                        'name'    => 'CTA Couleur',
                        'id'      => 'module_link_color',
                        'type'    => 'radio',
                        'options' => array(
                            'bg_gold'  => 'Typo blanche / fond doré',
                            'bg_white' => 'Typo dorée / fond blanc',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // COLOR HIGHLIGHT
                    array(
                        'name'       => 'Couleur de soutien',
                        'id'         => 'module_color_highlight',
                        'type'       => 'post',
                        'post_type'  => array('color'),
                        'field_type' => 'select_advanced',
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'separation'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // COLOR BG
                    array(
                        'name'    => 'Couleur de fond',
                        'id'      => 'module_color_bg',
                        'type'    => 'radio',
                        'options' => array(
                            'white' => 'Blanc',
                            'sand'  => 'Sable',
                        ),
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'half-horizontal'),
                                array('module_type', '=', 'introduction'),
                                array('module_type', '=', 'quote'),
                                array('module_type', '=', 'separation'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // QUOTE TEXT
                    array(
                        'name'    => 'Citation',
                        'id'      => 'module_quote_text',
                        'type'    => 'wysiwyg',
                        'options' => array(
                            'media_buttons' => false,
                            'wpautop'       => false,
                            'textarea_rows' => '5',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'quote'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // QUOTE AUTHOR
                    array(
                        'name'    => 'Auteur',
                        'id'      => 'module_quote_author',
                        'type'    => 'wysiwyg',
                        'options' => array(
                            'media_buttons' => false,
                            'wpautop'       => false,
                            'textarea_rows' => '5',
                        ),
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'quote'),
                            ),
                            'relation' => 'or',
                        ),
                    ),

                    // SLIDES For gallery type
                    array(
                        'name'       => 'Slides',
                        'id'         => 'module_slides',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'gallery'),
                            ),
                        ),

                        'fields' => array(
                            array(
                                'name'             => 'Visuel',
                                'id'               => 'module_slide_img_main',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 800 x 600 px pour le module Carrousel / Libre pour le module Galerie.'),
                            ),
                            array(
                                'name' => 'Vidéo',
                                'id'   => 'module_slide_video_main',
                                'type' => 'url',
                            ),
                            array(
                                'name' => 'Crédit ou Créateur',
                                'id'   => 'module_slide_credit',
                                'type' => 'text',
                            ),
                            array(
                                'name'    => 'Titre (texte)',
                                'id'      => 'module_slide_title_text',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '5',
                                ),
                            ),
                            array(
                                'name'             => 'Titre (image)',
                                'id'               => 'module_slide_title_img',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 300 px de hauteur pour le module Carrousel / 75 x 75 px pour le module Galerie.'),
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_slide_desc',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                )
                            ),
                        )
                    ),

                    // SLIDES For carousel type
                    array(
                        'name'       => 'Défilement automatique',
                        'id'         => 'module_auto_slide',
                        'type'       => 'checkbox',
                        'clone'      => false,
                        'sort_clone' => false,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'carousel'),
                            ),
                        ),
                    ),

                    array(
                        'name'       => 'Slides',
                        'id'         => 'module_slides_carousel',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'carousel'),
                            ),
                        ),

                        'fields' => array(
                            array(
                                'name'             => 'Visuel',
                                'id'               => 'module_slide_img_main_carousel',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 800 x 600 px pour le module Carrousel / Libre pour le module Galerie.'),
                            ),
                            array(
                                'name' => 'Vidéo',
                                'id'   => 'module_slide_video_main_carousel',
                                'type' => 'url',
                            ),
                            array(
                                'name' => 'Crédit ou Créateur',
                                'id'   => 'module_slide_credit',
                                'type' => 'text',
                            ),
                            array(
                                'name'    => 'Titre (texte)',
                                'id'      => 'module_slide_title_text_carousel',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '5',
                                ),
                            ),
                            array(
                                'name'             => 'Titre (image)',
                                'id'               => 'module_slide_title_img_carousel',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 300 px de hauteur pour le module Carrousel / 75 x 75 px pour le module Galerie.'),
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_slide_desc_carousel',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                )
                            ),
                            array(
                                'name'    => 'Légende',
                                'id'      => 'module_slide_legend',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '5',
                                ),
                            ),
                            array(
                                'name'    => 'Bloc ID Culinarium',
                                'id'      => 'module_slide_id_culinarium',
                                'type'    => 'switch'
                            ),
                            array(
                                'name'    => 'Libellé CTA',
                                'id'      => 'module_slide_link_label',
                                'type'    => 'text',
                            ),
                            array(
                                'name'    => 'CTA lien externe',
                                'id'      => 'module_slide_link_url_ext',
                                'type'    => 'url',
                            ),
                            array(
                                'name'       => 'CTA lien interne',
                                'id'         => 'module_slide_link_url_int',
                                'type'       => 'post',
                                'post_type'  => array('post', 'page', 'product', 'recipe'),
                                'field_type' => 'select_advanced',
                            ),
                            array(
                                'name'    => 'CTA lien interne personnalisé',
                                'id'      => 'module_slide_link_url_int_custom',
                                'type'    => 'url',
                            ),
                            array(
                                'name'    => 'CTA lien PDF',
                                'id'      => 'module_slide_link_pdf',
                                'type'    => 'file_advanced',
                            ),
                            array(
                                'name'             => 'Visuel premier plan',
                                'id'               => 'module_slide_img_front',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 550 x 661 px.'),
                            ),
                        )
                    ),

                    // PUSHS for pushs-product type
                    array(
                        'name'       => 'Pushs',
                        'id'         => 'module_pushs_product',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'pushs-product')
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'name'       => 'Produit (uniq. mise en avant produits)',
                                'id'         => 'module_push_product',
                                'type'       => 'post',
                                'post_type'  => array('product'),
                                'field_type' => 'select_advanced',
                            ),
                        )
                    ),

                    // PUSHS for pushs-link type
                    array(
                        'name'       => 'Pushs',
                        'id'         => 'module_pushs_link',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'pushs-link')
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'name'             => 'Visuel',
                                'id'               => 'module_push_img_main_pushs_link',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 411 x 304 px pour le module Pushs avec liens / 556 x 416 px pour les autres modules.'),
                            ),
                            array(
                                'name'  => 'Vidéo',
                                'id'    => 'module_push_video_main_pushs_link',
                                'type'  => 'url',
                            ),
                            array(
                                'name'    => 'Titre',
                                'id'      => 'module_push_title_text',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '5',
                                ),
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_push_desc',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                ),
                            ),
                            array(
                                'name'   => 'Créateur',
                                'id'     => 'module_push_author_pushs_link',
                                'type'   => 'text',
                            ),
                            array(
                                'name'             => 'Logo',
                                'id'               => 'module_push_logo_pushs_link',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                            ),
                            array(
                                'name'   => 'CTA lien externe',
                                'id'     => 'module_push_link_pushs_link_url_ext',
                                'type'   => 'url'
                            ),
                            array(
                                'name'       => 'CTA lien interne',
                                'id'         => 'module_push_link_pushs_link_url_int',
                                'type'       => 'post',
                                'post_type'  => array('post', 'page', 'product', 'recipe', 'recipe-booklet', 'expertise', 'technical-term', 'technical-move', 'video', 'chef', 'trend', 'event', 'advisor', 'partner', 'white-paper', 'contest', 'contest-ce2'),
                                'field_type' => 'select_advanced',
                            ),
                            array(
                                'name'   => 'CTA lien interne personnalisé',
                                'id'     => 'module_push_link_pushs_link_url_int_custom',
                                'type'   => 'url',
                            ),
                            array(
                                'name'    => 'CTA lien PDF',
                                'id'      => 'module_push_link_pdf',
                                'type'    => 'file_advanced',
                            ),
                        )
                    ),

                    // PUSHS for pushs-offset type
                    array(
                        'name'       => 'Pushs',
                        'id'         => 'module_pushs_offset',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'pushs-offset')
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'name'             => 'Visuel',
                                'id'               => 'module_push_img_main_pushs_offset',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 411 x 304 px pour le module Pushs avec liens / 556 x 416 px pour les autres modules.'),
                            ),
                            array(
                                'name'  => 'Vidéo',
                                'id'    => 'module_push_video_main_pushs_offset',
                                'type'  => 'url',
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_push_desc_pushs_offset',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                ),
                            ),
                            array(
                                'name'   => 'Créateur',
                                'id'     => 'module_push_author_pushs_offset',
                                'type'   => 'text',
                            ),
                            array(
                                'name'             => 'Logo',
                                'id'               => 'module_push_logo_pushs_offset',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                            ),
                            array(
                                'name'   => 'CTA lien externe',
                                'id'     => 'module_push_link_pushs_offset_url_ext',
                                'type'   => 'url'
                            ),
                            array(
                                'name'       => 'CTA lien interne',
                                'id'         => 'module_push_link_pushs_offset_url_int',
                                'type'       => 'post',
                                'post_type'  => array('post', 'page', 'product', 'recipe', 'recipe-booklet', 'expertise', 'technical-term', 'technical-move', 'video', 'chef', 'trend', 'event', 'advisor', 'partner', 'white-paper', 'contest', 'contest-ce2'),
                                'field_type' => 'select_advanced',
                            ),
                            array(
                                'name'   => 'CTA lien interne personnalisé',
                                'id'     => 'module_push_link_pushs_offset_url_int_custom',
                                'type'   => 'url',
                            ),
                        )
                    ),

                    // PUSHS for push type
                    array(
                        'name'       => 'Pushs',
                        'id'         => 'module_pushs',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'pushs')
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'name'             => 'Visuel',
                                'id'               => 'module_push_img_main',
                                'type'             => 'image_advanced',
                                // 'class'            => 'warning-red',
                                'max_file_uploads' => 1,
                                'tooltip'          => array('icon' => 'info', 'position' => 'right', 'content' => 'Format conseillé : 411 x 304 px pour le module Pushs avec liens / 556 x 416 px pour les autres modules.'),
                            ),
                            array(
                                'name'  => 'Vidéo',
                                'id'    => 'module_push_video_main',
                                'type'  => 'url',
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_push_desc_pushs',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                ),
                            ),
                            array(
                                'name'   => 'Créateur',
                                'id'     => 'module_push_author',
                                'type'   => 'text',
                            ),
                            array(
                                'name'             => 'Logo',
                                'id'               => 'module_push_logo',
                                'type'             => 'image_advanced',
                                'max_file_uploads' => 1,
                            ),
                            array(
                                'name'   => 'CTA lien externe',
                                'id'     => 'module_push_link_url_ext',
                                'type'   => 'url'
                            ),
                            array(
                                'name'       => 'CTA lien interne',
                                'id'         => 'module_push_link_url_int',
                                'type'       => 'post',
                                'post_type'  => array('post', 'page', 'product', 'recipe', 'recipe-booklet', 'expertise', 'technical-term', 'technical-move', 'video', 'chef', 'trend', 'event', 'advisor', 'partner', 'white-paper', 'contest', 'contest-ce2'),
                                'field_type' => 'select_advanced',
                            ),
                            array(
                                'name'   => 'CTA lien interne personnalisé',
                                'id'     => 'module_push_link_url_int_custom',
                                'type'   => 'url',
                            ),
                        )
                    ),

                    // PORTRAITS
                    array(
                        'name'       => 'Chefs',
                        'id'         => 'module_portraits',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'portraits'),
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'id'         => 'module_portrait_chef',
                                'type'       => 'post',
                                'post_type'  => array('chef'),
                                'field_type' => 'select_advanced'
                            ),
                        )
                    ),

                    // PARAGRAPHS
                    array(
                        'name'       => 'Paragraphes',
                        'id'         => 'module_paragraphs',
                        'type'       => 'group',
                        'clone'      => true,
                        'sort_clone' => true,
                        'visible'    => array(
                            'when' => array(
                                array('module_type', '=', 'paragraphs'),
                            ),
                            'relation' => 'or',
                        ),

                        'fields' => array(
                            array(
                                'name'    => 'Titre (texte)',
                                'id'      => 'module_paragraph_title_text',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '5',
                                )
                            ),
                            array(
                                'name'    => 'Description',
                                'id'      => 'module_paragraph_desc',
                                'type'    => 'wysiwyg',
                                'options' => array(
                                    'media_buttons' => false,
                                    'wpautop'       => false,
                                    'textarea_rows' => '10',
                                )
                            )
                        )
                    ),

                    // BOTTOM LINE
                    array(
                        'name'    => 'Liseret doré',
                        'id'      => 'module_bottom_line',
                        'type'    => 'switch',
                        'visible' => array(
                            'when' => array(
                                array('module_type', '=', 'menu-image'),
                                array('module_type', '=', 'image-full'),
                                array('module_type', '=', 'illustration'),
                            ),
                            'relation' => 'or',
                        ),
                    ),
                )
            )
        )
    );
    return $meta_boxes;
} );