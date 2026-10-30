<?php
/**
 * Title: Home Oratorio
 * Slug: sanfilipponeri/home-oratorio
 * Categories: sanfilipponeri
 * Keywords: home, slider, oratorio
 * Description: La homepage dell'Oratorio: slider con News, NG del mese, Newsletter e Cineteatro.
 * Block Types: sanfilipponeri/slider
 * Post Types: page
 *
 * @package WordPress
 * @subpackage San_Filippo_Neri
 */

?>
<!-- wp:sanfilipponeri/slider {"align":"full"} -->
<!-- wp:sanfilipponeri/slide {"label": "News", "kicker": "News", "title": "Qualcosa è <em><span style=\"text-decoration: underline;\">cambiato!</span></em><br>Ecco le ultime novità.", "buttonText": "Vai all'articolo"} -->
<!-- wp:shortcode -->
[display-posts category="News" include_excerpt="true" wrapper="div" include_content="false" posts_per_page="5"]
<!-- /wp:shortcode -->
<!-- /wp:sanfilipponeri/slide -->

<!-- wp:sanfilipponeri/slide {"label": "NG del mese", "kicker": "NG del mese", "title": "Come il Nembro ma <em><span style=\"text-decoration: underline;\">giovane!</span></em><br>Ecco l'ultimo NG.", "buttonText": "Leggilo"} -->
<!-- wp:shortcode -->
[display-posts wrapper="div" category="Nembro Giovane" include_title="true" image_size="large" posts_per_page="1" wrapper_id="ng-wrapper-home"]
<!-- /wp:shortcode -->
<!-- /wp:sanfilipponeri/slide -->

<!-- wp:sanfilipponeri/slide {"label": "Newsletter", "kicker": "Newsletter", "title": "Rimani sempre <em><span style=\"text-decoration: underline;\">aggiornato!</span></em><br>Iscriviti alla newsletter.", "buttonText": "Iscriviti"} -->
<!-- wp:paragraph -->
<p>Non perderti nemmeno un evento di quello che succede in oratorio. Iscriviti subito alla newsletter, è semplicissimo. Basta compilare il form seguente:</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[mc4wp_form id="10554"]
<!-- /wp:shortcode -->

<!-- wp:shortcode -->
[display-posts category="Newsletter" wrapper="div" include_content="true" image_size="large" posts_per_page="1" wrapper_id="newsletter-wrapper-home"]
<!-- /wp:shortcode -->
<!-- /wp:sanfilipponeri/slide -->

<!-- wp:sanfilipponeri/slide {"label": "Cineteatro", "kicker": "Cineteatro", "title": "Ti piace il <em><span style=\"text-decoration: underline;\">cinema?</span></em><br>Ecco gli ultimi aggiornamenti.", "buttonText": "Scopri le info"} -->
<!-- wp:paragraph -->
<p>Qui troverai tutte le ultime notizie, inoltre potrai comodamente prenotare i tuoi biglietti tramite questo <a href="https://nembro.18tickets.it/">link</a>.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[display-posts category="Cinema" wrapper="div" include_content="true" posts_per_page="1" wrapper_id="cinema-wrapper-home"]
<!-- /wp:shortcode -->
<!-- /wp:sanfilipponeri/slide -->
<!-- /wp:sanfilipponeri/slider -->
